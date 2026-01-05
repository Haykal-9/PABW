<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\reservasi;
use App\Models\Notification;

class KasirReservasiController extends Controller
{
    /**
     * Menampilkan halaman reservasi.
     */
    public function index()
    {
        // Ambil semua reservasi dengan status pending (status_id = 1)
        $reservasiData = reservasi::with('user', 'status')
            ->where('status_id', 1)
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
            $reservasi->status_id = 2;
            $reservasi->save();

            // Buat notifikasi untuk customer
            Notification::create([
                'user_id' => $reservasi->user_id,
                'type' => 'reservation_confirmed',
                'title' => 'Reservasi Dikonfirmasi',
                'message' => 'Reservasi Anda dengan kode ' . $reservasi->kode_reservasi . ' telah dikonfirmasi. Silakan datang tepat waktu.',
                'link' => '/reservations/' . $reservasi->id,
                'is_read' => false
            ]);

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
            $reservasi->status_id = 3;
            $reservasi->save();

            if ($request->has('alasan')) {
                \DB::table('reservasi_ditolak')->insert([
                    'reservation_id' => $id,
                    'alasan_ditolak' => $request->alasan,
                    'ditolak_oleh' => Auth::user()->nama,
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
}
