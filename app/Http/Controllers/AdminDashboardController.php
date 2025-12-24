<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\reservasi;
use App\Models\detailPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $adminName = Auth::user()->nama;
        $today = Carbon::today();

        $totalPendapatan = detailPembayaran::selectRaw('SUM(quantity * price_per_item) as total')
            ->value('total') ?? 0;

        $pendapatanHariIni = detailPembayaran::whereHas('pembayaran', function ($query) use ($today) {
            $query->whereDate('order_date', $today);
        })
            ->selectRaw('SUM(quantity * price_per_item) as total')  
            ->value('total') ?? 0;

        $menuTerjualHariIni = detailPembayaran::whereHas('pembayaran', function ($query) use ($today) {
            $query->whereDate('order_date', $today);
        })->sum('quantity') ?? 0;

        $reservasiTerlaksana = reservasi::where('status_id', 2)->count() ?? 0;

        // Ambil data penjualan per menu (top menu)
        $menuSales = \App\Models\detailPembayaran::selectRaw('menu_id, SUM(quantity) as total_order')
            ->groupBy('menu_id')
            ->orderByDesc('total_order')
            ->with('menu')
            ->get();

        // Ambil data pendapatan per hari untuk grafik bulanan
        $year = request('year') ?? date('Y');
        $monthlyIncome = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyIncome[$month] = detailPembayaran::whereHas('pembayaran', function($query) use ($year, $month) {
                $query->whereYear('order_date', $year)
                      ->whereMonth('order_date', $month);
            })->selectRaw('SUM(quantity * price_per_item) as total')->value('total') ?? 0;
        }

        $data = [
            'pendapatanHariIni' => $pendapatanHariIni,
            'menuTerjualHariIni' => $menuTerjualHariIni,
            'totalPendapatan' => $totalPendapatan,
            'reservasiTerlaksana' => $reservasiTerlaksana,
            'adminName' => $adminName,
        ];

        return view('admin.dashboard', compact('data', 'menuSales', 'monthlyIncome', 'year'));
    }
}
