<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review; 

class ReviewController extends Controller
{
    public function store(Request $request, $id) 
    {
        $userId = Auth::id() ?? 7; 
        
        $menuId = $id; 

        Review::create([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $message = 'Ulasan Anda berhasil ditambahkan!';

        return redirect()->back()->with('success', $message);
    }
}