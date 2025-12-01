<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review; // Pastikan namespace Model benar (Review/review)

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan baru (Bisa berkali-kali).
     */
    public function store(Request $request, $id) 
    {
        // 1. Tentukan User (Hybrid: Login atau User 7)
        $userId = Auth::id() ?? 7; 

        // 2. Validasi Input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', 
            'comment' => 'required|string|max:500',
        ]);
        
        $menuId = $id; // ID Menu diambil dari URL

        // 3. LANGSUNG SIMPAN (CREATE)
        Review::create([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $message = 'Ulasan Anda berhasil ditambahkan!';

        // 4. Redirect kembali ke halaman detail menu
        return redirect()->back()->with('success', $message);
    }
}