<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReservationController extends Controller
{
    public function index()
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

    public function destroy($id)
    {
        $reservation = reservasi::find($id);
        $deleted = reservasi::destroy($id);

        if ($deleted) {
            return response()->noContent();
        }
    }
}
