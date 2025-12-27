<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use Carbon\Carbon;

class ReservasiApiController extends Controller
{
    /**
     * Get user's reservations
     */
    public function index()
    {
        $reservasi = Reservasi::with('status')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $reservasi->map(function ($item) {
            return [
                'id' => $item->id,
                'kode' => $item->kode_reservasi,
                'tanggal' => Carbon::parse($item->tanggal_reservasi)->format('Y-m-d H:i'),
                'jumlah_orang' => $item->jumlah_orang,
                'pesan' => $item->message,
                'status' => $item->status->status_name ?? 'pending',
                'status_id' => $item->status_id,
                'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get reservation detail
     */
    public function show($id)
    {
        $reservasi = Reservasi::with('status')
            ->where('user_id', Auth::id())
            ->find($id);

        if (!$reservasi) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $reservasi->id,
                'kode' => $reservasi->kode_reservasi,
                'tanggal' => Carbon::parse($reservasi->tanggal_reservasi)->format('Y-m-d H:i'),
                'jumlah_orang' => $reservasi->jumlah_orang,
                'pesan' => $reservasi->message,
                'status' => $reservasi->status->status_name ?? 'pending',
                'status_id' => $reservasi->status_id,
                'created_at' => $reservasi->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * Create new reservation
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tanggal_reservasi' => 'required|date|after_or_equal:today',
                'jam_reservasi' => 'required|date_format:H:i',
                'jumlah_orang' => 'required|integer|min:1|max:50',
                'message' => 'nullable|string|max:500'
            ]);

            $waktuFix = Carbon::parse($request->tanggal_reservasi . ' ' . $request->jam_reservasi);

            // Generate unique code
            $kode = 'RSV-' . now()->format('Ymd') . '-' . rand(100, 999);

            $reservasi = Reservasi::create([
                'user_id' => Auth::id(),
                'kode_reservasi' => $kode,
                'tanggal_reservasi' => $waktuFix,
                'jumlah_orang' => $request->jumlah_orang,
                'message' => $request->message,
                'status_id' => 1, // pending
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat. Tunggu konfirmasi dari kasir.',
                'data' => [
                    'id' => $reservasi->id,
                    'kode' => $kode,
                    'tanggal' => $waktuFix->format('Y-m-d H:i'),
                    'jumlah_orang' => $reservasi->jumlah_orang,
                    'status' => 'pending',
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat reservasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel reservation
     */
    public function cancel($id)
    {
        try {
            $reservasi = Reservasi::where('user_id', Auth::id())->find($id);

            if (!$reservasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi tidak ditemukan'
                ], 404);
            }

            if ($reservasi->status_id == 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi sudah dibatalkan sebelumnya'
                ], 400);
            }

            // Check if reservation is in the past
            if (Carbon::parse($reservasi->tanggal_reservasi)->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat membatalkan reservasi yang sudah lewat'
                ], 400);
            }

            // Check if less than 2 hours
            $reservationTime = Carbon::parse($reservasi->tanggal_reservasi);
            $hoursUntilReservation = now()->diffInHours($reservationTime, false);

            if ($hoursUntilReservation < 2 && $hoursUntilReservation > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat membatalkan reservasi kurang dari 2 jam sebelum waktu reservasi'
                ], 400);
            }

            $reservasi->status_id = 3; // cancelled
            $reservasi->save();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan reservasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
