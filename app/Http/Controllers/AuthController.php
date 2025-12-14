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

        User::create([
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
            // Auth::login($user); // Manual login needed since we are not using standard Auth::attempt here with 'web' guard automatically? 
            // Wait, Hash::check confirms password but doesn't log them in. 
            // We should use Auth::login($user) or regenerate session if not using Auth::attempt.
            // However, the original code didn't show Auth::login, it just redirected. 
            // Laravel's standard way is Auth::attempt. 
            // Let's stick to the user's flow but ensure they are actually logged in.

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

        // Ensure cart is cleared (though invalidate() should do it)
        // $request->session()->forget('cart'); 

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}