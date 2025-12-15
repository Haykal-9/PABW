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
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan ulasan.');
        }

        // Validate input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
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