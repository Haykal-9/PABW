<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class AdminMenuController extends Controller
{
    public function index()
    {
        $menus = menu::with(['type', 'status'])->get()->map(fn($m) => [
            'id' => $m->id,
            'nama' => $m->nama,
            'kategori' => $m->type->type_name ?? 'N/A',
            'kategori_id' => $m->type_id ?? null,
            'harga' => $m->price,
            'status' => ucwords($m->status->status_name ?? 'N/A'),
            'image_path' => $m->url_foto ? 'foto/' . $m->url_foto : null,
            'deskripsi' => $m->deskripsi,
        ]);

        return view('admin.menu', compact('menus'));
    }

    public function store(Request $request)
    {
        $path_to_save = null;

        if ($request->hasFile('foto_upload')) {
            $file = $request->file('foto_upload');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namaFile);
            $path_to_save = $namaFile;
        }

        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $path_to_save,
            'type_id' => $request->kategori,
            'price' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status,
        ];

        menu::create($menuData);

        return Redirect::route('admin.menu')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $menu = menu::find($id);

        $path_to_save = $menu->url_foto;

        if ($request->hasFile('foto_upload')) {
            if ($menu->url_foto) {
                $oldPath = public_path('foto/' . $menu->url_foto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('foto_upload');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namaFile);
            $path_to_save = $namaFile;
        }

        $menuData = [
            'nama' => $request->nama,
            'url_foto' => $path_to_save,
            'type_id' => $request->kategori,
            'price' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status_id' => $request->status,
        ];

        $menu->update($menuData);

        return Redirect::route('admin.menu')->with('success', 'Menu ' . $request->nama . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = menu::find($id);
        if ($menu->url_foto) {
            $filePath = public_path('foto/' . $menu->url_foto);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $deleted = menu::destroy($id);

        if ($deleted) {
            return response()->noContent();
        }
    }
}
