<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Master Data (Tabel Referensi)
            UserRoleSeeder::class,
            GenderTypeSeeder::class,
            MenuTypeSeeder::class,
            MenuStatusSeeder::class,
            OrderTypeSeeder::class,
            PaymentMethodSeeder::class,
            PaymentStatusSeeder::class,
            ReservationStatusSeeder::class,

            // 2. Data Utama (User & Menu)
            UserSeeder::class,
            MenuSeeder::class,

            // 3. Data Transaksi & Relasi
            PembayaranSeeder::class,
            ReservasiSeeder::class,
            FavoriteSeeder::class,
            ReviewSeeder::class,

            // 4. Data Detail Transaksi
            DetailPembayaranSeeder::class,
            ReservasiDitolakSeeder::class,
        ]);
    }
}