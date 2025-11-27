<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_types')->insert([
            ['id' => 1, 'type_name' => 'kopi', 'description' => 'Minuman berbahan dasar kopi'],
            ['id' => 2, 'type_name' => 'minuman', 'description' => 'Minuman non-kopi'],
            ['id' => 3, 'type_name' => 'makanan_berat', 'description' => 'Hidangan utama'],
            ['id' => 4, 'type_name' => 'cemilan', 'description' => 'Camilan atau makanan ringan'],
        ]);
    }
}
