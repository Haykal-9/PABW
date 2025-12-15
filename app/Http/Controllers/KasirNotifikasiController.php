<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\pembayaran;
use App\Models\reservasi;

class KasirNotifikasiController extends Controller
{
    /**
     * Menampilkan halaman notifikasi.
     */
    public function index()
    {
        $notifikasi = [];
        $now = now();

        // 1. Notifikasi Pesanan Selesai (24 jam terakhir)
        $completedOrders = pembayaran::with('user')
            ->where('status_id', 1)
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
            ->where('status_id', 3)
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

        // 3. Notifikasi Reservasi Baru
        $newReservations = reservasi::with('user')
            ->where(function ($query) use ($now) {
                $query->where('status_id', 1)
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

        // 4. Notifikasi Stok Hampir Habis
        $lowStockItems = menu::where('status_id', 2)->get();

        foreach ($lowStockItems as $item) {
            $notifikasi[] = [
                'judul' => 'Stok habis - ' . $item->nama,
                'waktu' => 'Sekarang',
                'isi' => 'Menu "' . $item->nama . '" sudah habis dan perlu segera diisi ulang.',
                'type' => 'low_stock',
                'timestamp' => time(),
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
}
