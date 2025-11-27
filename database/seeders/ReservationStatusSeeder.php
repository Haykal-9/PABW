<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reservation_status')->insert([
            ['id' => 1, 'status_name' => 'pending', 'description' => 'Reservasi menunggu konfirmasi'],
            ['id' => 2, 'status_name' => 'dikonfirmasi', 'description' => 'Reservasi telah dikonfirmasi'],
            ['id' => 3, 'status_name' => 'dibatalkan', 'description' => 'Reservasi dibatalkan'],
        ]);
    }
}
