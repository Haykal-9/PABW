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
            // Kopi - Coffee
            [
                'id' => 1, 
                'nama' => 'Kopi Tubruk Arabika', 
                'url_foto' => 'arabika.jpg', 
                'type_id' => 1, 
                'price' => 14000.00, 
                'deskripsi' => 'Nikmati kenikmatan sejati dari secangkir Kopi Tubruk Arabika yang diseduh dengan cara tradisional. Menggunakan biji kopi arabika pilihan dari dataran tinggi, memberikan aroma khas dan cita rasa yang kuat namun tidak pahit. Setiap tegukan menghadirkan sensasi kopi autentik Indonesia yang sempurna untuk memulai hari atau menemani aktivitas Anda.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:31'
            ],
            [
                'id' => 2, 
                'nama' => 'Cappucino', 
                'url_foto' => 'cappucino.jpg', 
                'type_id' => 1, 
                'price' => 22000.00, 
                'deskripsi' => 'Butuh pelukan hangat dalam bentuk kopi? Coba Cappuccino kami yang memadukan espresso berkualitas tinggi dengan steamed milk dan foam susu yang lembut sempurna. Kombinasi 1/3 espresso, 1/3 steamed milk, dan 1/3 foam menciptakan harmoni rasa yang seimbang. Dilengkapi dengan taburan cokelat bubuk di atasnya, cappuccino kami siap memanjakan lidah Anda.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:35'
            ],
            [
                'id' => 3, 
                'nama' => 'ES Kopi Susu', 
                'url_foto' => 'kosu.jpg', 
                'type_id' => 1, 
                'price' => 22000.00, 
                'deskripsi' => 'Minuman favorit semua kalangan! Es Kopi Susu kami menghadirkan perpaduan sempurna antara kopi pilihan dengan susu segar yang creamy. Disajikan dingin dengan es batu, minuman ini memberikan kesegaran maksimal sambil tetap mempertahankan kekuatan rasa kopi yang nikmat. Tidak terlalu manis, pas di lidah, dan cocok dinikmati kapan saja sepanjang hari.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:41'
            ],
            [
                'id' => 4, 
                'nama' => 'Espresso', 
                'url_foto' => 'espresso.jpg', 
                'type_id' => 1, 
                'price' => 14000.00, 
                'deskripsi' => 'Espresso kami dibuat dari biji arabika pilihan yang di-roasting dengan sempurna, menghasilkan shot espresso yang kaya akan aroma dan memiliki crema yang tebal. Diekstrak dengan tekanan tinggi dalam waktu 25-30 detik, menghasilkan 30ml konsentrat kopi murni yang kuat, bold, dan penuh karakter. Sempurna untuk penikmat kopi sejati yang menghargai kualitas dalam setiap tetes.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:44'
            ],
            [
                'id' => 5, 
                'nama' => 'Espresso Double', 
                'url_foto' => 'espresso1.jpg', 
                'type_id' => 1, 
                'price' => 17000.00, 
                'deskripsi' => 'Siap hadapi hari yang panjang? Espresso Double kami memberikan dosis kafein ganda dengan dua shot espresso premium dalam satu sajian. Intensitas rasa yang lebih kuat, aroma yang lebih pekat, dan energi berlipat untuk menemani produktivitas Anda. Cocok untuk mereka yang membutuhkan boost ekstra atau pecinta kopi hardcore yang menginginkan pengalaman espresso yang lebih maksimal.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:47'
            ],
            [
                'id' => 6, 
                'nama' => 'Japanase Flavour', 
                'url_foto' => 'JAPAN.jpg', 
                'type_id' => 1, 
                'price' => 21000.00, 
                'deskripsi' => 'Rasakan kelembutan dan keunikan rasa Jepang dalam secangkir kopi! Japanese Flavour kami menggabungkan espresso premium dengan sentuhan cream khas Jepang yang lembut dan sedikit manis. Terinspirasi dari café culture Jepang, minuman ini menawarkan tekstur yang creamy, rasa yang halus namun tetap mempertahankan karakter kopi yang elegan. Pengalaman kopi yang berbeda dan sophisticated.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:50'
            ],
            [
                'id' => 7, 
                'nama' => 'Latte', 
                'url_foto' => 'Latte.jpg', 
                'type_id' => 1, 
                'price' => 25000.00, 
                'deskripsi' => 'Butuh momen tenang di tengah hari yang sibuk? Latte kami adalah pilihan sempurna dengan perpaduan shot espresso yang kaya dan steamed milk yang lembut dalam porsi yang generous. Rasio 1:3 antara espresso dan susu menghasilkan minuman yang creamy, smooth, dan tidak terlalu kuat. Dilengkapi dengan latte art yang cantik di setiap sajian, membuat pengalaman minum kopi Anda lebih istimewa.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:52'
            ],
            [
                'id' => 8, 
                'nama' => 'Sukomon', 
                'url_foto' => 'SUKOMON.jpg', 
                'type_id' => 1, 
                'price' => 21000.00, 
                'deskripsi' => 'Perpaduan yang tidak biasa, tapi luar biasa! Sukomon adalah signature drink kami yang menggabungkan kopi dengan susu, cokelat, dan sentuhan karamel yang menciptakan harmoni rasa manis, creamy, dan sedikit bitter dalam satu gelas. Teksturnya yang kaya dan layer rasa yang kompleks membuat setiap tegukan memberikan sensasi berbeda. Menu favorit pelanggan yang wajib Anda coba!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:55'
            ],
            [
                'id' => 9, 
                'nama' => 'V60', 
                'url_foto' => 'V60.jpg', 
                'type_id' => 1, 
                'price' => 19000.00, 
                'deskripsi' => 'Nikmati kelezatan kopi dengan cara yang lebih personal melalui metode pour over V60. Proses penyeduhan manual yang teliti menghasilkan secangkir kopi yang jernih, clean, dan memunculkan kompleksitas cita rasa dari setiap bean. Anda dapat merasakan notes buah, floral, dan karakteristik unik dari single origin coffee kami. Untuk penikmat kopi yang menghargai craftsmanship dan kualitas brewing.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:03:58'
            ],
            [
                'id' => 10, 
                'nama' => 'Vietname Drip', 
                'url_foto' => 'VIETNAME.jpg', 
                'type_id' => 1, 
                'price' => 19000.00, 
                'deskripsi' => 'Rasakan kenikmatan kopi ala Vietnam dengan Vietnamese Drip kami yang diseduh menggunakan phin filter tradisional. Kopi robusta yang kuat dan pekat diteteskan perlahan di atas susu kental manis, menciptakan perpaduan yang kaya, manis, dan smooth. Proses seduh yang unik ini bukan hanya menghasilkan kopi yang nikmat, tapi juga pengalaman visual yang menarik. Tekstur kental dan rasa manis yang seimbang menjadikan minuman ini favorit banyak orang.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:04:02'
            ],
            
            // Non Kopi - Non Coffee
            [
                'id' => 11, 
                'nama' => 'Matcha', 
                'url_foto' => 'maca.jpg', 
                'type_id' => 2, 
                'price' => 17000.00, 
                'deskripsi' => 'Rasakan kekayaan rasa dari Matcha premium kami yang dibuat dari bubuk teh hijau Jepang berkualitas tinggi. Disajikan dengan susu atau sebagai minuman murni, matcha kami menawarkan rasa umami yang unik, sedikit pahit namun menyegarkan, dengan manfaat antioksidan yang tinggi. Tekstur yang creamy dan warna hijau yang cantik membuat minuman ini tidak hanya enak, tapi juga Instagram-worthy!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-05-20 19:23:39'
            ],
            [
                'id' => 12, 
                'nama' => 'Red Velvet Latte', 
                'url_foto' => 'red.jpg', 
                'type_id' => 2, 
                'price' => 17000.00, 
                'deskripsi' => 'Nikmati kelezatan Red Velvet Latte kami yang memadukan rasa cokelat putih yang creamy dengan sentuhan red velvet yang khas. Minuman ini menawarkan rasa manis yang pas, tekstur yang lembut seperti beludru, dan tampilan merah yang menggoda. Dilengkapi dengan whipped cream di atasnya, Red Velvet Latte adalah pilihan sempurna untuk Anda yang ingin menikmati dessert dalam bentuk minuman.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-05-20 19:23:43'
            ],
            [
                'id' => 13, 
                'nama' => 'Es Teh Manis', 
                'url_foto' => 'TehManis.jpg', 
                'type_id' => 2, 
                'price' => 8000.00, 
                'deskripsi' => 'Nikmati kesegaran Es Teh Manis kami yang sempurna untuk menghilangkan dahaga. Diseduh dari daun teh pilihan dengan tingkat kemanisan yang pas, tidak terlalu manis dan tidak hambar. Disajikan dengan es batu yang melimpah, minuman klasik ini adalah pendamping makanan terbaik dan cocok dinikmati kapan saja. Harga terjangkau, rasa yang konsisten, dan selalu menyegarkan!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-05-21 23:47:56'
            ],
            [
                'id' => 14, 
                'nama' => 'Wedang', 
                'url_foto' => 'wedang.jpg', 
                'type_id' => 2, 
                'price' => 8000.00, 
                'deskripsi' => 'Nikmati kehangatan Wedang kami, minuman tradisional Indonesia yang kaya akan rempah-rempah seperti jahe, serai, dan gula merah. Rasanya yang hangat, sedikit pedas dari jahe, dan manis alami dari gula merah memberikan sensasi menghangatkan tubuh, terutama di cuaca dingin atau saat badan kurang fit. Wedang kami bukan hanya enak, tapi juga memberikan manfaat kesehatan dari rempah-rempah alami.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-05-20 19:23:50'
            ],
            
            // Makanan Berat - Heavy Meals
            [
                'id' => 15, 
                'nama' => 'Chicken Teriyaki', 
                'url_foto' => 'AyamTeriyaki.jpg', 
                'type_id' => 3, 
                'price' => 20000.00, 
                'deskripsi' => 'Nikmati kelezatan Chicken Teriyaki kami dengan potongan daging ayam yang juicy dan empuk, dimasak dengan saus teriyaki special yang manis gurih. Disajikan dengan nasi hangat, sayuran segar, dan taburan wijen, hidangan ini memberikan cita rasa Jepang yang autentik. Porsi yang mengenyangkan dengan protein tinggi, cocok untuk makan siang atau malam Anda yang menginginkan menu sehat dan lezat.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:04:55'
            ],
            [
                'id' => 16, 
                'nama' => 'Cuanki', 
                'url_foto' => 'cuanki.png', 
                'type_id' => 3, 
                'price' => 15000.00, 
                'deskripsi' => 'Rasakan kenikmatan Cuanki kami, hidangan khas Bandung yang berisi bakso urat, batagor, siomay, dan tahu isi dalam kuah kaldu yang gurih dan segar. Dilengkapi dengan mie kuning, taburan seledri, bawang goreng, dan sambal untuk yang suka pedas. Setiap sendok menghadirkan kombinasi tekstur yang berbeda - kenyal, renyah, dan lembut. Porsinya yang melimpah membuat hidangan ini sangat mengenyangkan dan worth it!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:04:58'
            ],
            [
                'id' => 17, 
                'nama' => 'indomie goreng', 
                'url_foto' => 'indomieGoreng.jpg', 
                'type_id' => 3, 
                'price' => 15000.00, 
                'deskripsi' => 'Indomie Goreng kami adalah pilihan sempurna untuk comfort food yang memuaskan! Dimasak dengan bumbu khas Indomie yang sudah tidak asing lagi, ditambah dengan topping telur mata sapi/ceplok, sayuran segar, dan taburan bawang goreng. Mie yang kenyal dengan bumbu yang meresap sempurna, memberikan cita rasa gurih yang familiar dan selalu bikin nagih. Menu favorit yang simple namun selalu memuaskan!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:05:01'
            ],
            [
                'id' => 18, 
                'nama' => 'indomie kuah', 
                'url_foto' => 'indomieKuah.jpeg', 
                'type_id' => 3, 
                'price' => 15000.00, 
                'deskripsi' => 'Nikmati kehangatan Indomie Kuah kami yang disajikan dalam kuah kaldu yang gurih dan menyegarkan. Mie yang dimasak pas dengan kuah yang melimpah, dilengkapi dengan topping telur, sayuran, dan bawang goreng. Cocok dinikmati saat cuaca dingin atau ketika Anda menginginkan makanan yang hangat dan berkuah. Porsinya yang pas membuat hidangan ini menjadi pilihan tepat untuk mengisi perut dengan budget friendly.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:05:03'
            ],
            [
                'id' => 19, 
                'nama' => 'Nasi Tutug Onceom', 
                'url_foto' => 'nasiTutug.webp', 
                'type_id' => 3, 
                'price' => 27000.00, 
                'deskripsi' => 'Nikmati kelezatan Nasi Tutug Oncom kami, hidangan khas Sunda yang unik dan penuh cita rasa! Nasi yang ditutug (ditumbuk) bersama oncom segar, menghasilkan tekstur yang unik dan rasa gurih khas oncom yang autentik. Disajikan dengan lauk pauk seperti ayam goreng/bakar, tempe, tahu, lalapan segar, dan sambal yang pedas mantap. Menu ini memberikan pengalaman kuliner tradisional Sunda yang lengkap dan memuaskan.', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:05:06'
            ],
            
            // Snack - Snacks
            [
                'id' => 20, 
                'nama' => 'Bala-bala', 
                'url_foto' => 'balabala.jpg', 
                'type_id' => 4, 
                'price' => 13000.00, 
                'deskripsi' => 'Nikmati kelezatan Bala-Bala kami, gorengan khas Sunda yang crispy di luar dan lembut di dalam! Dibuat dari adonan tepung yang dicampur dengan sayuran segar seperti kol dan wortel, digoreng hingga golden brown dan renyah sempurna. Disajikan hangat dengan cabai rawit dan kecap manis, bala-bala kami adalah cemilan yang cocok ditemani kopi atau teh. Porsinya generous dan selalu fresh from the kitchen!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:04:14'
            ],
            [
                'id' => 21, 
                'nama' => 'Kentang Sosis', 
                'url_foto' => 'kentangSosis.jpg', 
                'type_id' => 4, 
                'price' => 16000.00, 
                'deskripsi' => 'Nikmati kelezatan Kentang Sosis kami yang menghadirkan perpaduan kentang goreng crispy dengan sosis berkualitas yang juicy. Disajikan dengan saus sambal dan mayonnaise special, hidangan ini memberikan kombinasi rasa gurih, pedas, dan creamy yang addictive. Porsinya yang generous dengan potongan sosis yang banyak membuat snack ini cocok untuk sharing atau dinikmati sendiri. Perfect untuk menemani waktu santai Anda!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:04:17'
            ],
            [
                'id' => 22, 
                'nama' => 'Risoles', 
                'url_foto' => 'risol.jpg', 
                'type_id' => 4, 
                'price' => 18000.00, 
                'deskripsi' => 'Nikmati Risoles kami yang lembut di luar dan penuh isian di dalam! Kulit crepes tipis yang dibalut dengan tepung panir roti, digoreng hingga crispy golden. Isiannya yang melimpah terdiri dari ragout ayam/daging yang creamy, sayuran, wortel, dan buncis. Setiap gigitan menghadirkan tekstur renyah dari luar dan kelembutan isian yang gurih dari dalam. Disajikan hangat, risoles kami perfect untuk snack time Anda!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:04:19'
            ],
            [
                'id' => 23, 
                'nama' => 'Roti Bakar', 
                'url_foto' => 'Roti.jpg', 
                'type_id' => 4, 
                'price' => 16000.00, 
                'deskripsi' => 'Nikmati kelezatan Roti Bakar kami yang dipanggang hingga crispy dengan mentega yang melimpah. Tersedia berbagai pilihan topping seperti cokelat, keju, selai kacang, atau kombinasi sesuai selera Anda. Roti yang masih hangat dengan topping yang meleleh memberikan sensasi yang memanjakan lidah. Cocok untuk sarapan, snack sore, atau kapan saja Anda menginginkan comfort food yang manis dan mengenyangkan. Porsinya yang pas dengan harga yang terjangkau!', 
                'status_id' => 1, 
                'created_at' => '2025-05-05 21:52:58', 
                'updated_at' => '2025-06-15 18:04:22'
            ],
        ]);
    }
}
