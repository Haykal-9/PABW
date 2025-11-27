<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_status')->insert([
            ['id' => 1, 'status_name' => 'tersedia', 'description' => 'Menu tersedia untuk dipesan'],
            ['id' => 2, 'status_name' => 'habis', 'description' => 'Menu tidak tersedia sementara'],
        ]);
    }
}
