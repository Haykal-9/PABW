<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\review; 
use App\Models\menuType;
use Illuminate\Support\Facades\Auth; // HANYA PERLU INI UNTUK OTENTIKASI

class MenuController extends Controller
{
    private function mapTypeToSlug(string $typeName): string
    {
        return match (strtolower($typeName)) {
            'kopi' => 'coffee',
            'minuman' => 'non-coffee', 
            'makanan berat' => 'makanan', 
            'cemilan' => 'cemilan',
            default => 'all',
        };
    }

    public function menu()
    {
        $rawMenus = menu::where('status_id', 1) 
                        ->with('type')
                        ->orderBy('type_id')
                        ->get();

        $menus = $rawMenus->map(function ($item) {
            $typeName = $item->type->type_name ?? 'Lain-lain'; 
            $categorySlug = $this->mapTypeToSlug($typeName);
            
            return [
                'id' => $item->id,
                'name' => $item->nama,
                'description_short' => $item->deskripsi ?? 'Tidak ada deskripsi.', 
                'price' => (int) $item->price,
                'image_url' => 'foto/' . $item->url_foto, 
                'category' => $categorySlug,
            ];
        });

        return view('customers.menu', [
            'menus' => $menus,
        ]);
    }
    
    // Method untuk menampilkan detail menu berdasarkan ID
    public function detailMenu($id)
    {
        // Temukan menu atau lempar error 404
        $menu = menu::with(['type', 'status'])->findOrFail($id);
        
        // Cek apakah pengguna sedang login untuk mengambil ulasan mereka
        $userReview = null;
        if (Auth::check()) {
            // Mengambil ulasan yang sudah dibuat user ini (jika ada)
            $userReview = review::where('menu_id', $id)
                                ->where('user_id', Auth::id()) 
                                ->first();
        }
        
        // Hitung rating rata-rata
        $averageRating = review::where('menu_id', $id)->avg('rating');
        
        // Ambil semua ulasan, urutkan dari terbaru
        $reviews = review::where('menu_id', $id)
            ->with('user') 
            ->latest()
            ->get();
        
        // Kembalikan ke view
        return view('customers.detail', [
            'menu' => $menu,
            'averageRating' => $averageRating,
            'reviews' => $reviews, 
            'userReview' => $userReview,
        ]);
    }
    
    // Method storeReview yang lama telah dihapus dan dipindahkan ke ReviewController
}