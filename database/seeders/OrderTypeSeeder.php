<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_types')->insert([
            ['id' => 1, 'type_name' => 'dine_in', 'description' => 'Makan di tempat'],
            ['id' => 2, 'type_name' => 'take_away', 'description' => 'Ambil sendiri'],
            ['id' => 3, 'type_name' => 'delivery', 'description' => 'Diantarkan ke lokasi'],
        ]);
    }
}
