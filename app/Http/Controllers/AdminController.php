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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ====================================================================
    // HALAMAN ADMIN (VIEW DATA)
    // ====================================================================

    public function dashboard()
    {
        $today = Carbon::today(); // Ambil tanggal hari ini

        // 1. Total Pendapatan - Dihitung dari detail pembayaran
        $totalPendapatan = detailPembayaran::selectRaw('SUM(quantity * price_per_item) as total')
            ->value('total') ?? 0;

        // 2. Pendapatan Hari Ini - Dihitung dari detail pembayaran dengan filter tanggal
        $pendapatanHariIni = detailPembayaran::whereHas('pembayaran', function ($query) use ($today) {
            $query->whereDate('order_date', $today);
        })
            ->selectRaw('SUM(quantity * price_per_item) as total')
            ->value('total') ?? 0;

        // 3. Menu Terjual Hari Ini (Menghitung kuantitas item yang dibayar hari ini)
        // Kode Baru (Memperbaiki Error)
        $menuTerjualHariIni = detailPembayaran::whereHas('pembayaran', function ($query) use ($today) {
            $query->whereDate('order_date', $today); // Ganti created_at ke order_date
        })->sum('quantity') ?? 0;

        // 4. Reservasi Terlaksana (Mengambil status ID 2, sesuai asumsi sistem)
        $reservasiTerlaksana = reservasi::where('status_id', 2)->count() ?? 0;

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
        // CRUD Sederhana: READ data menu dari Database
        $menus = menu::with(['type', 'status'])->get()->map(fn($m) => [
            'id' => $m->id,
            'nama' => $m->nama,
            'kategori' => $m->type->type_name ?? 'N/A',
            'kategori_id' => $m->type_id ?? null,
            'harga' => $m->price,
            'stok' => $m->stok ?? 0,
            'status' => ucwords($m->status->status_name ?? 'N/A'),
            // FIX: Tambahkan prefix 'foto/' agar gambar muncul di view
            'image_path' => $m->url_foto ? 'foto/' . $m->url_foto : null,
            'deskripsi' => $m->deskripsi,
        ]);

        return view('admin.menu', compact('menus'));
    }

    public function users()
    {
        // Mengambil data user dari Database (Khusus Admin)
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
        // Mengambil data reservasi dari Database (Khusus Admin)
        $reservations = reservasi::with(['user', 'status'])
            ->get()->map(function ($r) {
                return [
                    'id' => $r->id,
                    'kode' => $r->kode_reservasi,
                    'tanggal' => $r->tanggal_reservasi ? (new \DateTime($r->tanggal_reservasi))->format('Y-m-d') : 'N/A',
                    'jam' => $r->tanggal_reservasi ? (new \DateTime($r->tanggal_reservasi))->format('H:i') : 'N/A',
                    'orang' => $r->jumlah_orang,
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
        // Mengambil data review dari Database (Khusus Admin)
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

    // haykal-9/pabw/PABW-7e82df8ad72ef023c77f1eeca076f5349ec77851/app/Http/Controllers/AdminController.php

    public function orders()
    {
        // Simpler normalized orders for the view
        $orders = pembayaran::with(['details.menu', 'orderType', 'user', 'status', 'paymentMethod'])
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function ($p) {
                $items = $p->details->map(fn($d) => [
                    'name' => $d->menu->nama ?? 'Unknown',
                    'qty' => $d->quantity ?? 0,
                    'price' => (float) ($d->price_per_item ?? $d->menu->price ?? 0),
                    'image_path' => $d->menu && $d->menu->url_foto ? 'foto/' . $d->menu->url_foto : null,
                ])->toArray();

                $subtotal = array_reduce($items, fn($carry, $it) => $carry + ($it['qty'] * $it['price']), 0);
                $tax = (int) round($subtotal * 0.1);
                $total = $subtotal + $tax;

                return [
                    'id' => $p->id,
                    'tanggal' => $p->order_date ? (new \DateTime($p->order_date))->format('Y-m-d') : 'N/A',
                    'customer' => $p->user->nama ?? 'Unknown',
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                    'metode' => data_get($p, 'paymentMethod.method_name') ?? 'N/A',
                    'status' => ucwords(data_get($p, 'status.status_name') ?? data_get($p, 'status.name') ?? 'N/A'),
                    'items' => $items,
                ];
            });

        return view('admin.orders', compact('orders'));
    }
    // ====================================================================
    // FUNGSI CRUD MENU (DENGAN LOGIKA UPLOAD FOTO SEDERHANA)
    // ====================================================================

    public function storeMenu(Request $request)
    {
        // --- LOGIKA UPLOAD FOTO SEDERHANA (CREATE) ---
        $path_to_save = null; // Mulai dengan null

        // Asumsi input file bernama 'foto_upload'
        if ($request->hasFile('foto_upload')) {
            $file = $request->file('foto_upload');
            // Membuat nama file unik
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // Menyimpan file ke folder public/foto
            $file->move(public_path('foto'), $namaFile);

            $path_to_save = $namaFile; // Simpan hanya nama file di DB
        }
        // --- AKHIR LOGIKA UPLOAD FOTO ---

        // LOGIKA PALING SEDERHANA: Langsung mengambil nilai dari request di dalam array

        // Mencegah Sinkronisasi Instan ke Customer: Default Status ID = 2 (Habis)
        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $path_to_save, // <-- Menggunakan nama file
            'type_id' => $request->kategori,
            'price' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status, // <<< PERBAIKAN: Mengambil nilai status dari form
        ];

        // CRUD Sederhana: CREATE
        menu::create($menuData);

        $statusMessage = $request->status == 1 ? 'Tersedia' : 'Habis';
        return Redirect::route('admin.menu')->with('success', 'Menu ' . $request->nama . ' berhasil ditambahkan. Status: ' . $statusMessage . '.');

    }

    public function updateMenu(Request $request, $id)
    {
        // CRUD Sederhana: FIND
        $menu = menu::find($id);

        if (!$menu) {
            return Redirect::route('admin.menu')->with('error', 'Menu tidak ditemukan.');
        }

        // --- LOGIKA UPLOAD FOTO SEDERHANA (UPDATE) ---
        $path_to_save = $menu->url_foto; // Pertahankan nama file lama sebagai default

        if ($request->hasFile('foto_upload')) {
            // 1. Hapus file lama jika ada
            if ($menu->url_foto) {
                $oldPath = public_path('foto/' . $menu->url_foto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // 2. Simpan file baru
            $file = $request->file('foto_upload');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namaFile);

            $path_to_save = $namaFile; // Simpan nama file baru di DB
        }
        // --- AKHIR LOGIKA UPLOAD FOTO ---


        // LOGIKA PALING SEDERHANA: Langsung mengambil nilai dari request di dalam array
        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $path_to_save, // <-- Menggunakan nama file baru/lama
            'type_id' => $request->kategori,
            'price' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status,
        ];

        // CRUD Sederhana: UPDATE
        $menu->update($menuData);

        return Redirect::route('admin.menu')->with('success', 'Menu ' . $request->nama . ' berhasil diperbarui.');
    }

    public function destroyMenu($id)
    {
        // Tambahkan logika hapus file fisik saat menu dihapus
        $menu = menu::find($id);
        if ($menu && $menu->url_foto) {
            $filePath = public_path('foto/' . $menu->url_foto);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        // CRUD Sederhana: DELETE
        $deleted = menu::destroy($id);

        if ($deleted) {
            return response()->noContent();
        }

        return response('Gagal menghapus menu.', 404);
    }

    // ====================================================================
    // FUNGSI CRUD LAIN (LOGIKA PALING SEDERHANA)
    // ====================================================================

    // public function updateUserRole(Request $request, $id) // FUNGSI INI DIHAPUS
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return response('Pengguna tidak ditemukan.', 404);
    //     }

    //     // LOGIKA PALING SEDERHANA: Langsung mengambil nilai dari request dalam array update
    //     $user->update(['role_id' => $request->input('role')]);

    //     return response()->noContent(); 
    // }

    public function destroyUser($id)
    {
        $deleted = User::destroy($id);

        if ($deleted) {
            return response()->noContent();
        }

        return response('Gagal menghapus pengguna.', 404);
    }

    public function destroyReservation($id)
    {
        // CRUD Sederhana: DELETE
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