<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Menu;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validate id parameter
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->back()->with('error', 'ID menu tidak valid');
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan ulasan.');
        }

        // Validate input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|min:3|max:1000',
        ], [
            'rating.required' => 'Rating harus diisi',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'comment.min' => 'Komentar minimal 3 karakter',
            'comment.max' => 'Komentar maksimal 1000 karakter'
        ]);

        // Check if menu exists
        $menu = Menu::findOrFail($id);

        // Check if user already reviewed this menu
        $existingReview = Review::where('user_id', Auth::id())
            ->where('menu_id', $id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk menu ini.');
        }

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'menu_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil ditambahkan!');
    }
}