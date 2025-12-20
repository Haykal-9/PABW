<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminMenuApiController extends Controller
{
    /**
     * GET /api/admin/menus
     * List semua menu
     */
    public function index()
    {
        $menus = menu::with(['type', 'status'])->get()->map(fn($m) => [
            'id' => $m->id,
            'nama' => $m->nama,
            'kategori' => $m->type->type_name ?? 'N/A',
            'kategori_id' => $m->type_id,
            'harga' => $m->price,
            'status' => $m->status->status_name ?? 'N/A',
            'status_id' => $m->status_id,
            'image_url' => $m->url_foto ? url('foto/' . $m->url_foto) : null,
            'deskripsi' => $m->deskripsi,
        ]);

        return response()->json([
            'success' => true,
            'data' => $menus,
        ], 200);
    }

    /**
     * GET /api/admin/menus/{id}
     * Detail menu
     */
    public function show($id)
    {
        $menu = menu::with(['type', 'status'])->find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu not found',
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
                'status' => $menu->status->status_name ?? 'N/A',
                'status_id' => $menu->status_id,
                'image_url' => $menu->url_foto ? url('foto/' . $menu->url_foto) : null,
                'deskripsi' => $menu->deskripsi,
            ],
        ], 200);
    }

    /**
     * POST /api/admin/menus
     * Tambah menu baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|integer|exists:menu_types,id',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|integer|exists:menu_statuses,id',
            'foto_upload' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path_to_save = null;

        if ($request->hasFile('foto_upload')) {
            $file = $request->file('foto_upload');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namaFile);
            $path_to_save = $namaFile;
        }

        $menu = menu::create([
            'nama' => $validated['nama'],
            'url_foto' => $path_to_save,
            'type_id' => $validated['kategori'],
            'price' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status_id' => $validated['status'],
        ]);

        \Log::info('Menu ditambahkan via API oleh ' . auth()->user()->nama . ' (ID: ' . auth()->id() . ')');

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan',
            'data' => [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->price,
                'image_url' => $menu->url_foto ? url('foto/' . $menu->url_foto) : null,
            ],
        ], 201);
    }

    /**
     * PUT /api/admin/menus/{id}
     * Update menu
     */
    public function update(Request $request, $id)
    {
        $menu = menu::find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu not found',
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|integer|exists:menu_types,id',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|integer|exists:menu_statuses,id',
            'foto_upload' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path_to_save = $menu->url_foto;

        if ($request->hasFile('foto_upload')) {
            // Hapus foto lama
            if ($menu->url_foto) {
                $oldPath = public_path('foto/' . $menu->url_foto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // Upload foto baru
            $file = $request->file('foto_upload');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namaFile);
            $path_to_save = $namaFile;
        }

        $menu->update([
            'nama' => $validated['nama'],
            'url_foto' => $path_to_save,
            'type_id' => $validated['kategori'],
            'price' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status_id' => $validated['status'],
        ]);

        \Log::info('Menu ' . $menu->nama . ' diperbarui via API oleh ' . auth()->user()->nama . ' (ID: ' . auth()->id() . ')');

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diperbarui',
            'data' => [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->price,
                'image_url' => $menu->url_foto ? url('foto/' . $menu->url_foto) : null,
            ],
        ], 200);
    }

    /**
     * DELETE /api/admin/menus/{id}
     * Hapus menu
     */
    public function destroy($id)
    {
        $menu = menu::find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu not found',
            ], 404);
        }

        // Hapus file foto
        if ($menu->url_foto) {
            $filePath = public_path('foto/' . $menu->url_foto);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $menu->delete();

        \Log::info('Menu ID ' . $id . ' dihapus via API oleh ' . auth()->user()->nama . ' (ID: ' . auth()->id() . ')');

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dihapus',
        ], 200);
    }
}
