<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_status')->insert([
            ['id' => 1, 'status_name' => 'completed', 'description' => 'Pembayaran berhasil'],
            ['id' => 2, 'status_name' => 'pending', 'description' => 'Menunggu pembayaran'],
            ['id' => 3, 'status_name' => 'cancelled', 'description' => 'Pembayaran dibatalkan'],
        ]);
    }
}
