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
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function show($id)
    {
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
        // Authorization: User can only update their own profile
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::id() != $id) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah profil ini.');
        }

        $user = User::findOrFail($id);

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

        return redirect()->route('profile.show', ['id' => $userId])
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function cancelReservation(Request $request, $userId, $reservationId)
    {
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

        return redirect()->route('profile.show', ['id' => $userId])
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
}