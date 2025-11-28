<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\menu;
use App\Models\reservasi;
use App\Models\review;
use App\Models\pembayaran; 
use App\Models\detailPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect; // Ditambahkan untuk Redirect yang lebih bersih

class AdminController extends Controller
{
    // ====================================================================
    // FUNGSI PEMETAAN (MAPPING) DARI STRING KE ID DATABASE
    // ====================================================================

    private function getRoleId(string $roleName): int
    {
        return match (strtolower($roleName)) {
            'admin' => 1,
            'kasir' => 2,
            'customer' => 3,
            'member' => 3,
            default => 3,
        };
    }

    private function getMenuTypeId(string $categoryName): int
    {
        return match (strtolower($categoryName)) {
            'kopi' => 1,
            'non-kopi' => 2,
            'makanan' => 3,
            'cemilan' => 4,
            default => 1,
        };
    }

    private function getMenuStatusId(string $statusName): int
    {
        return match (strtolower($statusName)) {
            'tersedia' => 1,
            'habis' => 2,
            default => 1,
        };
    }

    private function getReservationStatusId(string $statusName): int
    {
        return match (strtolower($statusName)) {
            'dikonfirmasi' => 2,
            'menunggu konfirmasi' => 1,
            'dibatalkan' => 3,
            'selesai' => 2,
            default => 1,
        };
    }

    // ====================================================================
    // HALAMAN ADMIN (MENGAMBIL DATA DARI DB SECARA EKSKLUSIF)
    // ====================================================================
    
    public function dashboard()
    {
        // Mendapatkan ID pembayaran yang statusnya sudah Selesai (Asumsi status_id = 4)
        $completedPaymentIds = pembayaran::where('status_id', 4)->pluck('id');

        // 1. Hitung Subtotal Pendapatan HARI INI
        $subtotalHariIni = detailPembayaran::join('pembayaran', 'detail_pembayaran.pembayaran_id', '=', 'pembayaran.id')
            ->whereIn('pembayaran.id', $completedPaymentIds)
            ->whereDate('pembayaran.order_date', today())
            // Menghitung SUM(quantity * price_per_item)
            ->sum(DB::raw('detail_pembayaran.quantity * detail_pembayaran.price_per_item'));
                                    
        // 2. Total Subtotal Pendapatan KESELURUHAN (Semua waktu)
        $totalSubtotal = detailPembayaran::join('pembayaran', 'detail_pembayaran.pembayaran_id', '=', 'pembayaran.id')
            ->whereIn('pembayaran.id', $completedPaymentIds)
            ->sum(DB::raw('detail_pembayaran.quantity * detail_pembayaran.price_per_item'));

        // 3. Menghitung Menu Terjual HARI INI (QUERY DIPERBAIKI MENGGUNAKAN JOIN KE order_date)
        $menuTerjualHariIni = detailPembayaran::join('pembayaran', 'detail_pembayaran.pembayaran_id', '=', 'pembayaran.id')
            ->whereIn('pembayaran.id', $completedPaymentIds)
            ->whereDate('pembayaran.order_date', today())
            ->sum('detail_pembayaran.quantity'); // Menggunakan kolom quantity dari detail_pembayaran
        
        // 4. Reservasi Terlaksana (Asumsi status_id = 2)
        $reservasiTerlaksana = reservasi::where('status_id', 2)
                                    ->count(); 
        
        // 5. Menghitung Total Akhir (Subtotal + PPN 10%)
        $pendapatanHariIni = $subtotalHariIni * 1.10;
        $totalPendapatan = $totalSubtotal * 1.10;
        
        $data = [
            'pendapatanHariIni' => $pendapatanHariIni,
            'menuTerjualHariIni' => $menuTerjualHariIni,
            'totalPendapatan' => $totalPendapatan,
            'reservasiTerlaksana' => $reservasiTerlaksana,
        ];
        
        return view('admin.dashboard', compact('data'));
    }

    public function menu()
    {
        // Mengambil data menu dari Database (TIDAK ADA DUMMY)
        $menus = menu::with(['type', 'status'])->get()->map(fn($m) => [
            'id' => $m->id,
            'nama' => $m->nama,
            'kategori' => $m->type->type_name ?? 'N/A',
            'harga' => $m->price,
            'stok' => $m->stok ?? 0, // Menggunakan 0 karena kolom 'stok' tidak ada di migrasi menu
            'status' => ucwords($m->status->status_name ?? 'N/A'),
            'image_path' => $m->url_foto,
            'deskripsi' => $m->deskripsi, // Ambil kolom deskripsi
        ]);

        return view('admin.menu', compact('menus'));
    }

    public function users()
    {
        // Mengambil data user dari Database (TIDAK ADA DUMMY)
        $users = User::with('role')->get()->map(fn($u) => [
            'id' => $u->id,
            'nama' => $u->nama,
            'email' => $u->email,
            'role' => ucwords($u->role->role_name ?? 'N/A'),
            'terdaftar' => $u->created_at ? $u->created_at->format('Y-m-d') : 'N/A',
        ]);
        return view('admin.users', compact('users'));
    }

    public function reservations()
    {
        // Mengambil data reservasi dari Database (TIDAK ADA DUMMY)
        $reservations = reservasi::with(['user', 'status'])
            ->get()->map(function($r) {
                return [
                    'id' => $r->id, 
                    'kode' => $r->kode_reservasi, 
                    'tanggal' => $r->tanggal_reservasi ? (new \DateTime($r->tanggal_reservasi))->format('Y-m-d') : 'N/A',
                    'jam' => $r->tanggal_reservasi ? (new \DateTime($r->tanggal_reservasi))->format('H:i') : 'N/A',
                    'orang' => $r->jumlah_orang, 
                    // Mengambil data dari relasi User
                    'nama' => $r->user->nama ?? 'Unknown User', 
                    'email' => $r->user->email ?? 'N/A', 
                    'phone' => $r->user->no_telp ?? 'N/A', 
                    'status' => ucwords($r->status->status_name ?? 'Menunggu'), 
                    'note' => $r->message,
                ];
            });
        
        return view('admin.reservations', compact('reservations'));
    }
    
    public function ratings()
    {
        // Mengambil data review dari Database (TIDAK ADA DUMMY)
        $ratings = review::with(['user', 'menu_item'])
            ->get()->map(fn($r) => [
                'id' => $r->id,
                'menu' => $r->menu_item->nama ?? 'Menu Dihapus',
                'user' => $r->user->nama ?? 'User Dihapus',
                'rating' => $r->rating,
                'ulasan' => $r->comment,
                'tanggal' => $r->created_at ? $r->created_at->format('Y-m-d') : 'N/A',
            ]);
        
        return view('admin.ratings', compact('ratings'));
    }
    
    // --- RIWAYAT PENJUALAN (ORDERS) - MENGAMBIL DARI DB (TIDAK ADA DUMMY) ---
    public function orders()
    {
        // Mengambil semua pembayaran dan itemnya (Asumsi 10% tax)
        $orders = pembayaran::with(['user', 'payment_method', 'status', 'order_type'])
            ->orderBy('order_date', 'desc')
            ->get()->map(function ($order) {
                // Mengambil rincian item
                $items = detailPembayaran::with('menu')
                    ->where('pembayaran_id', $order->id)
                    ->get()->map(function ($detail) {
                        $menuName = $detail->menu->nama ?? 'Menu Dihapus';
                        $subtotalItem = $detail->quantity * $detail->price_per_item;
                        $imagePath = $detail->menu->url_foto ?? 'assets/placeholder.jpg';
                        
                        return [
                            'name' => $menuName,
                            'qty' => $detail->quantity,
                            'price' => $detail->price_per_item,
                            'image_path' => 'foto/' . $imagePath, // Sesuaikan path dengan folder public/foto/
                            'subtotal_item' => $subtotalItem,
                        ];
                    })->toArray();

                $subtotal = collect($items)->sum('subtotal_item');
                $tax = $subtotal * 0.10;
                $total = $subtotal + $tax;
                
                return [
                    'id' => $order->id, 
                    'tanggal' => $order->order_date ? $order->order_date : 'N/A', 
                    'customer' => $order->user->nama ?? 'Guest/Unknown', 
                    'status' => ucwords($order->status->status_name ?? 'N/A'),
                    'metode' => ucwords($order->payment_method->method_name ?? 'N/A'),
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                    'items' => $items
                ];
            });
            
        return view('admin.orders', compact('orders'));
    }

    // ====================================================================
    // FUNGSI CRUD MENGGUNAKAN ELOQUENT (TANPA JSON RESPONSE DENGAN REDIRECT)
    // ====================================================================
    // Disesuaikan untuk menggunakan Redirect::route() alih-alih response()->json()
    // agar sesuai dengan kebutuhan CRUD Admin yang lebih sederhana/non-AJAX.

    public function storeMenu(Request $request)
    {
        // Mapping UI Input ke DB Schema
        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $request->image_path,
            'type_id' => $this->getMenuTypeId($request->kategori),
            'price' => (int) $request->harga,
            'deskripsi' => $request->deskripsi, 
            'status_id' => $this->getMenuStatusId($request->status),
        ];
        
        menu::create($menuData);

        return Redirect::route('admin.menu')->with('success', 'Menu ' . $request->nama . ' berhasil ditambahkan.');
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = menu::find($id);

        if (!$menu) {
            return Redirect::route('admin.menu')->with('error', 'Menu tidak ditemukan.');
        }

        // Mapping UI Input ke DB Schema
        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $request->image_path,
            'type_id' => $this->getMenuTypeId($request->kategori),
            'price' => (int) $request->harga,
            'deskripsi' => $request->deskripsi,
            'status_id' => $this->getMenuStatusId($request->status),
        ];

        $menu->update($menuData);
        
        return Redirect::route('admin.menu')->with('success', 'Menu ' . $request->nama . ' berhasil diperbarui.');
    }

    public function destroyMenu($id)
    {
        $deleted = menu::destroy($id);
        
        if ($deleted) {
            return response()->noContent(); 
        }
        
        return response('Gagal menghapus menu.', 404);
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response('Pengguna tidak ditemukan.', 404);
        }

        $newRoleId = $this->getRoleId($request->input('role'));
        
        $user->update(['role_id' => $newRoleId]);
        
        return response()->noContent(); 
    }

    public function destroyUser($id)
    {
        $deleted = User::destroy($id);
        
        if ($deleted) {
            return response()->noContent();
        }
        
        return response('Gagal menghapus pengguna.', 404);
    }

    public function updateReservationStatus(Request $request, $id)
    {
        $reservation = reservasi::find($id);

        if (!$reservation) {
            return response('Reservasi tidak ditemukan.', 404);
        }

        $newStatusId = $this->getReservationStatusId($request->input('status'));
        
        $reservation->update(['status_id' => $newStatusId]);
        
        return response()->noContent();
    }

    public function destroyReservation($id)
    {
        $deleted = reservasi::destroy($id);
        
        if ($deleted) {
            return response()->noContent();
        }
        
        return response('Gagal menghapus reservasi.', 404);
    }

    public function destroyRating($id)
    {
        $deleted = review::destroy($id);
        
        if ($deleted) {
            return response()->noContent();
        }
        
        return response('Gagal menghapus ulasan.', 404);
    }
}