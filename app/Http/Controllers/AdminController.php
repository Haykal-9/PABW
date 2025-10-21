<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // ====================================================================
    // FUNGSI PEMBANTU UNTUK MENGAMBIL DATA DARI SESSION ATAU DUMMY AWAL
    // ====================================================================

    private function getInitialMenuData()
    {
         return [
            ['id' => 1, 'nama' => 'Kopi Tubruk Robusta', 'kategori' => 'Kopi', 'harga' => 15000, 'stok' => 99, 'status' => 'Tersedia', 'image_path' => 'foto/KOPITUBRUKROBUSTA.jpg'],
            ['id' => 2, 'nama' => 'Cappucino', 'kategori' => 'Kopi', 'harga' => 30000, 'stok' => 50, 'status' => 'Tersedia', 'image_path' => 'foto/CAPPUCINO.jpg'],
            ['id' => 3, 'nama' => 'Matcha Premium', 'kategori' => 'Non-Kopi', 'harga' => 40000, 'stok' => 30, 'status' => 'Tersedia', 'image_path' => 'foto/red.jpg'],
            ['id' => 4, 'nama' => 'Nasi Ayam Teriyaki', 'kategori' => 'Makanan', 'harga' => 35000, 'stok' => 15, 'status' => 'Tersedia', 'image_path' => 'foto/AyamTeriyaki.jpg'],
            ['id' => 5, 'nama' => 'Tempe Mendoan', 'kategori' => 'Cemilan', 'harga' => 18000, 'stok' => 25, 'status' => 'Habis', 'image_path' => 'foto/tempeMendoan.jpg'],
            ['id' => 6, 'nama' => 'Balabala', 'kategori' => 'Cemilan', 'harga' => 10000, 'stok' => 40, 'status' => 'Tersedia', 'image_path' => 'foto/balabala.jpg'],
        ];
    }

    private function getInitialUserData()
    {
        return [
            ['id' => 1, 'nama' => 'Rina S.', 'email' => 'rina@example.com', 'role' => 'Customer', 'terdaftar' => '2024-09-01'],
            ['id' => 2, 'nama' => 'Andi K.', 'email' => 'andi@example.com', 'role' => 'Customer', 'terdaftar' => '2024-09-15'],
            ['id' => 3, 'nama' => 'Admin Utama', 'email' => 'admin@tapalkuda.com', 'role' => 'Admin', 'terdaftar' => '2024-08-01'],
            ['id' => 4, 'nama' => 'Santi W.', 'email' => 'santi@example.com', 'role' => 'Customer', 'terdaftar' => '2024-10-05'],
            ['id' => 5, 'nama' => 'Kasir Tapal', 'email' => 'kasir@tapalkuda.com', 'role' => 'Kasir', 'terdaftar' => '2024-10-01'],
        ];
    }
    
    private function getInitialReservationData()
    {
        return [
            [
                'id' => 1, 'kode' => 'RSV2025101901', 'tanggal' => '2025-10-25', 'jam' => '19:00', 'orang' => 4, 'nama' => 'Dummy User', 'email' => 'dummy@mail.com', 'phone' => '081234567890', 'status' => 'Dikonfirmasi', 'note' => 'Butuh meja dekat jendela, ada anak kecil.',
            ],
            [
                'id' => 2, 'kode' => 'RSV2025101902', 'tanggal' => '2025-10-20', 'jam' => '15:30', 'orang' => 2, 'nama' => 'Joko Susanto', 'email' => 'joko@mail.com', 'phone' => '085711223344', 'status' => 'Menunggu Konfirmasi', 'note' => 'Tidak ada catatan khusus.',
            ],
            [
                'id' => 3, 'kode' => 'RSV2025101801', 'tanggal' => '2025-10-18', 'jam' => '18:00', 'orang' => 5, 'nama' => 'Ani Mardiana', 'email' => 'ani@mail.com', 'phone' => '081998877665', 'status' => 'Selesai', 'note' => 'Ulang tahun, mohon hiasan sederhana di meja.',
            ],
        ];
    }

    private function getInitialRatingData()
    {
        return [
            ['id' => 1, 'menu' => 'Iced TapalKuda Latte', 'user' => 'Rina S.', 'rating' => 5, 'ulasan' => 'Kopi terbaik di kota! Rasa creamy-nya pas.', 'tanggal' => '2025-10-18'],
            ['id' => 2, 'menu' => 'Nasi Ayam Teriyaki', 'user' => 'Andi K.', 'rating' => 4, 'ulasan' => 'Ayamnya enak, tapi porsinya sedikit kecil.', 'tanggal' => '2025-10-17'],
            ['id' => 3, 'menu' => 'Filter Coffee (V60)', 'user' => 'Santi W.', 'rating' => 5, 'ulasan' => 'Perfect brew, aroma sangat kuat.', 'tanggal' => '2025-10-15'],
        ];
    }

    // Fungsi utama untuk memuat data DARI Session JIKA ADA, atau menggunakan data dummy
    private function loadDynamicData(string $key, callable $initializer, string $id_key = null)
    {
        // Jika data sudah dimodifikasi di Session, kembalikan data dari Session
        if (Session::has($key)) {
            return Session::get($key);
        }
        
        // Jika belum ada modifikasi, set data awal ke Session dan kembalikan data tersebut
        $initialData = $initializer();
        Session::put($key, $initialData);
        
        if ($id_key) {
            $lastId = collect($initialData)->max('id') ?? 0;
            Session::put($id_key, $lastId + 1);
        }

        return $initialData;
    }

    // ====================================================================
    // HALAMAN ADMIN (MENAMPILKAN DATA)
    // ====================================================================

    public function dashboard()
    {
        // Data Dummy untuk Dashboard
        $data = [
            'pendapatanHariIni' => 450000,
            'menuTerjualHariIni' => 35,
            'totalPendapatan' => 98500000,
            'reservasiTerlaksana' => 150,
        ];

        return view('admin.dashboard', compact('data'));
    }

    public function menu()
    {
        // Load data menu: jika sudah ada di Session (setelah CRUD), gunakan itu. Jika belum, gunakan data dummy dan simpan di Session.
        $menus = $this->loadDynamicData('admin_menus', fn() => $this->getInitialMenuData(), 'admin_menu_next_id');
        return view('admin.menu', compact('menus'));
    }

    public function users()
    {
        $users = $this->loadDynamicData('admin_users', fn() => $this->getInitialUserData(), 'admin_user_next_id');
        return view('admin.users', compact('users'));
    }

    public function reservations()
    {
        $reservations = $this->loadDynamicData('admin_reservations', fn() => $this->getInitialReservationData(), 'admin_res_next_id');
        return view('admin.reservations', compact('reservations'));
    }
    
    public function ratings()
    {
        $ratings = $this->loadDynamicData('admin_ratings', fn() => $this->getInitialRatingData(), 'admin_rating_next_id');
        return view('admin.ratings', compact('ratings'));
    }
    
    // --- RIWAYAT PENJUALAN (ORDERS) - READ ONLY ---
    public function orders()
    {
        // Data Orders bersifat statis
        $orders = [
            [
                'id' => 101, 
                'tanggal' => '2025-10-18 14:00', 
                'customer' => 'Rina S.', 
                'status' => 'Selesai', 
                'metode' => 'QRIS',
                'subtotal' => 40000,
                'tax' => 4000,
                'total' => 44000,
                'items' => [
                    ['name' => 'Kopi Tubruk Robusta', 'qty' => 1, 'price' => 15000, 'image_path' => 'foto/KOPITUBRUKROBUSTA.jpg'],
                    ['name' => 'Matcha Premium', 'qty' => 1, 'price' => 25000, 'image_path' => 'foto/red.jpg'],
                ]
            ],
            // ... data dummy lainnya
        ];
        // Menggunakan data dummy bawaan untuk orders
        return view('admin.orders', compact('orders'));
    }

    // ====================================================================
    // FUNGSI CRUD (HANYA UNTUK MENGUBAH DATA DI SESSION SEMENTARA)
    // ====================================================================

    // --- CRUD MENU ---
    public function storeMenu(Request $request)
    {
        $menus = Session::get('admin_menus');
        $nextId = Session::get('admin_menu_next_id');

        $newMenu = [
            'id' => $nextId,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => (int) $request->harga,
            'stok' => (int) $request->stok,
            'status' => $request->status,
            'image_path' => $request->image_path,
        ];
        $menus[] = $newMenu;
        
        Session::put('admin_menus', $menus);
        Session::put('admin_menu_next_id', $nextId + 1);
        return response()->json(['success' => true, 'message' => 'Berhasil ditambahkan.']);
    }

    public function updateMenu(Request $request, $id)
    {
        $menus = Session::get('admin_menus');
        $menuId = (int) $id;

        foreach ($menus as $key => $menu) {
            if ($menu['id'] === $menuId) {
                $menus[$key] = [
                    'id' => $menuId,
                    'nama' => $request->nama,
                    'kategori' => $request->kategori,
                    'harga' => (int) $request->harga,
                    'stok' => (int) $request->stok,
                    'status' => $request->status,
                    'image_path' => $request->image_path,
                ];
                Session::put('admin_menus', $menus);
                return response()->json(['success' => true, 'message' => 'Berhasil diperbarui.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Gagal diperbarui.'], 404);
    }

    public function destroyMenu($id)
    {
        $menuId = (int) $id;
        $menus = Session::get('admin_menus');
        $menus = array_values(array_filter($menus, fn($menu) => $menu['id'] !== $menuId));
        Session::put('admin_menus', $menus);
        return response()->json(['success' => true, 'message' => 'Berhasil dihapus.']);
    }

    // --- CRUD USERS ---
    public function updateUserRole(Request $request, $id)
    {
        $users = Session::get('admin_users');
        $userId = (int) $id;
        $newRole = $request->input('role');
        foreach ($users as $key => $user) {
            if ($user['id'] === $userId) {
                $users[$key]['role'] = $newRole;
                Session::put('admin_users', $users);
                return response()->json(['success' => true, 'message' => 'Peran pengguna berhasil diperbarui.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Gagal diperbarui.'], 404);
    }

    public function destroyUser($id)
    {
        $userId = (int) $id;
        $users = Session::get('admin_users');
        $users = array_values(array_filter($users, fn($user) => $user['id'] !== $userId));
        Session::put('admin_users', $users);
        return response()->json(['success' => true, 'message' => 'Berhasil dihapus.']);
    }

    // --- CRUD RESERVATIONS ---
    public function updateReservationStatus(Request $request, $id)
    {
        $reservations = Session::get('admin_reservations');
        $resId = (int) $id;
        $newStatus = $request->input('status');

        foreach ($reservations as $key => $res) {
            if ($res['id'] === $resId) {
                $reservations[$key]['status'] = $newStatus;
                Session::put('admin_reservations', $reservations);
                return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Gagal diperbarui.'], 404);
    }

    public function destroyReservation($id)
    {
        $resId = (int) $id;
        $reservations = Session::get('admin_reservations');
        $reservations = array_values(array_filter($reservations, fn($res) => $res['id'] !== $resId));
        Session::put('admin_reservations', $reservations);
        return response()->json(['success' => true, 'message' => 'Berhasil dihapus.']);
    }

    // --- CRUD RATINGS ---
    public function destroyRating($id)
    {
        $ratingId = (int) $id;
        $ratings = Session::get('admin_ratings');
        $ratings = array_values(array_filter($ratings, fn($rating) => $rating['id'] !== $ratingId));
        Session::put('admin_ratings', $ratings);
        return response()->json(['success' => true, 'message' => 'Berhasil dihapus.']);
    }
}