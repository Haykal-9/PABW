@extends('customers.layouts.app')

@section('title', 'Inovasi Kopi')

@section('content')

{{-- Versi 3: HERO SECTION - Minimalis dan Berani (Dimodifikasi dengan Background Gambar) --}}
<section class="hero-minimalist d-flex align-items-center text-white" id="hero-minimalist"
         style="background-image: url('{{ asset('logo/biji.jpg') }}'); background-size: cover; background-position: center;">
    {{-- Overlay hangat agar teks tetap terbaca --}}
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>
    
    {{-- Tambahkan div overlay di sini jika gambar background Anda terlalu terang. --}}
    {{-- <div class="bg-dark position-absolute top-0 start-0 w-100 h-100 opacity-50" style="z-index: 2;"></div> --}}
    
    <div class="container" style="z-index: 3;"> 
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-3 fw-light mb-2">TapalKuda</h1>
                
                {{-- WARNA TEKS diubah menjadi WHITE agar kontras dengan background gelap --}}
                <h2 class="display-1 fw-bold mb-4 text-white">Seni Menyeduh</h2> 
                <p class="lead mb-4">
                    Kami memperlakukan kopi sebagai seni dan sains. Eksplorasi rasa terbaru dari biji lokal yang dikurasi khusus untuk Anda.
                </p>
                
                {{-- Tombol diubah agar sesuai tema Cozy Rustic --}}
                <a href="{{ url('/menu') }}" class="btn btn-primary-dark btn-lg px-5 py-3 shadow-lg">Pesan Sekarang</a> 
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-delay="300">
                </div>
        </div>
    </div>
</section>


{{-- PENAMBAHAN BARU: SECTION MENU FOTO (Featured Products) --}}
<section class="menu-featured py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="display-6 fw-bold text-primary-dark">Pilihan Favorit Kami</h2>
            <p class="lead text-muted">Lihat empat menu andalan yang wajib Anda coba saat berkunjung.</p>
        </div>

        <div class="row g-4">
            {{-- Item Menu 1: Single Origin Filter --}}
            <div class="col-md-6 col-lg-3" data-aos="zoom-in">
                <a href="{{ url('/menu/single-origin') }}" class="card-link text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('foto/CAPPUCINO.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Kopi saring V60 disajikan di gelas bening">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Filter Coffee (V60)</h5>
                            <p class="card-text text-muted small">Seasonal Single Origin</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Item Menu 2: Signature Espresso Based --}}
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                <a href="{{ url('/menu/signature') }}" class="card-link text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('foto/KOPITUBRUKROBUSTA.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Iced Latte dengan lapisan susu dan espresso">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Iced TapalKuda Latte</h5>
                            <p class="card-text text-muted small">Signature Blend & Creamy</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Item Menu 3: Pastry/Sweet Treat --}}
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                <a href="{{ url('/menu/pastry') }}" class="card-link text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('foto/Latte.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Slice of Matcha Cake dengan garnish">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Matcha Opera Cake</h5>
                            <p class="card-text text-muted small">Pairing terbaik dengan Dark Roast</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Item Menu 4: Light Bites/Sandwich --}}
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                <a href="{{ url('/menu#lightbites') }}" class="card-link text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('foto/kosu.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Avocado Toast dengan telur dan biji-bijian">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Smashed Avocado Toast</h5>
                            <p class="card-text text-muted small">Pilihan sarapan dan brunch</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ url('/menu') }}" class="btn btn-outline-primary-dark btn-lg px-5 py-3">Lihat Semua Menu</a>
        </div>
    </div>
</section>

{{-- Versi 3: SECTION 2 - Kategori dengan Ikon Vertikal (Tidak Berubah) --}}
<section class="category-minimalist py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="display-6 fw-bold text-primary-dark">Pilar Utama Rasa Kami</h2>
        </div>

        <div class="row g-5">
            <div class="col-md-4 text-center" data-aos="zoom-in-up">
                <i class="fas fa-flask fa-3x text-primary-dark mb-3"></i>
                <h4 class="fw-bold">Brewing Methods</h4>
                <p class="text-muted">Eksperimen dengan V60, Chemex, dan Syphon untuk rasa yang berbeda.</p>
            </div>
            <div class="col-md-4 text-center" data-aos="zoom-in-up" data-aos-delay="150">
                <i class="fas fa-leaf fa-3x text-primary-dark mb-3"></i>
                <h4 class="fw-bold">Single Origin</h4>
                <p class="text-muted">Temukan karakter unik dari biji kopi di setiap daerah. Tersedia Edisi Terbatas.</p>
            </div>
            <div class="col-md-4 text-center" data-aos="zoom-in-up" data-aos-delay="300">
                <i class="fas fa-cookie-bite fa-3x text-primary-dark mb-3"></i>
                <h4 class="fw-bold">Food Pairing</h4>
                <p class="text-muted">Camilan dan makanan ringan yang dibuat khusus untuk melengkapi kopi Anda.</p>
            </div>
        </div>
    </div>
</section>

{{-- REKOMENDASI PENAMBAHAN: SECTION 4 - Testimoni Ringkas --}}
<section class="testimonial-minimalist py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="display-6 fw-bold text-primary-dark">Apa Kata Mereka?</h2>
        </div>

        <div class="row g-4">
            {{-- Testimoni 1 --}}
            <div class="col-md-6 col-lg-4" data-aos="flip-up">
                <div class="p-4 border rounded-3 h-100">
                    <i class="fas fa-quote-left text-muted mb-3"></i>
                    <p class="fst-italic">"Rasa kopi yang berani, tapi tetap lembut. Pilihan Single Origin-nya selalu mengejutkan dengan kualitas yang premium. Favorit saya!"</p>
                    <p class="fw-bold mt-3 mb-0">Rina S.</p>
                    <small class="text-muted">Desainer Grafis</small>
                </div>
            </div>
            {{-- Testimoni 2 --}}
            <div class="col-md-6 col-lg-4" data-aos="flip-up" data-aos-delay="150">
                <div class="p-4 border rounded-3 h-100">
                    <i class="fas fa-quote-left text-muted mb-3"></i>
                    <p class="fst-italic">"Tempat yang sempurna untuk bekerja. Kopi dan sandwich-nya ringan, tidak mengganggu fokus. Pelayanannya sangat ramah."</p>
                    <p class="fw-bold mt-3 mb-0">Andi K.</p>
                    <small class="text-muted">Entrepreneur Digital</small>
                </div>
            </div>
            {{-- Testimoni 3 (Optional) --}}
            <div class="col-md-6 col-lg-4 mx-auto d-none d-lg-block" data-aos="flip-up" data-aos-delay="300">
                <div class="p-4 border rounded-3 h-100">
                    <i class="fas fa-quote-left text-muted mb-3"></i>
                    <p class="fst-italic">"Konsepnya minimalis dan nyaman. Mereka benar-benar ahli dalam menyajikan setiap detail biji kopi. Benar-benar seni menyeduh."</p>
                    <p class="fw-bold mt-3 mb-0">Santi W.</p>
                    <small class="text-muted">Food Blogger</small>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION GALERI FOTO GRID (10 Foto dalam 5 + 5) --}}
<section class="gallery-grid py-5 bg-light">
    <div class="container"> 
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="display-6 fw-bold text-primary-dark">Jelajahi Suasana Kedai Kami</h2>
            <p class="lead text-muted">Tempat yang sempurna untuk bekerja, berkreasi, atau menikmati kopi berkualitas.</p>
        </div>

        <div class="row g-3 justify-content-center mb-3"> 
            
            @for ($i = 1; $i <= 5; $i++)
            <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}">
                {{-- Tambahkan gallery-item-btn untuk targeting JS --}}
                <a href="{{ url('/gallery') }}" class="d-block card rounded-3 overflow-hidden bg-transparent border-0 gallery-item-btn">
                    <div class="ratio ratio-1x1 bg-white">
                        <img src="{{ asset('foto/seblak.jpg') }}" 
                             class="img-fluid w-100 h-100 shadow-sm" 
                             style="object-fit: cover;" 
                             alt="Foto Galeri {{ $i }}">
                    </div>
                </a>
            </div>
            @endfor
            
        </div>
        
        <div class="row g-3 justify-content-center"> 
            
            @for ($i = 6; $i <= 10; $i++)
            <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="{{ ($i-5) * 100 }}">
                <a href="{{ url('/gallery') }}" class="d-block card rounded-3 overflow-hidden bg-transparent border-0 gallery-item-btn">
                    <div class="ratio ratio-1x1 bg-white">
                        <img src="{{ asset('foto/seblak.jpg') }}" 
                             class="img-fluid w-100 h-100 shadow-sm" 
                             style="object-fit: cover;" 
                             alt="Foto Galeri {{ $i }}">
                    </div>
                </a>
            </div>
            @endfor
            
        </div>
</section>


{{-- PENAMBAHAN BARU: SECTION LOKASI & JAM OPERASIONAL --}}
<section class="location-info py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <h3 class="fw-bold mb-3 text-primary-dark">Kunjungi Outlet Kami</h3>
                <p class="lead text-muted">Kami menunggu Anda di pusat inovasi kopi kami.</p>

                <div class="d-flex align-items-start mb-3">
                    <i class="fas fa-map-marker-alt fa-2x text-primary-dark me-3 mt-1"></i>
                    <div>
                        <h5 class="fw-bold mb-0">Lokasi Utama</h5>
                        {{-- Ganti dengan alamat aktual Anda --}}
                        <p class="mb-0">Margalaksana sumedang</p>
                        <a href="https://maps.app.goo.gl/ContohLinkGoogleMaps" target="_blank" class="text-decoration-none small text-primary-dark">Lihat di Google Maps <i class="fas fa-external-link-alt small"></i></a>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <i class="fas fa-clock fa-2x text-primary-dark me-3 mt-1"></i>
                    <div>
                        <h5 class="fw-bold mb-0">Jam Operasional</h5>
                        <p class="mb-1">Selasa - Minggu: 10.00 - 21.00 WIB</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                {{-- Anda bisa meletakkan kode embed peta (iframe) di sini --}}
                <div class="ratio ratio-16x9 rounded-3 shadow">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1687459860623!2d107.88790757573882!3d-6.87037396722298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68d1b8e9ca8793%3A0x786b963c3e8cf075!2sKedai%20Kopi%20Tapal%20Kuda%20Sumedang!5e0!3m2!1sid!2sid!4v1760723900800!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection