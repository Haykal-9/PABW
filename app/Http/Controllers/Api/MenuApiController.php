<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Favorite;

class MenuApiController extends Controller
{
    /**
     * Get all menus (public)
     */
    public function index(Request $request)
    {
        $query = Menu::with('type')->withAvg('reviews', 'rating');

        // Category filter
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('type', function ($q) use ($request) {
                $q->where('type_name', $request->category);
            });
        }

        // Search filter
        if ($request->has('search') && $request->search != null) {
            $searchTerm = $request->search;
            $query->where('nama', 'like', "%{$searchTerm}%");
        }

        // Status filter (only available)
        if ($request->has('available_only') && $request->available_only) {
            $query->where('status_id', 1);
        }

        $menus = $query->get();

        // Add favorite status if user is authenticated
        $userId = Auth::id();
        $favoriteMenuIds = [];
        if ($userId) {
            $favoriteMenuIds = Favorite::where('user_id', $userId)->pluck('menu_id')->toArray();
        }

        $data = $menus->map(function ($menu) use ($favoriteMenuIds) {
            return [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->price,
                'kategori' => $menu->type->type_name ?? null,
                'deskripsi' => $menu->deskripsi,
                'status' => $menu->status_id == 1 ? 'tersedia' : 'tidak tersedia',
                'image_url' => $menu->url_foto ? asset('foto/' . $menu->url_foto) : null,
                'rating' => round($menu->reviews_avg_rating ?? 0, 1),
                'is_favorited' => in_array($menu->id, $favoriteMenuIds),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get menu detail (public)
     */
    public function show($id)
    {
        $menu = Menu::with(['type', 'reviews.user'])->withAvg('reviews', 'rating')->find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        // Check if favorited
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Favorite::where('user_id', Auth::id())
                ->where('menu_id', $id)
                ->exists();
        }

        $reviews = $menu->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user' => $review->user->nama ?? 'Anonymous',
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->price,
                'kategori' => $menu->type->type_name ?? null,
                'deskripsi' => $menu->deskripsi,
                'status' => $menu->status_id == 1 ? 'tersedia' : 'tidak tersedia',
                'image_url' => $menu->url_foto ? asset('foto/' . $menu->url_foto) : null,
                'rating' => round($menu->reviews_avg_rating ?? 0, 1),
                'is_favorited' => $isFavorited,
                'reviews' => $reviews,
            ]
        ]);
    }

    /**
     * Toggle favorite (auth required)
     */
    public function toggleFavorite($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        $userId = Auth::id();
        $exists = Favorite::where('user_id', $userId)
            ->where('menu_id', $id)
            ->exists();

        if ($exists) {
            Favorite::where('user_id', $userId)
                ->where('menu_id', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Menu dihapus dari favorit',
                'is_favorited' => false
            ]);
        } else {
            Favorite::create([
                'user_id' => $userId,
                'menu_id' => $id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu ditambahkan ke favorit',
                'is_favorited' => true
            ]);
        }
    }

    /**
     * Get user favorites
     */
    public function favorites()
    {
        $favoriteMenuIds = Favorite::where('user_id', Auth::id())->pluck('menu_id');

        $menus = Menu::with('type')
            ->withAvg('reviews', 'rating')
            ->whereIn('id', $favoriteMenuIds)
            ->get();

        $data = $menus->map(function ($menu) {
            return [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->price,
                'kategori' => $menu->type->type_name ?? null,
                'image_url' => $menu->url_foto ? asset('foto/' . $menu->url_foto) : null,
                'rating' => round($menu->reviews_avg_rating ?? 0, 1),
                'is_favorited' => true,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
