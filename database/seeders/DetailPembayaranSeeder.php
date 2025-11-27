<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_pembayaran')->insert([
            ['id' => 11, 'pembayaran_id' => 7, 'menu_id' => 2, 'quantity' => 2, 'price_per_item' => 22000.00, 'item_notes' => 'Less sugar'],
            ['id' => 12, 'pembayaran_id' => 7, 'menu_id' => 15, 'quantity' => 2, 'price_per_item' => 20000.00, 'item_notes' => 'setengah porsi'],
            ['id' => 13, 'pembayaran_id' => 8, 'menu_id' => 16, 'quantity' => 1, 'price_per_item' => 15000.00, 'item_notes' => 'enak nagihhh'],
            ['id' => 14, 'pembayaran_id' => 9, 'menu_id' => 20, 'quantity' => 1, 'price_per_item' => 13000.00, 'item_notes' => 'extra cabe'],
            ['id' => 15, 'pembayaran_id' => 10, 'menu_id' => 21, 'quantity' => 1, 'price_per_item' => 16000.00, 'item_notes' => 'bestt!!'],
        ]);
    }
}
