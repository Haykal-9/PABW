<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
