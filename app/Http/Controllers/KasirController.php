<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $menu = [
            ['id'=>1,'nama'=>'Espresso','harga'=>15000,'img'=>'https://placehold.co/250x160?text=Espresso'],
            ['id'=>2,'nama'=>'Cappuccino','harga'=>22000,'img'=>'https://placehold.co/250x160?text=Cappuccino'],
            ['id'=>3,'nama'=>'Latte','harga'=>24000,'img'=>'https://placehold.co/250x160?text=Latte'],
            ['id'=>4,'nama'=>'Americano','harga'=>18000,'img'=>'https://placehold.co/250x160?text=Americano'],
        ];

        $order_items = [
            ['nama'=>'Latte','qty'=>1,'harga'=>24000],
            ['nama'=>'Espresso','qty'=>2,'harga'=>15000],
        ];

        $pajak  = 0.10;
        $diskon = 0;

        
        $subtotal  = array_reduce($order_items, fn($c, $i) => $c + ($i['qty'] * $i['harga']), 0);
        $pajak_val = $subtotal * $pajak;
        $total     = $subtotal + $pajak_val - $diskon;

        return view('kasir.kasir', [
            'title'       => 'Tapal Kuda | Kasir',
            'activePage'  => 'kasir',
            'menu'       => $menu,
            'order_items' => $order_items,
            'pajak'       => $pajak,
            'diskon'      => $diskon,
            'subtotal'    => $subtotal,
            'pajak_val'   => $pajak_val,
            'total'       => $total,
        ]);
    }

    public function reservasi()
    {
        $reservasi = [
            ['kode'=>'RSV-001','nama'=>'Aqila','email'=>'aqila@example.com','no_telp'=>'0812-1111-2222','jumlah_orang'=>2,'tanggal'=>'2025-10-21','pesan'=>'Non-smoking, dekat jendela'],
            ['kode'=>'RSV-002','nama'=>'Haykal','email'=>'haykal@example.com','no_telp'=>'0813-3333-4444','jumlah_orang'=>4,'tanggal'=>'2025-10-22','pesan'=>'Butuh stop kontak'],
            ['kode'=>'RSV-003','nama'=>'Ega','email'=>'ega@example.com','no_telp'=>'0815-5555-6666','jumlah_orang'=>3,'tanggal'=>'2025-10-23','pesan'=>'Kursi sofa'],
        ];

        return view('kasir.reservasi', [
            'title'      => 'Tapal Kuda | Reservasi',
            'activePage' => 'reservasi',
            'reservasi'  => $reservasi,
        ]);
    }

    public function notif()
    {
        $notifikasi = [
            ['judul'=>'Pesanan #INV-1023 selesai','waktu'=>'Baru saja','isi'=>'Pesanan meja 5 sudah dibayar.'],
            ['judul'=>'Stok hampir habis','waktu'=>'10 menit lalu','isi'=>'Kopi robusta tinggal 2 pack.'],
            ['judul'=>'Reservasi baru','waktu'=>'1 jam lalu','isi'=>'RSV-003 untuk 3 orang pada 23 Okt.'],
        ];

        return view('kasir.notif', [
            'title'      => 'Tapal Kuda | Notifikasi',
            'activePage' => 'notifikasi',
            'notifikasi' => $notifikasi,
        ]);
    }

    public function profile()
    {
        $user = [
            'nama'    => 'Kasir Tapal Kuda',
            'email'   => 'kasir@tapalkuda.com',
            'telepon' => '0812-3456-7890',
            'foto'    => 'https://placehold.co/140x140?text=Kasir',
        ];

        return view('kasir.profile', [
            'title'      => 'Tapal Kuda | Profile',
            'activePage' => 'profile',
            'user'       => $user,
        ]);
    }

    public function riwayat()
    {
        $riwayat = [
            ['kode'=>'INV-1023','tanggal'=>'2025-10-19','pelanggan'=>'Diki','total'=>54000,'status'=>'Selesai'],
            ['kode'=>'INV-1022','tanggal'=>'2025-10-19','pelanggan'=>'Zahara','total'=>37000,'status'=>'Selesai'],
            ['kode'=>'INV-1021','tanggal'=>'2025-10-18','pelanggan'=>'Aqila','total'=>18000,'status'=>'Batal'],
        ];

        return view('kasir.riwayat', [
            'title'      => 'Tapal Kuda | Riwayat Pesanan',
            'activePage' => 'history',
            'riwayat'    => $riwayat,
        ]);
    }

    public function struk(Request $request)
    {
        $struk = [
            'kode'      => 'INV-1023',
            'tanggal'   => date('Y-m-d H:i'),
            'kasir'     => 'Kasir Tapal Kuda',
            'pelanggan' => 'Diki',
            'items'     => [
                ['nama'=>'Latte','qty'=>1,'harga'=>24000],
                ['nama'=>'Espresso','qty'=>2,'harga'=>15000],
            ],
            'pajak'  => 0.10,
            'diskon' => 0,
        ];

        return view('kasir.struk', [
            'title'      => 'Tapal Kuda | Struk Pembayaran',
            'activePage' => 'history',
            'struk'      => $struk,
        ]);
    }
}
