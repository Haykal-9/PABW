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
            // ID 3: Asumsi total price 50000
            ['id' => 3, 'user_id' => 7, 'order_date' => '2025-06-16 09:15:00', 'status_id' => 2, 'payment_method_id' => 3, 'order_type_id' => 3, 'total_price' => 50000.00], 
            
            // ID 7: (2*22000) + (2*20000) = 44000 + 40000 = 84000
            ['id' => 7, 'user_id' => 8, 'order_date' => '2025-06-16 10:32:41', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 1, 'total_price' => 84000.00], 
            
            // ID 8: 1*15000 = 15000
            ['id' => 8, 'user_id' => 8, 'order_date' => '2025-06-16 12:25:38', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 1, 'total_price' => 15000.00], 
            
            // ID 9: 1*13000 = 13000
            ['id' => 9, 'user_id' => 8, 'order_date' => '2025-06-16 12:27:34', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 2, 'total_price' => 13000.00], 
            
            // ID 10: 1*16000 = 16000
            ['id' => 10, 'user_id' => 8, 'order_date' => '2025-06-16 12:29:18', 'status_id' => 1, 'payment_method_id' => 1, 'order_type_id' => 1, 'total_price' => 16000.00],
        ]);
    }
}