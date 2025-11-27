<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservasiDitolakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reservasi_ditolak')->insert([
            ['id' => 2, 'reservation_id' => 10, 'alasan_ditolak' => 'Reservasi Penuh', 'ditolak_oleh' => 'kasir', 'cancelled_at' => '2025-06-16 05:48:15'],
            ['id' => 3, 'reservation_id' => 11, 'alasan_ditolak' => 'Reservasi Penuh', 'ditolak_oleh' => 'kasir', 'cancelled_at' => '2025-06-16 05:48:26'],
            ['id' => 4, 'reservation_id' => 12, 'alasan_ditolak' => 'Reservasi Penuh', 'ditolak_oleh' => 'kasir', 'cancelled_at' => '2025-06-16 05:48:35'],
            ['id' => 5, 'reservation_id' => 13, 'alasan_ditolak' => 'Reservasi Penuh', 'ditolak_oleh' => 'kasir', 'cancelled_at' => '2025-06-16 05:48:42'],
            ['id' => 6, 'reservation_id' => 14, 'alasan_ditolak' => 'Reservasi Penuh', 'ditolak_oleh' => 'kasir', 'cancelled_at' => '2025-06-16 05:48:52'],
        ]);
    }
}
