<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\pembayaran;

class KasirProfileController extends Controller
{
    /**
     * Menampilkan halaman profile kasir.
     */
    public function index()
    {
        $userData = Auth::user();
        $userData->load('role', 'gender');

        if (!$userData) {
            return redirect()->route('kasir.index')->with('error', 'User tidak ditemukan.');
        }

        $totalTransaksi = pembayaran::where('status_id', 1) // status completed
            ->whereDate('order_date', \Carbon\Carbon::today())
            ->count();

        $user = [
            'id' => $userData->id,
            'nama' => $userData->nama,
            'username' => $userData->username,
            'email' => $userData->email,
            'telepon' => $userData->no_telp ?? '-',
            'role' => $userData->role->role_name ?? 'Kasir',
            'gender' => $userData->gender->gender_name ?? '-',
            'alamat' => $userData->alamat ?? '-',
            'foto' => $userData->profile_picture
                ? asset('uploads/avatars/' . $userData->profile_picture)
                : 'https://ui-avatars.com/api/?name=' . urlencode($userData->nama) . '&size=200&background=e87b3e&color=fff&bold=true',
            'total_transaksi' => $totalTransaksi,
            'hari_kerja' => '-',
            'shift' => '-',
            'tanggal_bergabung' => \Carbon\Carbon::parse($userData->created_at)->format('d F Y'),
            'status' => 'Aktif',
            'last_login' => date('d M Y, H:i'),
        ];

        return view('kasir.profile', [
            'title' => 'Tapal Kuda | Profile',
            'activePage' => 'profile',
            'user' => $user,
        ]);
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $userData = Auth::user();
        $userData->load('role', 'gender');

        if (!$userData) {
            return redirect()->route('kasir.index')->with('error', 'User tidak ditemukan.');
        }

        $user = [
            'id' => $userData->id,
            'nama' => $userData->nama,
            'username' => $userData->username,
            'email' => $userData->email,
            'telepon' => $userData->no_telp ?? '',
            'alamat' => $userData->alamat ?? '',
            'gender_id' => $userData->gender_id,
            'role' => $userData->role->role_name ?? 'Kasir',
            'foto' => $userData->profile_picture
                ? asset('uploads/avatars/' . $userData->profile_picture)
                : 'https://ui-avatars.com/api/?name=' . urlencode($userData->nama) . '&size=200&background=e87b3e&color=fff&bold=true',
        ];

        return view('kasir.edit-profile', [
            'title' => 'Tapal Kuda | Edit Profile',
            'activePage' => 'profile',
            'user' => $user,
        ]);
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        try {
            $userId = Auth::id();
            $user = \App\Models\User::findOrFail($userId);

            $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:users,username,' . $userId,
                'email' => 'required|email|max:100|unique:users,email,' . $userId,
                'telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'password' => 'nullable|min:6|confirmed',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->no_telp = $request->telepon;
            $user->alamat = $request->alamat;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $namaFile = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $namaFile);

                if ($user->profile_picture && $user->profile_picture !== 'default-avatar.png') {
                    $oldFile = public_path('uploads/avatars/' . $user->profile_picture);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $user->profile_picture = $namaFile;
            }

            $user->save();

            return redirect()->route('kasir.profile')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
