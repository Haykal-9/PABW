<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\reservasi;
use Illuminate\Http\Request;

class AdminReservationApiController extends Controller
{
    // GET /api/admin/reservations
    public function index()
    {
        $reservations = reservasi::with(['user', 'status'])->get()->map(fn($r) => [
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
        ]);
        return response()->json(['success' => true, 'data' => $reservations], 200);
    }

    // DELETE /api/admin/reservations/{id}
    public function destroy($id)
    {
        $deleted = reservasi::destroy($id);
        return response()->json([
            'success' => (bool)$deleted,
            'message' => $deleted ? 'Reservasi dihapus' : 'Reservasi tidak ditemukan',
        ], $deleted ? 200 : 404);
    }
}
