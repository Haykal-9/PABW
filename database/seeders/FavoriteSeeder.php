<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('favorites')->insert([
            ['user_id' => 7, 'menu_id' => 1, 'created_at' => '2025-06-15 17:58:32'],
            ['user_id' => 7, 'menu_id' => 21, 'created_at' => '2025-06-15 18:10:51'],
            ['user_id' => 7, 'menu_id' => 22, 'created_at' => '2025-06-15 18:10:53'],
            ['user_id' => 8, 'menu_id' => 9, 'created_at' => '2025-06-16 05:29:50'],
            ['user_id' => 8, 'menu_id' => 19, 'created_at' => '2025-06-16 05:29:55'],
        ]);
    }
}
