<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\pembayaran;

class KasirProfileApiController extends Controller
{
    /**
     * Get kasir profile
     */
    public function show()
    {
        $userData = Auth::user();
        $userData->load('role', 'gender');

        $totalTransaksi = pembayaran::where('user_id', $userData->id)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $userData->id,
                'nama' => $userData->nama,
                'username' => $userData->username,
                'email' => $userData->email,
                'no_telp' => $userData->no_telp,
                'alamat' => $userData->alamat,
                'role' => $userData->role->role_name ?? 'Kasir',
                'gender' => $userData->gender->gender_name ?? null,
                'gender_id' => $userData->gender_id,
                'profile_picture' => $userData->profile_picture
                    ? asset('uploads/avatars/' . $userData->profile_picture)
                    : null,
                'total_transaksi' => $totalTransaksi,
                'tanggal_bergabung' => $userData->created_at->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * Update kasir profile
     */
    public function update(Request $request)
    {
        try {
            $userId = Auth::id();
            $user = User::findOrFail($userId);

            $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:users,username,' . $userId,
                'email' => 'required|email|max:100|unique:users,email,' . $userId,
                'no_telp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'password' => 'nullable|min:6|confirmed',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->no_telp = $request->no_telp;
            $user->alamat = $request->alamat;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $namaFile = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $namaFile);

                // Delete old file
                if ($user->profile_picture && $user->profile_picture !== 'default-avatar.png') {
                    $oldFile = public_path('uploads/avatars/' . $user->profile_picture);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $user->profile_picture = $namaFile;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'data' => [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'email' => $user->email,
                    'profile_picture' => $user->profile_picture
                        ? asset('uploads/avatars/' . $user->profile_picture)
                        : null,
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
            ], 500);
        }
    }
}
