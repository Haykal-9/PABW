<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\genderType;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Get daftar gender untuk form register
     */
    public function getGenders()
    {
        $genders = genderType::all();

        return response()->json([
            'success' => true,
            'data' => $genders->map(function ($g) {
                return [
                    'id' => $g->id,
                    'name' => $g->gender_name,
                ];
            }),
        ], 200);
    }

    /**
     * Login dengan username ATAU email
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // bisa username atau email
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username ATAU email
        $user = User::where('username', $request->login)
            ->orWhere('email', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Username/email atau password salah.'],
            ]);
        }

        // Hapus token lama
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'role' => $user->role->role_name ?? 'N/A',
                    'no_telp' => $user->no_telp,
                    'gender' => $user->gender->gender_name ?? null,
                    'alamat' => $user->alamat,
                    'profile_picture' => $user->profile_picture,
                ],
                'token' => $token,
            ],
        ], 200);
    }

    /**
     * Logout dan hapus token
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
        ], 200);
    }

    /**
     * Get user yang sedang login
     */
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'email' => $user->email,
                'role' => $user->role->role_name ?? 'N/A',
                'no_telp' => $user->no_telp,
                'gender' => $user->gender->gender_name ?? null,
                'gender_id' => $user->gender_id,
                'alamat' => $user->alamat,
                'profile_picture' => $user->profile_picture,
            ],
        ], 200);
    }

    /**
     * Register user baru (dengan file upload)
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6|confirmed',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'no_telp' => 'nullable|string|max:20',
            'gender_id' => 'nullable|exists:gender_types,id',
            'alamat' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload
        $nama_file = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $nama_file);
        }

        $user = User::create([
            'role_id' => 3, // Default role: customer
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'gender_id' => $request->gender_id,
            'alamat' => $request->alamat,
            'profile_picture' => $nama_file,
        ]);

        // Buat notifikasi untuk admin
        Notification::create([
            'user_id' => 1,
            'type' => 'user_registered',
            'title' => 'User Baru Terdaftar',
            'message' => 'User baru dengan nama ' . $user->nama . ' telah mendaftar.',
            'link' => null,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful. Please login.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'nama' => $user->nama,
                    'email' => $user->email,
                ],
            ],
        ], 201);
    }
}

