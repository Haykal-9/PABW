<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pembayaran;

class KasirRiwayatController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan.
     */
    public function index()
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
                'pajak' => 0.10,
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
}
