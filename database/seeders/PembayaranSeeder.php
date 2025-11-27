<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembayaran')->insert([
            ['id' => 3, 'user_id' => 7, 'order_date' => '2025-06-16 09:15:00', 'status_id' => 2, 'payment_method_id' => 3, 'order_type_id' => 3],
            ['id' => 7, 'user_id' => 8, 'order_date' => '2025-06-16 10:32:41', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 1],
            ['id' => 8, 'user_id' => 8, 'order_date' => '2025-06-16 12:25:38', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 1],
            ['id' => 9, 'user_id' => 8, 'order_date' => '2025-06-16 12:27:34', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 2],
            ['id' => 10, 'user_id' => 8, 'order_date' => '2025-06-16 12:29:18', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 1],
        ]);
    }
}
