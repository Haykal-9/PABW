<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\menu;
use App\Models\pembayaran;
use App\Models\detailPembayaran;
use App\Models\reservasi;

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
                    ? asset('foto/' . $item->url_foto)
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
        // Ambil semua reservasi dengan status pending (status_id = 1)
        $reservasiData = reservasi::with('user', 'status')
            ->where('status_id', 1) // 1 = pending
            ->orderBy('created_at', 'desc')
            ->get();

        // Format data untuk view
        $reservasi = $reservasiData->map(function ($item) {
            return [
                'id' => $item->id,
                'kode' => $item->kode_reservasi,
                'nama' => $item->user->nama ?? 'N/A',
                'email' => $item->user->email ?? 'N/A',
                'no_telp' => $item->user->no_telp ?? 'N/A',
                'jumlah_orang' => $item->jumlah_orang,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal_reservasi)->format('d M Y H:i'),
                'pesan' => $item->message ?? '-',
                'status' => $item->status->status_name ?? 'pending',
            ];
        });

        return view('kasir.reservasi', [
            'title' => 'Tapal Kuda | Reservasi',
            'activePage' => 'reservasi',
            'reservasi' => $reservasi,
        ]);
    }

    /**
     * Menerima/approve reservasi
     */
    public function approve($id)
    {
        try {
            $reservasi = reservasi::findOrFail($id);

            // Update status menjadi dikonfirmasi (status_id = 2)
            $reservasi->status_id = 2;
            $reservasi->save();

            return redirect()->route('kasir.reservasi')
                ->with('success', 'Reservasi berhasil dikonfirmasi!');
        } catch (\Exception $e) {
            return redirect()->route('kasir.reservasi')
                ->with('error', 'Gagal mengkonfirmasi reservasi: ' . $e->getMessage());
        }
    }

    /**
     * Menolak reservasi
     */
    public function reject(Request $request, $id)
    {
        try {
            $reservasi = reservasi::findOrFail($id);

            // Update status menjadi dibatalkan (status_id = 3)
            $reservasi->status_id = 3;
            $reservasi->save();

            // Simpan alasan penolakan jika ada tabel reservasi_ditolak
            if ($request->has('alasan')) {
                \DB::table('reservasi_ditolak')->insert([
                    'reservation_id' => $id,
                    'alasan_ditolak' => $request->alasan,
                    'ditolak_oleh' => Auth::user()->nama, // Nama user yang sedang login
                    'cancelled_at' => now(),
                ]);
            }

            return redirect()->route('kasir.reservasi')
                ->with('success', 'Reservasi berhasil ditolak!');
        } catch (\Exception $e) {
            return redirect()->route('kasir.reservasi')
                ->with('error', 'Gagal menolak reservasi: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman notifikasi.
     */
    public function notif()
    {
        $notifikasi = [];
        $now = now();

        // 1. Notifikasi Pesanan Selesai (24 jam terakhir)
        $completedOrders = pembayaran::with('user')
            ->where('status_id', 1) // completed
            ->where('order_date', '>=', $now->copy()->subHours(24))
            ->orderBy('order_date', 'desc')
            ->get();

        foreach ($completedOrders as $order) {
            $notifikasi[] = [
                'judul' => 'Pesanan #INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' selesai',
                'waktu' => $this->getRelativeTime($order->order_date),
                'isi' => 'Pesanan dari ' . ($order->user->nama ?? 'Guest') . ' telah diselesaikan.',
                'type' => 'completed',
                'timestamp' => strtotime($order->order_date),
            ];
        }

        // 2. Notifikasi Pesanan Dibatalkan (24 jam terakhir)
        $cancelledOrders = pembayaran::with('user')
            ->where('status_id', 3) // cancelled
            ->where('order_date', '>=', $now->copy()->subHours(24))
            ->orderBy('order_date', 'desc')
            ->get();

        foreach ($cancelledOrders as $order) {
            $notifikasi[] = [
                'judul' => 'Pesanan #INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' dibatalkan',
                'waktu' => $this->getRelativeTime($order->order_date),
                'isi' => 'Pesanan dari ' . ($order->user->nama ?? 'Guest') . ' telah dibatalkan.',
                'type' => 'cancelled',
                'timestamp' => strtotime($order->order_date),
            ];
        }

        // 3. Notifikasi Reservasi Baru (status pending atau dibuat dalam 24 jam terakhir)
        $newReservations = reservasi::with('user')
            ->where(function ($query) use ($now) {
                $query->where('status_id', 1) // pending
                    ->orWhere('created_at', '>=', $now->copy()->subHours(24));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($newReservations as $reservation) {
            $notifikasi[] = [
                'judul' => 'Reservasi baru - ' . $reservation->kode_reservasi,
                'waktu' => $this->getRelativeTime($reservation->created_at),
                'isi' => 'Reservasi dari ' . ($reservation->user->nama ?? 'Tamu') . ' untuk ' . $reservation->jumlah_orang . ' orang pada ' . date('d M Y', strtotime($reservation->tanggal_reservasi)) . '.',
                'type' => 'reservation',
                'timestamp' => strtotime($reservation->created_at),
            ];
        }

        // 4. Notifikasi Stok Hampir Habis (menu dengan status habis)
        $lowStockItems = menu::where('status_id', 2) // habis/out of stock
            ->get();

        foreach ($lowStockItems as $item) {
            $notifikasi[] = [
                'judul' => 'Stok habis - ' . $item->nama,
                'waktu' => 'Sekarang',
                'isi' => 'Menu "' . $item->nama . '" sudah habis dan perlu segera diisi ulang.',
                'type' => 'low_stock',
                'timestamp' => time(), // Current time for sorting
            ];
        }

        // Sort semua notifikasi berdasarkan timestamp (terbaru di atas)
        usort($notifikasi, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        return view('kasir.notif', [
            'title' => 'Tapal Kuda | Notifikasi',
            'activePage' => 'notifikasi',
            'notifikasi' => $notifikasi,
        ]);
    }

    /**
     * Helper function untuk mengkonversi waktu ke format relatif
     */
    private function getRelativeTime($datetime)
    {
        $now = time();
        $time = strtotime($datetime);
        $diff = $now - $time;

        if ($diff < 60) {
            return 'Baru saja';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . ' menit lalu';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' jam lalu';
        } else {
            $days = floor($diff / 86400);
            return $days . ' hari lalu';
        }
    }

    /**
     * Menampilkan halaman riwayat pesanan.
     */
    public function riwayat()
    {
        // Ambil data pembayaran dari database dengan relasi
        $pembayaranData = pembayaran::with([
            'user',
            'details.menu',
            'payment_method',
            'order_type',
            'status'
        ])
            ->orderBy('order_date', 'desc')
            ->get();

        // Format data riwayat untuk tabel
        $riwayat = $pembayaranData->map(function ($pembayaran) {
            return [
                'kode' => 'INV-' . str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT),
                'tanggal' => date('Y-m-d', strtotime($pembayaran->order_date)),
                'pelanggan' => $pembayaran->user->nama ?? 'Guest',
                'total' => $pembayaran->details->sum(function ($detail) {
                    return $detail->quantity * $detail->price_per_item;
                }),
                'status' => $pembayaran->status->status_name === 'completed' ? 'Selesai' :
                    ($pembayaran->status->status_name === 'cancelled' ? 'Batal' : 'Pending'),
            ];
        })->toArray();

        // Format data detail struk untuk modal
        $detailStruk = [];
        foreach ($pembayaranData as $pembayaran) {
            $kode = 'INV-' . str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT);

            // Hitung items untuk detail struk
            $items = $pembayaran->details->map(function ($detail) {
                return [
                    'nama' => $detail->menu->nama ?? 'Unknown',
                    'qty' => $detail->quantity,
                    'harga' => $detail->price_per_item,
                ];
            })->toArray();

            $detailStruk[$kode] = [
                'kasir' => 'Kasir Tapal Kuda',
                'items' => $items,
                'pajak' => 0.10, // 10% pajak
                'diskon' => 0,
            ];
        }

        return view('kasir.riwayat', [
            'title' => 'Tapal Kuda | Riwayat Pesanan',
            'activePage' => 'riwayat',
            'riwayat' => $riwayat,
            'detailStruk' => $detailStruk,
        ]);
    }

    public function profile()
    {
        // Ambil data user yang sedang login
        $userData = Auth::user();
        $userData->load('role', 'gender');

        if (!$userData) {
            return redirect()->route('kasir.index')->with('error', 'User tidak ditemukan.');
        }

        // Hitung statistik (contoh: total transaksi dari tabel pembayaran)
        $totalTransaksi = pembayaran::where('user_id', $userData->id)->count();

        // Format data untuk view
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
    public function editProfile()
    {
        // Ambil data user yang sedang login
        $userData = Auth::user();
        $userData->load('role', 'gender');

        if (!$userData) {
            return redirect()->route('kasir.index')->with('error', 'User tidak ditemukan.');
        }

        // Format data untuk view
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
    public function updateProfile(Request $request)
    {
        try {
            // Ambil user yang sedang login
            $userId = Auth::id();
            $user = \App\Models\User::findOrFail($userId);

            // Validate request
            $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:users,username,' . $userId,
                'email' => 'required|email|max:100|unique:users,email,' . $userId,
                'telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'password' => 'nullable|min:6|confirmed',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Update data user
            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->no_telp = $request->telepon;
            $user->alamat = $request->alamat;

            // Update password jika diisi
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            // Handle foto upload if provided
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $namaFile = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $namaFile);

                // Hapus foto lama jika ada (kecuali default)
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
                'user_id' => Auth::id(), // User kasir yang sedang login
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

    /**
     * Menampilkan halaman manajemen menu untuk kasir
     */
    public function menuManagement()
    {
        // Fetch all menus from database with type and status relationships
        $menuData = menu::with(['type', 'status'])
            ->orderBy('type_id')
            ->orderBy('nama')
            ->get();

        // Format data for view
        $menus = $menuData->map(function ($m) {
            return [
                'id' => $m->id,
                'nama' => $m->nama,
                'kategori' => $m->type->type_name ?? 'N/A',
                'type_id' => $m->type_id,
                'harga' => $m->price,
                'status' => ucfirst($m->status->status_name ?? 'N/A'),
                'status_id' => $m->status_id,
                'image_path' => $m->url_foto ? 'foto/' . $m->url_foto : null,
                'deskripsi' => $m->deskripsi,
            ];
        })->toArray();

        return view('kasir.menu', [
            'title' => 'Tapal Kuda | Manajemen Menu',
            'activePage' => 'menu',
            'menus' => $menus,
        ]);
    }

    /**
     * Store new menu
     */
    public function storeMenu(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'nama' => 'required|string|max:100',
                'kategori' => 'required|integer',
                'harga' => 'required|numeric|min:0',
                'status' => 'required|integer|in:1,2',
                'deskripsi' => 'nullable|string',
                'foto_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle file upload
            $path_to_save = null;
            if ($request->hasFile('foto_upload')) {
                $file = $request->file('foto_upload');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('foto'), $namaFile);
                $path_to_save = $namaFile;
            }

            // Create menu
            menu::create([
                'nama' => $request->nama,
                'url_foto' => $path_to_save,
                'type_id' => $request->kategori,
                'price' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'status_id' => $request->status,
            ]);

            return redirect()->route('kasir.menu')->with('success', 'Menu "' . $request->nama . '" berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('kasir.menu')->with('error', 'Gagal menambahkan menu: ' . $e->getMessage());
        }
    }

    /**
     * Update existing menu
     */
    public function updateMenu(Request $request, $id)
    {
        try {
            $menu = menu::find($id);

            if (!$menu) {
                return redirect()->route('kasir.menu')->with('error', 'Menu tidak ditemukan.');
            }

            // Validate request
            $request->validate([
                'nama' => 'required|string|max:100',
                'kategori' => 'required|integer',
                'harga' => 'required|numeric|min:0',
                'status' => 'required|integer|in:1,2',
                'deskripsi' => 'nullable|string',
                'foto_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle file upload
            $path_to_save = $menu->url_foto;

            if ($request->hasFile('foto_upload')) {
                // Delete old file if exists
                if ($menu->url_foto) {
                    $oldPath = public_path('foto/' . $menu->url_foto);
                    if (\File::exists($oldPath)) {
                        \File::delete($oldPath);
                    }
                }

                // Upload new file
                $file = $request->file('foto_upload');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('foto'), $namaFile);
                $path_to_save = $namaFile;
            }

            // Update menu
            $menu->update([
                'nama' => $request->nama,
                'url_foto' => $path_to_save,
                'type_id' => $request->kategori,
                'price' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'status_id' => $request->status,
            ]);

            return redirect()->route('kasir.menu')->with('success', 'Menu "' . $request->nama . '" berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('kasir.menu')->with('error', 'Gagal memperbarui menu: ' . $e->getMessage());
        }
    }

    /**
     * Delete menu
     */
    public function destroyMenu($id)
    {
        try {
            $menu = menu::find($id);

            if (!$menu) {
                return response('Menu tidak ditemukan.', 404);
            }

            // Delete file if exists
            if ($menu->url_foto) {
                $filePath = public_path('foto/' . $menu->url_foto);
                if (\File::exists($filePath)) {
                    \File::delete($filePath);
                }
            }

            $menu->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return response('Gagal menghapus menu: ' . $e->getMessage(), 500);
        }
    }
}

