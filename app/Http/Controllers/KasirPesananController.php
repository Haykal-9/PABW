<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\pembayaran;
use App\Models\Notification;

class KasirPesananController extends Controller
{
    /**
     * Menampilkan halaman pesanan pending.
     */
    public function index()
    {
        // Ambil semua pesanan dengan status pending (status_id = 2)
        $pesananData = pembayaran::with([
            'user',
            'details.menu',
            'payment_method',
            'order_type',
            'status'
        ])
            ->where('status_id', 2) // pending
            ->orderBy('order_date', 'desc')
            ->get();

        // Format data untuk view
        $pesanan = $pesananData->map(function ($item) {
            $total = $item->details->sum(function ($detail) {
                return $detail->quantity * $detail->price_per_item;
            });

            $items = $item->details->map(function ($detail) {
                return [
                    'nama' => $detail->menu->nama ?? 'Unknown',
                    'quantity' => $detail->quantity,
                    'harga' => $detail->price_per_item,
                    'subtotal' => $detail->quantity * $detail->price_per_item,
                ];
            });

            return [
                'id' => $item->id,
                'kode' => 'INV-' . str_pad($item->id, 4, '0', STR_PAD_LEFT),
                'nama' => $item->user->nama ?? 'Guest',
                'email' => $item->user->email ?? 'N/A',
                'no_telp' => $item->user->no_telp ?? 'N/A',
                'tanggal' => \Carbon\Carbon::parse($item->order_date)->format('d M Y H:i'),
                'order_type' => $item->order_type->type_name ?? 'N/A',
                'payment_method' => $item->payment_method->method_name ?? 'N/A',
                'items' => $items,
                'total' => $total,
                'status' => $item->status->status_name ?? 'pending',
            ];
        });

        return view('kasir.pesanan', [
            'title' => 'Tapal Kuda | Pesanan Masuk',
            'activePage' => 'pesanan',
            'pesanan' => $pesanan,
        ]);
    }

    /**
     * Menerima/approve pesanan - ubah status ke processing
     */
    public function approve($id)
    {
        try {
            $pesanan = pembayaran::findOrFail($id);
            $pesanan->status_id = 4; // processing
            $pesanan->save();

            // Kirim notifikasi ke customer
            Notification::create([
                'user_id' => $pesanan->user_id,
                'type' => 'order_processing',
                'title' => 'Pesanan Sedang Diproses',
                'message' => 'Pesanan Anda dengan invoice #INV-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . ' sedang diproses oleh kasir.',
                'link' => '/profile/order/' . $pesanan->user_id . '/' . $pesanan->id,
                'is_read' => false
            ]);

            return redirect()->route('kasir.pesanan')
                ->with('success', 'Pesanan berhasil diterima dan sedang diproses!');
        } catch (\Exception $e) {
            return redirect()->route('kasir.pesanan')
                ->with('error', 'Gagal menerima pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Menolak pesanan - ubah status ke cancelled
     */
    public function reject(Request $request, $id)
    {
        try {
            $pesanan = pembayaran::findOrFail($id);
            $pesanan->status_id = 3; // cancelled
            $pesanan->save();

            // Kirim notifikasi ke customer
            Notification::create([
                'user_id' => $pesanan->user_id,
                'type' => 'order_cancelled',
                'title' => 'Pesanan Dibatalkan',
                'message' => 'Pesanan Anda dengan invoice #INV-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . ' telah dibatalkan. Silakan hubungi kasir untuk informasi lebih lanjut.',
                'link' => '/profile/order/' . $pesanan->user_id . '/' . $pesanan->id,
                'is_read' => false
            ]);

            // Note: Alasan penolakan tidak disimpan karena tabel belum ada
            // Jika ingin menyimpan alasan, buat tabel pesanan_ditolak terlebih dahulu

            return redirect()->route('kasir.pesanan')
                ->with('success', 'Pesanan berhasil ditolak!');
        } catch (\Exception $e) {
            return redirect()->route('kasir.pesanan')
                ->with('error', 'Gagal menolak pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Menyelesaikan pesanan - ubah status ke completed
     */
    public function complete($id)
    {
        try {
            $pesanan = pembayaran::findOrFail($id);
            $pesanan->status_id = 1; // completed
            $pesanan->save();

            // Kirim notifikasi ke customer
            Notification::create([
                'user_id' => $pesanan->user_id,
                'type' => 'order_completed',
                'title' => 'Pesanan Selesai',
                'message' => 'Pesanan Anda dengan invoice #INV-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . ' telah selesai. Selamat menikmati!',
                'link' => '/profile/order/' . $pesanan->user_id . '/' . $pesanan->id,
                'is_read' => false
            ]);

            return redirect()->back()
                ->with('success', 'Pesanan berhasil diselesaikan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyelesaikan pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan pesanan yang sedang diproses (processing)
     */
    public function processing()
    {
        $pesananData = pembayaran::with([
            'user',
            'details.menu',
            'payment_method',
            'order_type',
            'status'
        ])
            ->where('status_id', 4) // processing
            ->orderBy('order_date', 'desc')
            ->get();

        $pesanan = $pesananData->map(function ($item) {
            $total = $item->details->sum(function ($detail) {
                return $detail->quantity * $detail->price_per_item;
            });

            $items = $item->details->map(function ($detail) {
                return [
                    'nama' => $detail->menu->nama ?? 'Unknown',
                    'quantity' => $detail->quantity,
                    'harga' => $detail->price_per_item,
                    'subtotal' => $detail->quantity * $detail->price_per_item,
                ];
            });

            return [
                'id' => $item->id,
                'kode' => 'INV-' . str_pad($item->id, 4, '0', STR_PAD_LEFT),
                'nama' => $item->user->nama ?? 'Guest',
                'tanggal' => \Carbon\Carbon::parse($item->order_date)->format('d M Y H:i'),
                'order_type' => $item->order_type->type_name ?? 'N/A',
                'items' => $items,
                'total' => $total,
            ];
        });

        return view('kasir.pesanan-proses', [
            'title' => 'Tapal Kuda | Pesanan Diproses',
            'activePage' => 'pesanan-proses',
            'pesanan' => $pesanan,
        ]);
    }
}
