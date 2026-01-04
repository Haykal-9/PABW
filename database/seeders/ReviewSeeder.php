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
        $reviews = [
            // Menu 1: Kopi Tubruk Arabika
            ['user_id' => 8, 'menu_id' => 1, 'rating' => 5, 'comment' => 'Kopinya enak sekali, wajib dicoba sihh', 'created_at' => '2025-06-16 03:18:05'],
            ['user_id' => 9, 'menu_id' => 1, 'rating' => 5, 'comment' => 'Enak bangettttt', 'created_at' => '2025-06-16 03:18:34'],
            ['user_id' => 10, 'menu_id' => 1, 'rating' => 4, 'comment' => 'Kopi tubruknya authentic, rasanya strong', 'created_at' => '2025-06-17 08:30:00'],
            
            // Menu 2: Cappucino
            ['user_id' => 8, 'menu_id' => 2, 'rating' => 5, 'comment' => 'Cappucino terbaik yang pernah saya coba!', 'created_at' => '2025-06-16 09:15:00'],
            ['user_id' => 9, 'menu_id' => 2, 'rating' => 4, 'comment' => 'Foam-nya lembut, balance antara kopi dan susu', 'created_at' => '2025-06-17 10:20:00'],
            
            // Menu 3: ES Kopi Susu
            ['user_id' => 8, 'menu_id' => 3, 'rating' => 5, 'comment' => 'Seger banget! Perfect untuk cuaca panas', 'created_at' => '2025-06-16 11:00:00'],
            ['user_id' => 10, 'menu_id' => 3, 'rating' => 5, 'comment' => 'Kopi susu favorit! Gak terlalu manis', 'created_at' => '2025-06-18 13:45:00'],
            ['user_id' => 9, 'menu_id' => 3, 'rating' => 4, 'comment' => 'Recommended deh, harganya juga oke', 'created_at' => '2025-06-19 15:30:00'],
            
            // Menu 4: Espresso
            ['user_id' => 8, 'menu_id' => 4, 'rating' => 5, 'comment' => 'Espresso yang strong dan aromatic', 'created_at' => '2025-06-17 07:00:00'],
            ['user_id' => 9, 'menu_id' => 4, 'rating' => 4, 'comment' => 'Pas buat yang suka kopi pahit', 'created_at' => '2025-06-18 08:15:00'],
            
            // Menu 5: Espresso Double
            ['user_id' => 10, 'menu_id' => 5, 'rating' => 5, 'comment' => 'Mantap buat ngerjain tugas begadang!', 'created_at' => '2025-06-17 22:00:00'],
            ['user_id' => 8, 'menu_id' => 5, 'rating' => 5, 'comment' => 'Langsung melek ini mah', 'created_at' => '2025-06-18 06:30:00'],
            
            // Menu 6: Japanese Flavour
            ['user_id' => 9, 'menu_id' => 6, 'rating' => 4, 'comment' => 'Unik rasanya, perpaduan yang menarik', 'created_at' => '2025-06-17 14:00:00'],
            ['user_id' => 10, 'menu_id' => 6, 'rating' => 5, 'comment' => 'Suka banget sama rasa Japanese-nya', 'created_at' => '2025-06-19 16:00:00'],
            
            // Menu 7: Latte
            ['user_id' => 8, 'menu_id' => 7, 'rating' => 5, 'comment' => 'Latte art-nya cantik, rasanya juga enak', 'created_at' => '2025-06-16 10:00:00'],
            ['user_id' => 9, 'menu_id' => 7, 'rating' => 5, 'comment' => 'Creamy dan smooth, love it!', 'created_at' => '2025-06-17 11:30:00'],
            ['user_id' => 10, 'menu_id' => 7, 'rating' => 4, 'comment' => 'Enak, tapi agak mahal ya', 'created_at' => '2025-06-18 14:00:00'],
            
            // Menu 8: Sukomon
            ['user_id' => 8, 'menu_id' => 8, 'rating' => 4, 'comment' => 'Unik! Belum pernah coba yang kayak gini', 'created_at' => '2025-06-17 15:00:00'],
            ['user_id' => 10, 'menu_id' => 8, 'rating' => 5, 'comment' => 'Signature menu-nya memang beda!', 'created_at' => '2025-06-19 10:00:00'],
            
            // Menu 9: V60
            ['user_id' => 9, 'menu_id' => 9, 'rating' => 5, 'comment' => 'Manual brew terbaik, rasa kopinya keluar semua', 'created_at' => '2025-06-17 09:00:00'],
            ['user_id' => 8, 'menu_id' => 9, 'rating' => 4, 'comment' => 'Buat pecinta kopi sejati ini mah', 'created_at' => '2025-06-18 10:30:00'],
            
            // Menu 10: Vietnamese Drip
            ['user_id' => 10, 'menu_id' => 10, 'rating' => 5, 'comment' => 'Proses seduhnya aesthetic, rasanya juga top', 'created_at' => '2025-06-17 16:00:00'],
            ['user_id' => 9, 'menu_id' => 10, 'rating' => 4, 'comment' => 'Kental dan manis, cocok buat saya', 'created_at' => '2025-06-19 11:00:00'],
            
            // Menu 11: Matcha
            ['user_id' => 8, 'menu_id' => 11, 'rating' => 5, 'comment' => 'Matcha-nya authentic, tidak terlalu manis', 'created_at' => '2025-06-16 13:00:00'],
            ['user_id' => 9, 'menu_id' => 11, 'rating' => 5, 'comment' => 'Suka banget sama matchanya!', 'created_at' => '2025-06-18 15:00:00'],
            ['user_id' => 10, 'menu_id' => 11, 'rating' => 4, 'comment' => 'Enak dan seger', 'created_at' => '2025-06-19 14:00:00'],
            
            // Menu 12: Red Velvet Latte
            ['user_id' => 8, 'menu_id' => 12, 'rating' => 5, 'comment' => 'Manis dan creamy, pas banget!', 'created_at' => '2025-06-16 14:00:00'],
            ['user_id' => 10, 'menu_id' => 12, 'rating' => 4, 'comment' => 'Cocok buat yang suka manis', 'created_at' => '2025-06-18 16:00:00'],
            
            // Menu 13: Es Teh Manis
            ['user_id' => 9, 'menu_id' => 13, 'rating' => 5, 'comment' => 'Murah meriah dan enak!', 'created_at' => '2025-06-16 12:00:00'],
            ['user_id' => 8, 'menu_id' => 13, 'rating' => 4, 'comment' => 'Es teh yang simple tapi enak', 'created_at' => '2025-06-17 13:00:00'],
            ['user_id' => 10, 'menu_id' => 13, 'rating' => 5, 'comment' => 'Klasik yang gak pernah salah', 'created_at' => '2025-06-19 12:00:00'],
            
            // Menu 14: Wedang
            ['user_id' => 8, 'menu_id' => 14, 'rating' => 4, 'comment' => 'Hangat dan menenangkan', 'created_at' => '2025-06-17 18:00:00'],
            ['user_id' => 9, 'menu_id' => 14, 'rating' => 5, 'comment' => 'Cocok diminum waktu hujan', 'created_at' => '2025-06-18 19:00:00'],
            
            // Menu 15: Chicken Teriyaki
            ['user_id' => 10, 'menu_id' => 15, 'rating' => 5, 'comment' => 'Ayamnya juicy, sausnya mantap!', 'created_at' => '2025-06-16 12:30:00'],
            ['user_id' => 8, 'menu_id' => 15, 'rating' => 4, 'comment' => 'Porsinya pas, rasanya enak', 'created_at' => '2025-06-18 13:00:00'],
            ['user_id' => 9, 'menu_id' => 15, 'rating' => 5, 'comment' => 'Teriyaki terenak di sekitar sini', 'created_at' => '2025-06-19 13:30:00'],
            
            // Menu 16: Cuanki
            ['user_id' => 8, 'menu_id' => 16, 'rating' => 5, 'comment' => 'Rasanya authentic Bandung banget!', 'created_at' => '2025-06-17 12:00:00'],
            ['user_id' => 10, 'menu_id' => 16, 'rating' => 4, 'comment' => 'Enak dan mengenyangkan', 'created_at' => '2025-06-19 12:30:00'],
            
            // Menu 17: Indomie Goreng
            ['user_id' => 9, 'menu_id' => 17, 'rating' => 5, 'comment' => 'Indomie dengan topping lengkap, mantap!', 'created_at' => '2025-06-16 19:00:00'],
            ['user_id' => 8, 'menu_id' => 17, 'rating' => 4, 'comment' => 'Simple tapi enak', 'created_at' => '2025-06-18 20:00:00'],
            ['user_id' => 10, 'menu_id' => 17, 'rating' => 5, 'comment' => 'Favorit! Gak pernah bosen', 'created_at' => '2025-06-19 19:00:00'],
            
            // Menu 18: Indomie Kuah
            ['user_id' => 8, 'menu_id' => 18, 'rating' => 4, 'comment' => 'Kuahnya gurih, cocok buat malam-malam', 'created_at' => '2025-06-17 20:00:00'],
            ['user_id' => 9, 'menu_id' => 18, 'rating' => 5, 'comment' => 'Porsinya banyak, bikin kenyang', 'created_at' => '2025-06-19 20:30:00'],
            
            // Menu 19: Nasi Tutug Oncom
            ['user_id' => 8, 'menu_id' => 19, 'rating' => 5, 'comment' => 'Besttttt!!', 'created_at' => '2025-06-16 03:19:57'],
            ['user_id' => 10, 'menu_id' => 19, 'rating' => 5, 'comment' => 'Menu khas Sunda yang authentic!', 'created_at' => '2025-06-17 13:00:00'],
            ['user_id' => 9, 'menu_id' => 19, 'rating' => 4, 'comment' => 'Pedas dan gurih, mantap!', 'created_at' => '2025-06-18 14:00:00'],
            
            // Menu 20: Bala-bala
            ['user_id' => 8, 'menu_id' => 20, 'rating' => 5, 'comment' => 'Enakkk!!', 'created_at' => '2025-06-16 03:20:16'],
            ['user_id' => 9, 'menu_id' => 20, 'rating' => 4, 'comment' => 'Kriuk-kriuk dan enak', 'created_at' => '2025-06-17 15:30:00'],
            ['user_id' => 10, 'menu_id' => 20, 'rating' => 5, 'comment' => 'Cocok buat cemilan sore', 'created_at' => '2025-06-19 16:30:00'],
            
            // Menu 21: Kentang Sosis
            ['user_id' => 8, 'menu_id' => 21, 'rating' => 4, 'comment' => 'Anak-anak pasti suka ini', 'created_at' => '2025-06-17 16:00:00'],
            ['user_id' => 9, 'menu_id' => 21, 'rating' => 5, 'comment' => 'Porsinya banyak, harganya oke', 'created_at' => '2025-06-18 17:00:00'],
            ['user_id' => 10, 'menu_id' => 21, 'rating' => 4, 'comment' => 'Enak buat ngemil', 'created_at' => '2025-06-19 17:00:00'],
            
            // Menu 22: Risoles
            ['user_id' => 8, 'menu_id' => 22, 'rating' => 5, 'comment' => 'Risolnya enak bangett', 'created_at' => '2025-06-16 03:19:39'],
            ['user_id' => 9, 'menu_id' => 22, 'rating' => 5, 'comment' => 'Isiannya banyak dan lezat', 'created_at' => '2025-06-17 14:30:00'],
            ['user_id' => 10, 'menu_id' => 22, 'rating' => 4, 'comment' => 'Kulit risoles-nya renyah', 'created_at' => '2025-06-18 15:30:00'],
            
            // Menu 23: Roti Bakar
            ['user_id' => 8, 'menu_id' => 23, 'rating' => 5, 'comment' => 'Roti bakarnya crispy dan manis', 'created_at' => '2025-06-16 15:00:00'],
            ['user_id' => 9, 'menu_id' => 23, 'rating' => 4, 'comment' => 'Cocok buat sarapan atau snack', 'created_at' => '2025-06-18 09:00:00'],
            ['user_id' => 10, 'menu_id' => 23, 'rating' => 5, 'comment' => 'Topping-nya banyak pilihan', 'created_at' => '2025-06-19 10:30:00'],
        ];

        DB::table('reviews')->insert($reviews);
    }
}
