<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TargetPendapatan;
use App\Models\pembayaran;
use App\Models\Notification;
use Carbon\Carbon;

class CheckTargetPendapatan extends Command
{
    protected $signature = 'target:check';
    protected $description = 'Cek apakah target pendapatan tercapai dan kirim notifikasi admin';

    public function handle()
    {
        $target = TargetPendapatan::latest()->first();
        if (!$target) return;
        $now = Carbon::now();
        if ($now->lt(Carbon::parse($target->start_date)) || $now->gt(Carbon::parse($target->end_date))) return;
        $total = pembayaran::whereBetween('order_date', [$target->start_date, $target->end_date])
            ->whereHas('status', function($q){ $q->where('status_name', 'Sudah Bayar'); })
            ->sum('total_bayar');
        if ($total >= $target->target && !Notification::where('type','target_achieved')->where('created_at','>=',$target->start_date)->exists()) {
            Notification::create([
                'user_id' => 1,
                'type' => 'target_achieved',
                'title' => 'Target Pendapatan Tercapai',
                'message' => 'Selamat! Target pendapatan sebesar Rp '.number_format($target->target,0,',','.').' telah tercapai.',
                'link' => null,
                'is_read' => false,
            ]);
        }
    }
}
