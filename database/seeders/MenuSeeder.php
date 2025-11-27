<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu')->insert([
            ['id' => 1, 'nama' => 'Kopi Tubruk Arabika', 'url_foto' => 'arabika.jpg', 'type_id' => 1, 'price' => 14000.00, 'deskripsi' => 'Nikmati kenikmatan sejati dari secangkir Kopi Tubruk Arabika...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:31'],
            ['id' => 2, 'nama' => 'Cappucino', 'url_foto' => 'cappucino.jpg', 'type_id' => 1, 'price' => 22000.00, 'deskripsi' => 'Butuh pelukan hangat dalam bentuk kopi? Coba Cappuccino kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:35'],
            ['id' => 3, 'nama' => 'ES Kopi Susu', 'url_foto' => 'kosu.jpg', 'type_id' => 1, 'price' => 22000.00, 'deskripsi' => 'Minuman favorit semua kalangan! Es Kopi Susu kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:41'],
            ['id' => 4, 'nama' => 'Espresso', 'url_foto' => 'espresso.jpg', 'type_id' => 1, 'price' => 14000.00, 'deskripsi' => 'Espresso kami dibuat dari biji arabika pilihan...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:44'],
            ['id' => 5, 'nama' => 'Espresso Double', 'url_foto' => 'espresso1.jpg', 'type_id' => 1, 'price' => 17000.00, 'deskripsi' => 'Siap hadapi hari yang panjang? Espresso Double kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:47'],
            ['id' => 6, 'nama' => 'Japanase Flavour', 'url_foto' => 'JAPAN.jpg', 'type_id' => 1, 'price' => 21000.00, 'deskripsi' => 'Rasakan kelembutan dan keunikan rasa Jepang...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:50'],
            ['id' => 7, 'nama' => 'Latte', 'url_foto' => 'Latte.jpg', 'type_id' => 1, 'price' => 25000.00, 'deskripsi' => 'Butuh momen tenang di tengah hari yang sibuk? Latte kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:52'],
            ['id' => 8, 'nama' => 'Sukomon', 'url_foto' => 'SUKOMON.jpg', 'type_id' => 1, 'price' => 21000.00, 'deskripsi' => 'Perpaduan yang tidak biasa, tapi luar biasa! Sukomon...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:55'],
            ['id' => 9, 'nama' => 'V60', 'url_foto' => 'V60.jpg', 'type_id' => 1, 'price' => 19000.00, 'deskripsi' => 'Nikmati kelezatan kopi dengan cara yang lebih personal...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:03:58'],
            ['id' => 10, 'nama' => 'Vietname Drip', 'url_foto' => 'VIETNAME.jpg', 'type_id' => 1, 'price' => 19000.00, 'deskripsi' => 'Rasakan kenikmatan kopi ala Vietnam dengan Vietnamese Drip kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:04:02'],
            ['id' => 11, 'nama' => 'Matcha', 'url_foto' => 'maca.jpg', 'type_id' => 2, 'price' => 17000.00, 'deskripsi' => 'Rasakan kekayaan rasa dari Matcha kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-05-20 19:23:39'],
            ['id' => 12, 'nama' => 'Red Velvet Latte', 'url_foto' => 'red.jpg', 'type_id' => 2, 'price' => 17000.00, 'deskripsi' => 'Nikmati kelezatan Red Velvet Latte kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-05-20 19:23:43'],
            ['id' => 13, 'nama' => 'Es Teh Manis', 'url_foto' => 'TehManis.jpg', 'type_id' => 2, 'price' => 8000.00, 'deskripsi' => 'Nikmati kesegaran Es Teh Manis kami yang sempurna...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-05-21 23:47:56'],
            ['id' => 14, 'nama' => 'Wedang', 'url_foto' => 'wedang.jpg', 'type_id' => 2, 'price' => 8000.00, 'deskripsi' => 'Nikmati kehangatan Wedang kami minuman tradisional...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-05-20 19:23:50'],
            ['id' => 15, 'nama' => 'Chicken Teriyaki', 'url_foto' => 'AyamTeriyaki.jpg', 'type_id' => 3, 'price' => 20000.00, 'deskripsi' => 'Nikmati kelezatan Chicken Teriyaki kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:04:55'],
            ['id' => 16, 'nama' => 'Cuanki', 'url_foto' => 'cuanki.png', 'type_id' => 3, 'price' => 15000.00, 'deskripsi' => 'Rasakan kenikmatan Cuanki kami, hidangan khas Bandung...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:04:58'],
            ['id' => 17, 'nama' => 'indomie goreng', 'url_foto' => 'indomieGoreng.jpg', 'type_id' => 3, 'price' => 15000.00, 'deskripsi' => 'Indomie Goreng kami adalah pilihan sempurna...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:05:01'],
            ['id' => 18, 'nama' => 'indomie kuah', 'url_foto' => 'indomieKuah.jpeg', 'type_id' => 3, 'price' => 15000.00, 'deskripsi' => 'Nikmati kehangatan Indomie Kuah kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:05:03'],
            ['id' => 19, 'nama' => 'Nasi Tutug Onceom', 'url_foto' => 'nasiTutug.webp', 'type_id' => 3, 'price' => 27000.00, 'deskripsi' => 'Nikmati kelezatan Nasi Tutug Oncom kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:05:06'],
            ['id' => 20, 'nama' => 'Bala-bala', 'url_foto' => 'balabala.jpg', 'type_id' => 4, 'price' => 13000.00, 'deskripsi' => 'Nikmati kelezatan Bala-Bala kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:04:14'],
            ['id' => 21, 'nama' => 'Kentang Sosis', 'url_foto' => 'kentangSosis.jpg', 'type_id' => 4, 'price' => 16000.00, 'deskripsi' => 'Nikmati kelezatan Kentang Sosis kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:04:17'],
            ['id' => 22, 'nama' => 'Risoles', 'url_foto' => 'risol.jpg', 'type_id' => 4, 'price' => 18000.00, 'deskripsi' => 'Nikmati Risoles kami yang lembut di luar...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:04:19'],
            ['id' => 23, 'nama' => 'Roti Bakar', 'url_foto' => 'Roti.jpg', 'type_id' => 4, 'price' => 16000.00, 'deskripsi' => 'Nikmati kelezatan Roti Bakar kami...', 'status_id' => 1, 'created_at' => '2025-05-05 21:52:58', 'updated_at' => '2025-06-15 18:04:22'],
        ]);
    }
}
