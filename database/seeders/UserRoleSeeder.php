<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            ['id' => 1, 'role_name' => 'admin', 'description' => 'Administrator sistem dengan hak akses penuh'],
            ['id' => 2, 'role_name' => 'kasir', 'description' => 'Staf kasir untuk mengelola transaksi penjualan'],
            ['id' => 3, 'role_name' => 'member', 'description' => 'Pengguna umum atau pelanggan'],
        ]);
    }
}
