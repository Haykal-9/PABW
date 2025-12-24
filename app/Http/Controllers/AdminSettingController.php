<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetPendapatan;

class AdminSettingController extends Controller
{
    public function index()
    {
        $target = TargetPendapatan::latest()->first();
        return view('admin.settings', compact('target'));
    }

    public function setTarget(Request $request)
    {
        $request->validate([
            'target' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        TargetPendapatan::create([
            'target' => $request->target,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return redirect()->route('admin.settings')->with('success', 'Target pendapatan berhasil disimpan!');
    }
}
