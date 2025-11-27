<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reservasi')->insert([
            ['id' => 5, 'user_id' => 9, 'kode_reservasi' => 'RSV20250616073443524', 'tanggal_reservasi' => '2025-06-17 17:00:00', 'jumlah_orang' => 4, 'message' => 'Buka bersama', 'status_id' => 2, 'created_at' => '2025-06-16 05:34:43', 'updated_at' => '2025-06-16 05:42:38'],
            ['id' => 6, 'user_id' => 9, 'kode_reservasi' => 'RSV20250616073826429', 'tanggal_reservasi' => '2025-06-21 12:30:00', 'jumlah_orang' => 5, 'message' => 'Acara keluarga', 'status_id' => 2, 'created_at' => '2025-06-16 05:38:26', 'updated_at' => '2025-06-16 05:42:39'],
            ['id' => 7, 'user_id' => 9, 'kode_reservasi' => 'RSV20250616073907438', 'tanggal_reservasi' => '2025-06-19 12:00:00', 'jumlah_orang' => 6, 'message' => 'meeting', 'status_id' => 2, 'created_at' => '2025-06-16 05:39:07', 'updated_at' => '2025-06-16 05:42:39'],
            ['id' => 8, 'user_id' => 8, 'kode_reservasi' => 'RSV20250616074033831', 'tanggal_reservasi' => '2025-06-22 15:30:00', 'jumlah_orang' => 2, 'message' => 'Arisan Keluarga', 'status_id' => 2, 'created_at' => '2025-06-16 05:40:33', 'updated_at' => '2025-06-16 05:42:40'],
            ['id' => 9, 'user_id' => 8, 'kode_reservasi' => 'RSV20250616074136785', 'tanggal_reservasi' => '2025-06-18 20:00:00', 'jumlah_orang' => 2, 'message' => 'Dinner keluarga', 'status_id' => 2, 'created_at' => '2025-06-16 05:41:36', 'updated_at' => '2025-06-16 05:42:40'],
            ['id' => 10, 'user_id' => 8, 'kode_reservasi' => 'RSV20250616074422916', 'tanggal_reservasi' => '2025-06-19 15:00:00', 'jumlah_orang' => 15, 'message' => 'Acara ulang tahun anak', 'status_id' => 3, 'created_at' => '2025-06-16 05:44:22', 'updated_at' => '2025-06-16 05:48:15'],
            ['id' => 11, 'user_id' => 8, 'kode_reservasi' => 'RSV20250616074515627', 'tanggal_reservasi' => '2025-06-24 14:00:00', 'jumlah_orang' => 5, 'message' => 'Outdoor', 'status_id' => 3, 'created_at' => '2025-06-16 05:45:15', 'updated_at' => '2025-06-16 05:48:26'],
            ['id' => 12, 'user_id' => 9, 'kode_reservasi' => 'RSV20250616074555866', 'tanggal_reservasi' => '2025-06-25 19:00:00', 'jumlah_orang' => 7, 'message' => 'Indoor', 'status_id' => 3, 'created_at' => '2025-06-16 05:45:55', 'updated_at' => '2025-06-16 05:48:35'],
            ['id' => 13, 'user_id' => 9, 'kode_reservasi' => 'RSV20250616074641143', 'tanggal_reservasi' => '2025-06-18 15:00:00', 'jumlah_orang' => 3, 'message' => 'Indoor yaaa', 'status_id' => 3, 'created_at' => '2025-06-16 05:46:41', 'updated_at' => '2025-06-16 05:48:42'],
            ['id' => 14, 'user_id' => 7, 'kode_reservasi' => 'RSV20250616074736369', 'tanggal_reservasi' => '2025-06-20 19:30:00', 'jumlah_orang' => 2, 'message' => 'Ultah istri', 'status_id' => 3, 'created_at' => '2025-06-16 05:47:36', 'updated_at' => '2025-06-16 05:48:52'],
        ]);
    }
}
