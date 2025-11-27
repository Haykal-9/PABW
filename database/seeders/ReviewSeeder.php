<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            ['id' => 4, 'user_id' => 8, 'menu_id' => 1, 'rating' => 5, 'comment' => 'kopinya enak sekali, wajib dicoba sihh', 'created_at' => '2025-06-16 03:18:05'],
            ['id' => 5, 'user_id' => 9, 'menu_id' => 1, 'rating' => 5, 'comment' => 'Enak bangettttt', 'created_at' => '2025-06-16 03:18:34'],
            ['id' => 6, 'user_id' => 8, 'menu_id' => 22, 'rating' => 5, 'comment' => 'risolnya enak bangett', 'created_at' => '2025-06-16 03:19:39'],
            ['id' => 7, 'user_id' => 8, 'menu_id' => 19, 'rating' => 5, 'comment' => 'besttttt!!', 'created_at' => '2025-06-16 03:19:57'],
            ['id' => 8, 'user_id' => 8, 'menu_id' => 20, 'rating' => 5, 'comment' => 'enakkk!!', 'created_at' => '2025-06-16 03:20:16'],
        ]);
    }
}
