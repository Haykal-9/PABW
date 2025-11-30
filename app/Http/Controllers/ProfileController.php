<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\GenderType;

class ProfileController extends Controller
{
    // 1. READ-ONLY: Halaman Lihat Profil
    public function show($id)
    {
        // 1. Ambil User beserta data relasinya (Eager Loading biar cepat)
        $user = User::with(['reservasi.status', 'pembayaran.status'])->find($id);

        if (!$user) {
            return redirect('/')->with('error', 'User tidak ditemukan');
        }

        // 2. Pisahkan Reservasi (Ongoing vs History)
        // Ongoing: Tanggalnya hari ini atau masa depan, DAN statusnya bukan 'dibatalkan' (id 3)
        $reservasiOngoing = $user->reservasi->filter(function ($r) {
            return $r->tanggal_reservasi >= now() && $r->status_id != 3;
        })->sortBy('tanggal_reservasi'); // Urutkan dari yang terdekat

        // Riwayat: Tanggal masa lalu ATAU statusnya dibatalkan
        $reservasiRiwayat = $user->reservasi->filter(function ($r) {
            return $r->tanggal_reservasi < now() || $r->status_id == 3;
        })->sortByDesc('tanggal_reservasi'); // Urutkan dari yang terbaru

        // 3. Ambil Riwayat Pesanan (Urutkan dari terbaru)
        $riwayatPesanan = $user->pembayaran->sortByDesc('order_date');

        return view('customers.profile', compact('user', 'reservasiOngoing', 'reservasiRiwayat', 'riwayatPesanan'));
    }

    // 2. FORM: Halaman Edit Profil
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user)
            return redirect('/')->with('error', 'User tidak ditemukan');

        // Kita butuh data gender untuk dropdown
        $genders = GenderType::all();

        return view('customers.edit_profile', compact('user', 'genders'));
    }

    // 3. ACTION: Proses Update
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telp' => 'required',
            'alamat' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $pathLama = public_path('uploads/profile/' . $user->profile_picture);
            if ($user->profile_picture && File::exists($pathLama)) {
                File::delete($pathLama);
            }
            $file = $request->file('profile_picture');
            $namaFile = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $namaFile);
            $user->profile_picture = $namaFile;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->gender_id = $request->gender_id; // Pastikan ini tersimpan
        $user->alamat = $request->alamat;
        $user->save();

        // Redirect KEMBALI KE HALAMAN PROFIL (Read Only)
        return redirect()->route('profile.show', ['id' => $user->id])
            ->with('success', 'Profil berhasil diperbarui!');
    }
}