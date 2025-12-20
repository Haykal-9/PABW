<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\review;
use Illuminate\Http\Request;

class AdminRatingApiController extends Controller
{
    // GET /api/admin/ratings
    public function index()
    {
        $ratings = review::with(['user', 'menu_item'])->get()->map(fn($r) => [
            'id' => $r->id,
            'menu' => $r->menu_item->nama ?? 'Menu Dihapus',
            'user' => $r->user->nama ?? 'User Dihapus',
            'rating' => $r->rating,
            'ulasan' => $r->comment,
            'tanggal' => $r->created_at ? $r->created_at->format('Y-m-d') : 'N/A',
        ]);
        return response()->json(['success' => true, 'data' => $ratings], 200);
    }

    // DELETE /api/admin/ratings/{id}
    public function destroy($id)
    {
        $deleted = review::destroy($id);
        return response()->json([
            'success' => (bool)$deleted,
            'message' => $deleted ? 'Rating dihapus' : 'Rating tidak ditemukan',
        ], $deleted ? 200 : 404);
    }
}
