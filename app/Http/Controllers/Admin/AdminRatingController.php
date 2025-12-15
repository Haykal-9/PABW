<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\review;
use Illuminate\Http\Request;

class AdminRatingController extends Controller
{
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

        return view('admin.ratings', compact('ratings'));
    }

    public function destroy($id)
    {
        $deleted = review::destroy($id);

        if ($deleted) {
            return response()->noContent();
        }
    }
}
