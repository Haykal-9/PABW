<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\reservasi;
use App\Models\Notification;

class KasirReservasiApiController extends Controller
{
    /**
     * Get pending reservations
     */
    public function index()
    {
        $reservasiData = reservasi::with('user', 'status')
            ->where('status_id', 1) // pending
            ->orderBy('created_at', 'desc')
            ->get();

        $reservasi = $reservasiData->map(function ($item) {
            return [
                'id' => $item->id,
                'kode' => $item->kode_reservasi,
                'nama' => $item->user->nama ?? 'N/A',
                'email' => $item->user->email ?? 'N/A',
                'no_telp' => $item->user->no_telp ?? 'N/A',
                'jumlah_orang' => $item->jumlah_orang,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal_reservasi)->format('Y-m-d H:i'),
                'pesan' => $item->message ?? null,
                'status' => $item->status->status_name ?? 'pending',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $reservasi
        ]);
    }

    /**
     * Get all reservations with optional filter
     */
    public function all(Request $request)
    {
        $query = reservasi::with('user', 'status')
            ->orderBy('created_at', 'desc');

        if ($request->has('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        $reservasiData = $query->get();

        $reservasi = $reservasiData->map(function ($item) {
            return [
                'id' => $item->id,
                'kode' => $item->kode_reservasi,
                'nama' => $item->user->nama ?? 'N/A',
                'email' => $item->user->email ?? 'N/A',
                'no_telp' => $item->user->no_telp ?? 'N/A',
                'jumlah_orang' => $item->jumlah_orang,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal_reservasi)->format('Y-m-d H:i'),
                'pesan' => $item->message ?? null,
                'status' => $item->status->status_name ?? 'pending',
                'status_id' => $item->status_id,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $reservasi
        ]);
    }

    /**
     * Approve reservation
     */
    public function approve($id)
    {
        try {
            $reservasi = reservasi::find($id);

            if (!$reservasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi tidak ditemukan'
                ], 404);
            }

            if ($reservasi->status_id != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi sudah diproses sebelumnya'
                ], 400);
            }

            $reservasi->status_id = 2; // confirmed
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

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dikonfirmasi'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengkonfirmasi reservasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject reservation
     */
    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'alasan' => 'nullable|string|max:500'
            ]);

            $reservasi = reservasi::find($id);

            if (!$reservasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi tidak ditemukan'
                ], 404);
            }

            if ($reservasi->status_id != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi sudah diproses sebelumnya'
                ], 400);
            }

            $reservasi->status_id = 3; // rejected
            $reservasi->save();

            // Log rejection reason
            if ($request->has('alasan')) {
                DB::table('reservasi_ditolak')->insert([
                    'reservation_id' => $id,
                    'alasan_ditolak' => $request->alasan,
                    'ditolak_oleh' => Auth::user()->nama,
                    'cancelled_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil ditolak'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak reservasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
