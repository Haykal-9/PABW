<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;

class KasirMenuController extends Controller
{
    /**
     * Menampilkan halaman manajemen menu untuk kasir
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
                'type_id' => $m->type_id,
                'harga' => $m->price,
                'status' => ucfirst($m->status->status_name ?? 'N/A'),
                'status_id' => $m->status_id,
                'image_path' => $m->url_foto ? 'foto/' . $m->url_foto : null,
                'deskripsi' => $m->deskripsi,
            ];
        })->toArray();

        return view('kasir.menu', [
            'title' => 'Tapal Kuda | Manajemen Menu',
            'activePage' => 'menu',
            'menus' => $menus,
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
                'kategori' => 'required|integer',
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

            menu::create([
                'nama' => $request->nama,
                'url_foto' => $path_to_save,
                'type_id' => $request->kategori,
                'price' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'status_id' => $request->status,
            ]);

            return redirect()->route('kasir.menu')->with('success', 'Menu "' . $request->nama . '" berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('kasir.menu')->with('error', 'Gagal menambahkan menu: ' . $e->getMessage());
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
                return redirect()->route('kasir.menu')->with('error', 'Menu tidak ditemukan.');
            }

            $request->validate([
                'nama' => 'required|string|max:100',
                'kategori' => 'required|integer',
                'harga' => 'required|numeric|min:0',
                'status' => 'required|integer|in:1,2',
                'deskripsi' => 'nullable|string',
                'foto_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path_to_save = $menu->url_foto;

            if ($request->hasFile('foto_upload')) {
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

            return redirect()->route('kasir.menu')->with('success', 'Menu "' . $request->nama . '" berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('kasir.menu')->with('error', 'Gagal memperbarui menu: ' . $e->getMessage());
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
                return response('Menu tidak ditemukan.', 404);
            }

            if ($menu->url_foto) {
                $filePath = public_path('foto/' . $menu->url_foto);
                if (\File::exists($filePath)) {
                    \File::delete($filePath);
                }
            }

            $menu->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return response('Gagal menghapus menu: ' . $e->getMessage(), 500);
        }
    }
}
