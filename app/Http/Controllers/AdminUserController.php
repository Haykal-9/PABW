<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get()->map(fn($u) => [
            'id' => $u->id,
            'nama' => $u->nama,
            'email' => $u->email,
            'role' => ucwords($u->role->role_name ?? 'N/A'),
            'terdaftar' => $u->created_at ? $u->created_at->format('Y-m-d') : 'N/A',
        ]);
        
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|integer|in:1,2,3',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'no_telp' => 'nullable|string|max:20',
            'gender_id' => 'nullable|integer|in:1,2',
            'alamat' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto profil jika ada
        $profilePath = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Buat folder jika belum ada
            $uploadPath = public_path('uploads/profiles');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $filename);
            $profilePath = $filename;
        }

        // Buat user baru
        User::create([
            'role_id' => $validated['role_id'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'] ?? null,
            'gender_id' => $validated['gender_id'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'profile_picture' => $profilePath,
        ]);

        \Log::info('User baru ditambahkan oleh ' . Auth::user()->nama . ' (ID: ' . Auth::id() . ')');
        
        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($id == Auth::id()) {
            return response()->json(['error' => 'Tidak dapat menghapus akun sendiri'], 403);
        }
        
        $user = User::find($id);
        $deleted = User::destroy($id);

        if ($deleted) {
            \Log::info('User ' . ($user->nama ?? 'ID ' . $id) . ' dihapus oleh ' . Auth::user()->nama . ' (ID: ' . Auth::id() . ')');
            return response()->noContent();
        }
    }
}
