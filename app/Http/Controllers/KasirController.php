<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\pembayaran;
use App\Models\detailPembayaran;

class KasirController extends Controller
{
    /**
     * Menampilkan halaman utama kasir.
     */
    public function index()
    {
        // Ambil data menu dari database (hanya yang tersedia)
        $menuData = menu::where('status_id', 1) // status_id = 1 untuk 'tersedia'
            ->orderBy('type_id')
            ->orderBy('nama')
            ->get();

        // Format data menu untuk JavaScript
        $menu = $menuData->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'harga' => $item->price,
                'img' => $item->url_foto
                    ? asset('storage/menu/' . $item->url_foto)
                    : 'https://placehold.co/250x160/3b2e26/ffffff?text=' . urlencode($item->nama)
            ];
        })->toArray();

        // Data keranjang awal kosong (bisa disesuaikan sesuai kebutuhan)
        $order_items = [];

        return view('kasir.kasir', [
            'title' => 'Tapal Kuda | Kasir',
            'activePage' => 'kasir', // Variabel untuk menandai menu aktif di sidebar
            'menu' => $menu,
            'order_items' => $order_items,
        ]);
    }

    /**
     * Menampilkan halaman reservasi.
     */
    public function reservasikasir()
    {
        $reservasi = [
            ['kode' => 'RSV-001', 'nama' => 'Aqila', 'email' => 'aqila@example.com', 'no_telp' => '0812-1111-2222', 'jumlah_orang' => 2, 'tanggal' => '2025-10-21', 'pesan' => 'Non-smoking, dekat jendela'],
            ['kode' => 'RSV-002', 'nama' => 'Haykal', 'email' => 'haykal@example.com', 'no_telp' => '0813-3333-4444', 'jumlah_orang' => 4, 'tanggal' => '2025-10-22', 'pesan' => 'Butuh stop kontak'],
            ['kode' => 'RSV-003', 'nama' => 'Ega', 'email' => 'ega@example.com', 'no_telp' => '0815-5555-6666', 'jumlah_orang' => 3, 'tanggal' => '2025-10-23', 'pesan' => 'Kursi sofa'],
        ];

        return view('kasir.reservasi', [
            'title' => 'Tapal Kuda | Reservasi',
            'activePage' => 'reservasi',
            'reservasi' => $reservasi,
        ]);
    }

    /**
     * Menampilkan halaman notifikasi.
     */
    public function notif()
    {
        $notifikasi = [
            ['judul' => 'Pesanan #INV-1023 selesai', 'waktu' => 'Baru saja', 'isi' => 'Pesanan meja 5 sudah dibayar.'],
            ['judul' => 'Stok hampir habis', 'waktu' => '10 menit lalu', 'isi' => 'Kopi robusta tinggal 2 pack.'],
            ['judul' => 'Reservasi baru', 'waktu' => '1 jam lalu', 'isi' => 'RSV-003 untuk 3 orang pada 23 Okt.'],
        ];

        return view('kasir.notif', [
            'title' => 'Tapal Kuda | Notifikasi',
            'activePage' => 'notifikasi',
            'notifikasi' => $notifikasi,
        ]);
    }

    /**
     * Menampilkan halaman riwayat pesanan.
     */
    public function riwayat()
    {
        $riwayat = [
            ['kode' => 'INV-1023', 'tanggal' => '2025-10-19', 'pelanggan' => 'Diki', 'total' => 54000, 'status' => 'Selesai'],
            ['kode' => 'INV-1022', 'tanggal' => '2025-10-19', 'pelanggan' => 'Zahara', 'total' => 37000, 'status' => 'Selesai'],
            ['kode' => 'INV-1021', 'tanggal' => '2025-10-18', 'pelanggan' => 'Aqila', 'total' => 18000, 'status' => 'Batal'],
        ];

        // Data dummy untuk detail struk. Di aplikasi nyata, ini akan diambil dari database berdasarkan kode.
        $detailStruk = [
            'INV-1023' => ['kasir' => 'Kasir Tapal Kuda', 'items' => [['nama' => 'Latte', 'qty' => 1, 'harga' => 24000], ['nama' => 'Espresso', 'qty' => 2, 'harga' => 15000]], 'pajak' => 0.10, 'diskon' => 0],
            'INV-1022' => ['kasir' => 'Kasir Tapal Kuda', 'items' => [['nama' => 'Cappuccino', 'qty' => 1, 'harga' => 22000], ['nama' => 'Americano', 'qty' => 1, 'harga' => 15000]], 'pajak' => 0.10, 'diskon' => 0],
            'INV-1021' => ['kasir' => 'Kasir Tapal Kuda', 'items' => [['nama' => 'Americano', 'qty' => 1, 'harga' => 18000]], 'pajak' => 0.10, 'diskon' => 0],
        ];


        return view('kasir.riwayat', [
            'title' => 'Tapal Kuda | Riwayat Pesanan',
            'activePage' => 'riwayat',
            'riwayat' => $riwayat,
            'detailStruk' => $detailStruk,
        ]);
    }

    public function profile()
    {
        $user = [
            'nama' => 'Kasir Tapal Kuda',
            'email' => 'kasir@tapalkuda.com',
            'telepon' => '0812-3456-7890',
            'foto' => 'https://placehold.co/140x140/54453d/ffffff?text=Kasir',
        ];

        return view('kasir.profile', [
            'title' => 'Tapal Kuda | Profile',
            'activePage' => 'profile',
            'user' => $user,
        ]);
    }

    /**
     * Process payment and save transaction
     */
    public function processPayment(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'customer_name' => 'nullable|string|max:100',
                'order_type' => 'required|string',
                'payment_method' => 'required|string',
                'items' => 'required|array|min:1',
                'subtotal' => 'required|numeric',
                'tax' => 'required|numeric',
                'total' => 'required|numeric',
            ]);

            // Map payment method to ID
            $paymentMethodMap = [
                'Cash' => 1,
                'E-Wallet' => 2,
                'QRIS' => 3,
            ];

            // Map order type to ID
            $orderTypeMap = [
                'Dine In' => 1,
                'Take Away' => 2,
            ];

            // Create payment record
            $payment = pembayaran::create([
                'user_id' => 2, // Hardcoded to kasir user (id=2)
                'order_date' => now(),
                'status_id' => 1, // completed
                'payment_method_id' => $paymentMethodMap[$request->payment_method] ?? 1,
                'order_type_id' => $orderTypeMap[$request->order_type] ?? 1,
            ]);

            // Create payment details
            foreach ($request->items as $item) {
                detailPembayaran::create([
                    'pembayaran_id' => $payment->id,
                    'menu_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price_per_item' => $item['price'],
                    'item_notes' => $request->customer_name ?? null,
                ]);
            }

            // Return success response with transaction data
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diproses',
                'data' => [
                    'transaction_id' => $payment->id,
                    'invoice_number' => 'INV-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT),
                    'customer_name' => $request->customer_name ?? 'Guest',
                    'order_date' => $payment->order_date->format('d-m-Y H:i:s'),
                    'order_type' => $request->order_type,
                    'payment_method' => $request->payment_method,
                    'items' => $request->items,
                    'subtotal' => $request->subtotal,
                    'tax' => $request->tax,
                    'total' => $request->total,
                    'kasir' => 'Kasir Tapal Kuda',
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
