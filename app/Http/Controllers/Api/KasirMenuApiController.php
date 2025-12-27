<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\menu;

class KasirMenuApiController extends Controller
{
    /**
     * Get all menus for kasir management
     */
    public function index()
    {
        $menuData = menu::with(['type', 'status'])
            ->orderBy('type_id')
            ->orderBy('nama')
            ->get();

        $menus = $menuData->map(function ($m) {
            return [
                'id' => $m->id,
                'nama' => $m->nama,
                'kategori' => $m->type->type_name ?? 'N/A',
                'kategori_id' => $m->type_id,
                'harga' => $m->price,
                'status' => ucfirst($m->status->status_name ?? 'N/A'),
                'status_id' => $m->status_id,
                'image_url' => $m->url_foto ? asset('foto/' . $m->url_foto) : null,
                'deskripsi' => $m->deskripsi,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    /**
     * Get single menu detail
     */
    public function show($id)
    {
        $menu = menu::with(['type', 'status'])->find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'kategori' => $menu->type->type_name ?? 'N/A',
                'kategori_id' => $menu->type_id,
                'harga' => $menu->price,
                'status' => ucfirst($menu->status->status_name ?? 'N/A'),
                'status_id' => $menu->status_id,
                'image_url' => $menu->url_foto ? asset('foto/' . $menu->url_foto) : null,
                'deskripsi' => $menu->deskripsi,
            ]
        ]);
    }

    /**
     * Store new menu
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:100',
                'kategori' => 'required|integer|exists:menu_types,id',
                'harga' => 'required|numeric|min:0',
                'status' => 'required|integer|in:1,2',
                'deskripsi' => 'nullable|string',
                'foto_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path_to_save = null;
            if ($request->hasFile('foto_upload')) {
                $file = $request->file('foto_upload');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('foto'), $namaFile);
                $path_to_save = $namaFile;
            }

            $menu = menu::create([
                'nama' => $request->nama,
                'url_foto' => $path_to_save,
                'type_id' => $request->kategori,
                'price' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'status_id' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan',
                'data' => [
                    'id' => $menu->id,
                    'nama' => $menu->nama,
                    'harga' => $menu->price,
                    'image_url' => $menu->url_foto ? asset('foto/' . $menu->url_foto) : null,
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
                'message' => 'Gagal menambahkan menu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update existing menu
     */
    public function update(Request $request, $id)
    {
        try {
            $menu = menu::find($id);

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'nama' => 'required|string|max:100',
                'kategori' => 'required|integer|exists:menu_types,id',
                'harga' => 'required|numeric|min:0',
                'status' => 'required|integer|in:1,2',
                'deskripsi' => 'nullable|string',
                'foto_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path_to_save = $menu->url_foto;

            if ($request->hasFile('foto_upload')) {
                // Delete old file
                if ($menu->url_foto) {
                    $oldPath = public_path('foto/' . $menu->url_foto);
                    if (\File::exists($oldPath)) {
                        \File::delete($oldPath);
                    }
                }

                $file = $request->file('foto_upload');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('foto'), $namaFile);
                $path_to_save = $namaFile;
            }

            $menu->update([
                'nama' => $request->nama,
                'url_foto' => $path_to_save,
                'type_id' => $request->kategori,
                'price' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'status_id' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diperbarui',
                'data' => [
                    'id' => $menu->id,
                    'nama' => $menu->nama,
                    'harga' => $menu->price,
                    'image_url' => $menu->url_foto ? asset('foto/' . $menu->url_foto) : null,
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
                'message' => 'Gagal memperbarui menu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete menu
     */
    public function destroy($id)
    {
        try {
            $menu = menu::find($id);

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak ditemukan'
                ], 404);
            }

            // Delete photo file
            if ($menu->url_foto) {
                $filePath = public_path('foto/' . $menu->url_foto);
                if (\File::exists($filePath)) {
                    \File::delete($filePath);
                }
            }

            $menu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus menu: ' . $e->getMessage()
            ], 500);
        }
    }
}
