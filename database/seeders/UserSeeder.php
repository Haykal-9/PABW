<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'role_id' => 1,
                'username' => 'admin',
                'password' => 'admin123',
                'nama' => 'admin tapal kuda',
                'email' => 'tapalkuda@gmail.com',
                'no_telp' => '06790879769',
                'gender_id' => 1,
                'alamat' => 'jl. sumedang',
                'profile_picture' => 'null',
                'created_at' => null,
                'updated_at' => null
            ],
            [
                'id' => 2,
                'role_id' => 2,
                'username' => 'kasir',
                'password' => 'kasir123',
                'nama' => 'kasir tapal kuda',
                'email' => 'kasirtapal@gmail.com',
                'no_telp' => '09679697283',
                'gender_id' => 2,
                'alamat' => 'jl. kebon jeruk 04',
                'profile_picture' => 'null',
                'created_at' => null,
                'updated_at' => null
            ],
            [
                'id' => 7,
                'role_id' => 3,
                'username' => 'salman',
                'password' => 'salman123',
                'nama' => 'ridhwan q',
                'email' => 'salmanridhwan@student.telkomuniversity.ac.id',
                'no_telp' => '0895412194060',
                'gender_id' => 1,
                'alamat' => '0',
                'profile_picture' => 'default-avatar.png',
                'created_at' => '2025-06-15 17:35:03',
                'updated_at' => '2025-06-15 17:35:03'
            ],
            [
                'id' => 8,
                'role_id' => 3,
                'username' => 'bian',
                'password' => 'bian123',
                'nama' => 'biantara',
                'email' => 'biantarawi@gmail.com',
                'no_telp' => '083130919334',
                'gender_id' => 1,
                'alamat' => '0',
                'profile_picture' => 'profile_684f8c6bc7380.png',
                'created_at' => '2025-06-16 03:15:55',
                'updated_at' => '2025-06-16 03:15:55'
            ],
            [
                'id' => 9,
                'role_id' => 3,
                'username' => 'haykal',
                'password' => 'haykal123',
                'nama' => 'M haykal',
                'email' => 'haykal@gmail.com',
                'no_telp' => '087684747333',
                'gender_id' => 1,
                'alamat' => '0',
                'profile_picture' => 'default-avatar.png',
                'created_at' => '2025-06-16 03:17:03',
                'updated_at' => '2025-06-16 03:17:03'
            ],
        ]);
    }
}
