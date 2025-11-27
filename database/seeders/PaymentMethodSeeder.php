<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            ['id' => 1, 'method_name' => 'cash', 'description' => 'Pembayaran tunai'],
            ['id' => 2, 'method_name' => 'e-wallet', 'description' => 'Pembayaran melalui dompet digital'],
            ['id' => 3, 'method_name' => 'qris', 'description' => 'Pembayaran melalui QRIS'],
        ]);
    }
}
