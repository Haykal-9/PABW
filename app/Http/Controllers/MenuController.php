<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu; // Model Menu utama
use App\Models\menuType; // Model Tipe Menu


class MenuController extends Controller
{
    // Fungsi pembantu untuk memetakan nama kategori DB ke slug JS Filter
    private function mapTypeToSlug(string $typeName): string
    {
        return match (strtolower($typeName)) {
            'kopi' => 'coffee',
            // Asumsi 'minuman' di DB = 'non-coffee' di UI
            'minuman' => 'non-coffee', 
            // Asumsi 'makanan berat' di DB = 'makanan' di UI
            'makanan berat' => 'makanan', 
            'cemilan' => 'cemilan',
            default => 'all', // Default atau kategori tidak dikenal
        };
    }

    public function menu()
    {
        // 1. Ambil semua menu yang berstatus Tersedia (status_id 1)
        // 2. Eager load relasi 'type' (menuType)
        $rawMenus = menu::where('status_id', 1) 
                        ->with('type')
                        ->orderBy('type_id')
                        ->get();

        // 3. Transformasi (Map) data Eloquent ke struktur yang diharapkan oleh Blade dan JS Filter
        $menus = $rawMenus->map(function ($item) {
            // Ambil nama tipe menu dari relasi
            $typeName = $item->type->type_name ?? 'Lain-lain'; 
            $categorySlug = $this->mapTypeToSlug($typeName);
            
            return [
                'id' => $item->id,
                'name' => $item->nama,
                'description_short' => $item->deskripsi ?? 'Tidak ada deskripsi.', 
                'price' => (int) $item->price,
                // Sesuaikan 'image_url' agar dapat dipanggil dengan asset() di Blade
                'image_url' => 'foto/' . $item->url_foto, 
                'category' => $categorySlug, // Slug yang cocok dengan data-category di HTML
            ];
        });

        // Kirim array datar (flat array) bernama '$menus' ke view
        return view('customers.menu', [
            'menus' => $menus,
        ]);
    }
    
    // Asumsi: Ini adalah fungsi untuk detail menu (Anda mungkin perlu mengubahnya nanti)
    public function detailMenu($id)
    {
        $menu = menu::with(['type', 'status'])->findOrFail($id);
        
        // Anda mungkin perlu me-load review atau data terkait lainnya di sini
        
        return view('customers.detail', [
            'menu' => $menu,
        ]);
    }
}