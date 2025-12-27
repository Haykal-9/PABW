<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\menu;


class AdminRatingController extends Controller
{
    public function index()
    {
        $query = review::with(['user', 'menu_item']);
        $selectedMenu = request('menu');
        if ($selectedMenu) {
            $query->whereHas('menu_item', function($q) use ($selectedMenu) {
                $q->where('nama', $selectedMenu);
            });
        }
        $reviews = $query->get();
        $ratings = $reviews->map(fn($r) => [
            'id' => $r->id,
            'menu' => $r->menu_item->nama ?? 'Menu Dihapus',
            'user' => $r->user->nama ?? 'User Dihapus',
            'rating' => $r->rating,
            'ulasan' => $r->comment,
            'tanggal' => $r->created_at ? $r->created_at->format('Y-m-d') : 'N/A',
        ]);

        // Ambil semua nama menu unik untuk filter
        $menus = menu::pluck('nama')->unique();

        return view('admin.ratings', compact('ratings', 'menus', 'reviews', 'selectedMenu'));
    }

    public function destroy($id)
    {
        $rating = review::find($id);
        $deleted = review::destroy($id);

        if ($deleted) {
            \Log::info('Rating ID ' . $id . ' dihapus oleh ' . Auth::user()->nama . ' (ID: ' . Auth::id() . ')');
            return response()->noContent();
        }
    }
}
