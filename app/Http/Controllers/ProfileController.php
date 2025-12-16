<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GenderType;
use App\Models\Pembayaran;

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

    /**
     * Display the specified order detail.
     */
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

    /**
     * Cancel an order
     */
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
}