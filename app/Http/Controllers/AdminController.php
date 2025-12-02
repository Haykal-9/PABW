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
    public function dashboard()
    {
        $today = Carbon::today();

        $totalPendapatan = detailPembayaran::selectRaw('SUM(quantity * price_per_item) as total')
            ->value('total') ?? 0;

        $pendapatanHariIni = detailPembayaran::whereHas('pembayaran', function ($query) use ($today) {
            $query->whereDate('order_date', $today);
        })
            ->selectRaw('SUM(quantity * price_per_item) as total')
            ->value('total') ?? 0;

        $menuTerjualHariIni = detailPembayaran::whereHas('pembayaran', function ($query) use ($today) {
            $query->whereDate('order_date', $today);
        })->sum('quantity') ?? 0;

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
        $menus = menu::with(['type', 'status'])->get()->map(fn($m) => [
            'id' => $m->id,
            'nama' => $m->nama,
            'kategori' => $m->type->type_name ?? 'N/A',
            'kategori_id' => $m->type_id ?? null,
            'harga' => $m->price,
            'stok' => $m->stok ?? 0,
            'status' => ucwords($m->status->status_name ?? 'N/A'),
            'image_path' => $m->url_foto ? 'foto/' . $m->url_foto : null,
            'deskripsi' => $m->deskripsi,
        ]);

        return view('admin.menu', compact('menus'));
    }

    public function users()
    {
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

    public function orders()
    {
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

    public function storeMenu(Request $request)
    {
        $path_to_save = null;

        if ($request->hasFile('foto_upload')) {
            $file = $request->file('foto_upload');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namaFile);
            $path_to_save = $namaFile;
        }

        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $path_to_save,
            'type_id' => $request->kategori,
            'price' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status,
        ];

        menu::create($menuData);

        $statusMessage = $request->status == 1 ? 'Tersedia' : 'Habis';
        return Redirect::route('admin.menu')->with('success', 'Menu ' . $request->nama . ' berhasil ditambahkan. Status: ' . $statusMessage . '.');
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = menu::find($id);

        if (!$menu) {
            return Redirect::route('admin.menu')->with('error', 'Menu tidak ditemukan.');
        }

        $path_to_save = $menu->url_foto;

        if ($request->hasFile('foto_upload')) {
            if ($menu->url_foto) {
                $oldPath = public_path('foto/' . $menu->url_foto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('foto_upload');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namaFile);
            $path_to_save = $namaFile;
        }

        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $path_to_save,
            'type_id' => $request->kategori,
            'price' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status,
        ];

        $menu->update($menuData);

        return Redirect::route('admin.menu')->with('success', 'Menu ' . $request->nama . ' berhasil diperbarui.');
    }

    public function destroyMenu($id)
    {
        $menu = menu::find($id);
        if ($menu && $menu->url_foto) {
            $filePath = public_path('foto/' . $menu->url_foto);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $deleted = menu::destroy($id);

        if ($deleted) {
            return response()->noContent();
        }

        return response('Gagal menghapus menu.', 404);
    }

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