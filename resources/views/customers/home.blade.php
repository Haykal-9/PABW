@extends('layouts.app')

@section('title', 'TapalKuda - Inovasi Kopi')

@section('content')

{{-- Versi 3: HERO SECTION - Minimalis dan Berani (Tidak Berubah) --}}
<section class="hero-minimalist min-vh-100 d-flex align-items-center text-dark" id="hero-minimalist">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-3 fw-light mb-2">TapalKuda</h1>
                <h2 class="display-1 fw-bold mb-4 text-primary-dark">Seni Menyeduh</h2>
                <p class="lead mb-4 text-muted">
                    Kami memperlakukan kopi sebagai seni dan sains. Eksplorasi rasa terbaru dari biji lokal yang dikurasi khusus untuk Anda.
                </p>
                <a href="{{ url('/menu') }}" class="btn btn-outline-primary-dark btn-lg px-5 py-3">Pesan Sekarang</a>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-delay="300">
                <img src="{{ asset('assets/img/minimalist_cup.png') }}" class="img-fluid shadow-lg" style="max-height: 500px; object-fit: cover;" alt="Close-up Kopi">
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
                        <img src="{{ asset('assets/img/menu/filter_coffee.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Kopi saring V60 disajikan di gelas bening">
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
                        <img src="{{ asset('assets/img/menu/iced_latte.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Iced Latte dengan lapisan susu dan espresso">
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
                        <img src="{{ asset('assets/img/menu/matcha_cake.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Slice of Matcha Cake dengan garnish">
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
                        <img src="{{ asset('assets/img/menu/avocado_toast.jpg') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Avocado Toast dengan telur dan biji-bijian">
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


{{-- SECTION GALLERY CAROUSEL (Dibuat bergerak otomatis) --}}
<section class="gallery-carousel py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="display-6 fw-bold text-primary-dark">Suasana Kedai Kami</h2>
            <p class="lead text-muted">Tempat yang sempurna untuk bekerja, berkreasi, atau menikmati kopi berkualitas.</p>
        </div>

        {{-- PENAMBAHAN: data-bs-interval="5000" (5 detik) --}}
        <div id="coffeeshopCarousel" class="carousel slide rounded-3 shadow-lg" data-bs-ride="carousel" data-bs-interval="5000" data-aos="zoom-in">
            {{-- Carousel Indicators --}}
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#coffeeshopCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#coffeeshopCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#coffeeshopCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            {{-- Carousel Inner (Images) --}}
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('assets/img/gallery/interior_minimalist.jpg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Interior TapalKuda Coffee, desain minimalis">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-1">
                        <p class="mb-0">Area duduk nyaman untuk bekerja.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/gallery/barista_station.jpg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Barista sedang menyiapkan kopi di mesin espresso">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-1">
                        <p class="mb-0">Stasiun Barista dengan peralatan premium.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/gallery/outdoor_seating.jpg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Area duduk outdoor TapalKuda Coffee">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-1">
                        <p class="mb-0">Area outdoor untuk menikmati sore hari.</p>
                    </div>
                </div>
            </div>

            {{-- Carousel Controls (Next/Previous Buttons) --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#coffeeshopCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#coffeeshopCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
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
                        <p class="mb-0">Jl. Kopi Inovasi No. 18, Bandung 40135</p>
                        <a href="https://maps.app.goo.gl/ContohLinkGoogleMaps" target="_blank" class="text-decoration-none small text-primary-dark">Lihat di Google Maps <i class="fas fa-external-link-alt small"></i></a>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <i class="fas fa-clock fa-2x text-primary-dark me-3 mt-1"></i>
                    <div>
                        <h5 class="fw-bold mb-0">Jam Operasional</h5>
                        <p class="mb-1">Senin - Jumat: 08.00 - 21.00 WIB</p>
                        <p class="mb-0">Sabtu - Minggu: 09.00 - 22.00 WIB</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                {{-- Anda bisa meletakkan kode embed peta (iframe) di sini --}}
                <div class="ratio ratio-16x9 rounded-3 shadow">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6729505876456!2d107.5910543147728!3d-6.91503719500055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsyyNTUnNDkuMSJTIDExNMKwMzcnMDcuOCJF!5e0!3m2!1sid!2sid!4v1633512345678" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-3 border-0" alt="Lokasi TapalKuda Coffee di Google Maps"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection