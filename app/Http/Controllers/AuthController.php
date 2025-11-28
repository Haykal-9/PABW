<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GenderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Tampilkan Form Register
    public function showRegister()
    {
        $genders = GenderType::all();
        return view('register', compact('genders'));
    }

    // 2. Proses Simpan Data (Create & Upload)
    public function processRegister(Request $request)
    {
        // Validasi Input
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'no_telp' => 'required',
            'gender_id' => 'required',
            'alamat' => 'required',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Logic Upload File
        $nama_file = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            // Buat nama unik: waktu_namaasli.jpg
            $nama_file = time() . "_" . $file->getClientOriginalName();
            // Simpan ke folder public/uploads/profile
            $file->move(public_path('uploads/profile'), $nama_file);
        }

        // Simpan ke Database
        User::create([
            'role_id' => 3, // ID 3 biasanya untuk Member/Customer (sesuai seeder)
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password (Wajib!)
            // Jika database kamu pakai MD5 (tidak disarankan tapi sesuai file SQL lama):
            // 'password' => md5($request->password), 
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