<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GenderType;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Notification;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function show($id)
    {
        // Validate id parameter
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('home')->with('error', 'ID tidak valid');
        }

        // Authorization: User can only view their own profile
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::id() != $id) {
            abort(403, 'Anda tidak memiliki akses ke profil ini.');
        }

        $user = User::with([
            'reservasi.status',
            'pembayaran.status',
            'pembayaran.details.menu',
            'pembayaran.paymentMethod',
            'pembayaran.orderType'
        ])->findOrFail($id);

        $reservasiOngoing = $user->reservasi->filter(function ($r) {
            return $r->tanggal_reservasi >= now();
        })->sortBy('tanggal_reservasi');

        $reservasiRiwayat = $user->reservasi->filter(function ($r) {
            return $r->tanggal_reservasi < now();
        })->sortByDesc('tanggal_reservasi');

        $riwayatPesanan = $user->pembayaran->sortByDesc('order_date');

        return view('customers.profile', compact('user', 'reservasiOngoing', 'reservasiRiwayat', 'riwayatPesanan'));
    }

    public function edit($id)
    {
        // Validate id parameter
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('home')->with('error', 'ID tidak valid');
        }

        // Authorization: User can only edit their own profile
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::id() != $id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        $user = User::findOrFail($id);
        $genders = GenderType::all();

        return view('customers.edit_profile', compact('user', 'genders'));
    }

    public function update(Request $request, $id)
    {
        // Validate id parameter
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('home')->with('error', 'ID tidak valid');
        }

        // Authorization: User can only update their own profile
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::id() != $id) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah profil ini.');
        }

        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'no_telp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'gender_id' => 'required|exists:gender_types,id',
            'alamat' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'no_telp.regex' => 'Nomor telepon harus 10-15 digit angka',
            'password.min' => 'Password minimal 8 karakter',
            'profile_picture.image' => 'File harus berupa gambar',
            'profile_picture.mimes' => 'Format gambar harus jpeg, jpg, png, atau gif',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB'
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
        $user->gender_id = $request->gender_id;
        $user->alamat = $request->alamat;
        $user->save();

        return redirect()->route('profile.show', ['id' => $user->id])
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function showOrder($userId, $orderId)
    {
        // Validate parameters
        if (!is_numeric($userId) || $userId <= 0 || !is_numeric($orderId) || $orderId <= 0) {
            return redirect()->route('profile.show', ['id' => Auth::id()])->with('error', 'Parameter tidak valid');
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Authorization check
        if (Auth::id() != $userId) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Get order with authorization check
        $order = Pembayaran::with([
            'details.menu',
            'paymentMethod',
            'orderType',
            'status',
            'user'
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        // Calculate totals
        $subtotal = 0;
        foreach ($order->details as $detail) {
            $detail->total = $detail->quantity * $detail->price_per_item;
            $subtotal += $detail->total;
        }

        // You can add tax or service charge here if needed
        $tax = 0; // 0% for now
        $total = $subtotal + $tax;

        return view('customers.history.order_detail', compact('order', 'subtotal', 'tax', 'total'));
    }

    public function cancelOrder(Request $request, $userId, $orderId)
    {
        // Validate parameters
        if (!is_numeric($userId) || $userId <= 0 || !is_numeric($orderId) || $orderId <= 0) {
            return redirect()->route('profile.show', ['id' => Auth::id()])->with('error', 'Parameter tidak valid');
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Authorization check
        if (Auth::id() != $userId) {
            abort(403, 'Anda tidak memiliki akses untuk membatalkan pesanan ini.');
        }

        // Get order with authorization check
        $order = Pembayaran::where('user_id', Auth::id())
            ->findOrFail($orderId);

        // Only allow cancellation if order is still pending (status_id = 2 based on PaymentStatusSeeder)
        if ($order->status_id != 2) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan. Status: ' . $order->status->status_name);
        }

        // Update status to cancelled (status_id = 3 based on PaymentStatusSeeder)
        $order->status_id = 3;
        $order->save();

        // Create notification
        Notification::create([
            'user_id' => $userId,
            'type' => 'order_cancelled',
            'title' => 'Pesanan Dibatalkan',
            'message' => 'Pesanan Anda dengan ID #' . $order->id . ' telah berhasil dibatalkan.',
            'link' => route('profile.show', ['id' => $userId]),
            'is_read' => false
        ]);

        return redirect()->route('profile.show', ['id' => $userId])
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function cancelReservation(Request $request, $userId, $reservationId)
    {
        // Validate parameters
        if (!is_numeric($userId) || $userId <= 0 || !is_numeric($reservationId) || $reservationId <= 0) {
            return redirect()->route('profile.show', ['id' => Auth::id()])->with('error', 'Parameter tidak valid');
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Authorization check
        if (Auth::id() != $userId) {
            abort(403, 'Anda tidak memiliki akses untuk membatalkan reservasi ini.');
        }

        // Get reservation with authorization check
        $reservasi = Reservasi::where('user_id', Auth::id())
            ->findOrFail($reservationId);

        // Check if reservation can be cancelled
        // Only pending (1) or confirmed (2) reservations can be cancelled
        if ($reservasi->status_id == 3) {
            return redirect()->back()->with('error', 'Reservasi ini sudah dibatalkan sebelumnya.');
        }

        // Check if reservation date is not in the past
        if (Carbon::parse($reservasi->tanggal_reservasi)->isPast()) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan reservasi yang sudah lewat.');
        }

        // Check if reservation is less than 2 hours away
        $reservationTime = Carbon::parse($reservasi->tanggal_reservasi);
        $hoursUntilReservation = now()->diffInHours($reservationTime, false);
        
        if ($hoursUntilReservation < 2 && $hoursUntilReservation > 0) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan reservasi kurang dari 2 jam sebelum waktu reservasi. Silakan hubungi restoran.');
        }

        // Update status to cancelled (status_id = 3)
        $reservasi->status_id = 3;
        $reservasi->save();

        // Create notification
        Notification::create([
            'user_id' => $userId,
            'type' => 'reservation_cancelled',
            'title' => 'Reservasi Dibatalkan',
            'message' => 'Reservasi Anda dengan kode ' . $reservasi->kode_reservasi . ' telah berhasil dibatalkan.',
            'link' => route('profile.show', ['id' => $userId]),
            'is_read' => false
        ]);

        return redirect()->route('profile.show', ['id' => $userId])
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
}