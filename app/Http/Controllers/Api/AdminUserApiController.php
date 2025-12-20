<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserApiController extends Controller
{
    // GET /api/admin/users
    public function index()
    {
        $users = User::with(['role', 'gender'])->get()->map(fn($u) => [
            'id' => $u->id,
            'nama' => $u->nama,
            'username' => $u->username,
            'email' => $u->email,
            'role' => $u->role->role_name ?? 'N/A',
            'gender' => $u->gender->gender_name ?? 'N/A',
            'no_telp' => $u->no_telp,
            'alamat' => $u->alamat,
        ]);
        return response()->json(['success' => true, 'data' => $users], 200);
    }

    // DELETE /api/admin/users/{id}
    public function destroy($id)
    {
        $deleted = User::destroy($id);
        return response()->json([
            'success' => (bool)$deleted,
            'message' => $deleted ? 'User dihapus' : 'User tidak ditemukan',
        ], $deleted ? 200 : 404);
    }
}
