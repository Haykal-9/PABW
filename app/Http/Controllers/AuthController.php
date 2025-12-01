<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GenderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}