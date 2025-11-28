<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\review; // Model review untuk berinteraksi dengan tabel reviews

class ReviewController extends Controller
{
    /**
     * Menyimpan atau memperbarui ulasan dari pelanggan.
     */
    public function store(Request $request)
    {
        // 1. Cek Autentikasi: Wajib login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login untuk memberikan ulasan.');
        }

        // 2. Validasi Input
        $request->validate([
            'menu_id' => 'required|exists:menu,id', 
            'rating' => 'required|integer|min:1|max:5', 
            'comment' => 'nullable|string|max:500',
        ]);
        
        $userId = Auth::id();
        $menuId = $request->menu_id;

        // 3. Cek apakah user sudah pernah mengulas menu ini
        $existingReview = review::where('user_id', $userId)
                                ->where('menu_id', $menuId)
                                ->first();

        if ($existingReview) {
             // Lakukan Update
             $existingReview->rating = $request->rating;
             $existingReview->comment = $request->comment;
             $existingReview->save();
             $message = 'Ulasan Anda berhasil diperbarui!';
        } else {
            // Lakukan Create
            review::create([
                'user_id' => $userId,
                'menu_id' => $menuId,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            $message = 'Ulasan Anda berhasil ditambahkan. Terima kasih!';
        }

        // 4. Redirect kembali ke halaman detail menu
        return redirect()->back()->with('success', $message);
    }
}