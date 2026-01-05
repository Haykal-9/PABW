<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pembayaran;
use App\Models\reservasi;
use Illuminate\Support\Facades\DB;

class KasirRiwayatController extends Controller
{
    /**
     * Menampilkan halaman riwayat reservasi (dikonfirmasi & dibatalkan).
     */
    public function riwayatReservasi()
    {
        // Ambil reservasi dengan status dikonfirmasi (2) dan dibatalkan (3)
        $reservasiData = reservasi::with(['user', 'status'])
            ->whereIn('status_id', [2, 3])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Format data untuk view, termasuk alasan penolakan jika ada
        $riwayatReservasi = $reservasiData->map(function ($item) {
            $alasan = DB::table('reservasi_ditolak')
                ->where('reservation_id', $item->id)
                ->first();

            return [
                'id' => $item->id,
                'kode' => $item->kode_reservasi,
                'nama' => $item->user->nama ?? 'N/A',
                'email' => $item->user->email ?? 'N/A',
                'no_telp' => $item->user->no_telp ?? 'N/A',
                'jumlah_orang' => $item->jumlah_orang,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal_reservasi)->format('d M Y H:i'),
                'pesan' => $item->message ?? '-',
                'status' => $item->status->status_name ?? 'unknown',
                'alasan_ditolak' => $alasan ? $alasan->alasan_ditolak : null,
                'ditolak_oleh' => $alasan ? $alasan->ditolak_oleh : null,
            ];
        });

        return view('kasir.riwayat-reservasi', [
            'title' => 'Tapal Kuda | Riwayat Reservasi',
            'activePage' => 'riwayat-reservasi',
            'riwayatReservasi' => $riwayatReservasi,
        ]);
    }

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

    /**
     * Mengubah status reservasi.
     */
    public function updateStatusReservasi(Request $request, $id)
    {
        try {
            $request->validate([
                'status_id' => 'required|in:1,2,3',
            ]);

            $reservasi = reservasi::findOrFail($id);
            $oldStatusId = $reservasi->status_id;
            $newStatusId = $request->status_id;

            // Update status
            $reservasi->status_id = $newStatusId;
            $reservasi->save();

            // Jika status berubah dari dibatalkan ke status lain, hapus record penolakan
            if ($oldStatusId == 3 && $newStatusId != 3) {
                DB::table('reservasi_ditolak')
                    ->where('reservation_id', $id)
                    ->delete();
            }

            $statusNames = [
                1 => 'Pending',
                2 => 'Dikonfirmasi',
                3 => 'Dibatalkan',
            ];

            return redirect()->route('kasir.riwayat-reservasi')
                ->with('success', 'Status reservasi berhasil diubah menjadi ' . $statusNames[$newStatusId] . '!');
        } catch (\Exception $e) {
            return redirect()->route('kasir.riwayat-reservasi')
                ->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
