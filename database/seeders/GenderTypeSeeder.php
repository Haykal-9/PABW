<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gender_types')->insert([
            ['id' => 1, 'gender_name' => 'Laki-laki'],
            ['id' => 2, 'gender_name' => 'Perempuan'],
        ]);
    }
}
