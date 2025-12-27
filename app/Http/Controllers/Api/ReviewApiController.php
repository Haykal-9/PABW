<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Menu;

class ReviewApiController extends Controller
{
    /**
     * Add review to a menu
     */
    public function store(Request $request, $menuId)
    {
        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);

            // Check if menu exists
            $menu = Menu::find($menuId);

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak ditemukan'
                ], 404);
            }

            // Check if user already reviewed this menu
            $existingReview = Review::where('user_id', Auth::id())
                ->where('menu_id', $menuId)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memberikan ulasan untuk menu ini'
                ], 400);
            }

            // Create review
            $review = Review::create([
                'user_id' => Auth::id(),
                'menu_id' => $menuId,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil ditambahkan',
                'data' => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->format('Y-m-d H:i:s'),
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan ulasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user's review
     */
    public function update(Request $request, $menuId)
    {
        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);

            $review = Review::where('user_id', Auth::id())
                ->where('menu_id', $menuId)
                ->first();

            if (!$review) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ulasan tidak ditemukan'
                ], 404);
            }

            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil diperbarui',
                'data' => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui ulasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user's review
     */
    public function destroy($menuId)
    {
        try {
            $review = Review::where('user_id', Auth::id())
                ->where('menu_id', $menuId)
                ->first();

            if (!$review) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ulasan tidak ditemukan'
                ], 404);
            }

            $review->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus ulasan: ' . $e->getMessage()
            ], 500);
        }
    }
}
