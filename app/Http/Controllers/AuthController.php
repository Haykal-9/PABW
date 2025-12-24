<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GenderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        $genders = GenderType::all();
        return view('register', compact('genders'));
    }

    public function processRegister(Request $request)
    {
        $nama_file = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $nama_file);
        }

        $user = User::create([
            'role_id' => 3,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'gender_id' => $request->gender_id,
            'alamat' => $request->alamat,
            'profile_picture' => $nama_file,
        ]);

        // Buat notifikasi untuk admin jika ada user baru
        \App\Models\Notification::create([
            'user_id' => 1, // diasumsikan admin utama id=1
            'type' => 'user_registered',
            'title' => 'User Baru Terdaftar',
            'message' => 'User baru dengan nama ' . $user->nama . ' telah mendaftar.',
            'link' => null,
            'is_read' => false,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function processLogin(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // Log the user in
            $request->session()->regenerate(); // Regenerate session to prevent fixation

            $message = 'Login berhasil! Selamat datang, ' . $user->nama;

            return match ($user->role_id) {
                1 => redirect()->route('admin.dashboard')->with('success', $message),
                2 => redirect()->route('kasir.index')->with('success', $message),
                3 => redirect('/')->with('success', $message),
                default => redirect('/')->with('success', $message),
            };
        }
        return redirect('/login')->with('error', 'Username atau password salah!');
    }

    public function processLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}