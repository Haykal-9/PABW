@extends('customers.layouts.app')

@section('title', 'Inovasi Kopi')

@section('content')

    {{-- HERO SECTION - Glass Luxury --}}
    <section class="hero-glass d-flex align-items-center text-white vh-100 position-relative overflow-hidden"
        id="hero-section"
        style="background-image: url('{{ asset('logo/biji.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">

        {{-- Glass Overlay --}}
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.7); backdrop-filter: blur(8px);"></div>

        {{-- Main Content --}}
        <div class="container position-relative" style="z-index: 10;">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">

                    {{-- Main Heading --}}
                    <h1 class="font-serif fw-bold display-2 mb-3 text-gold" data-aos="fade-up" data-aos-delay="100">
                        TapalKuda
                    </h1>

                    {{-- Tagline --}}
                    <h2 class="display-5 fw-light mb-4 text-light" data-aos="fade-up" data-aos-delay="300">
                        Seni Menyeduh, Inovasi Rasa
                    </h2>

                    {{-- Description --}}
                    <p class="lead mb-5 mx-auto text-dim" data-aos="fade-up" data-aos-delay="400">
                        Kami memperlakukan kopi sebagai seni dan sains. Eksplorasi rasa terbaru <br
                            class="d-none d-md-block">
                        dari biji lokal yang dikurasi khusus untuk Anda.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ url('/menu') }}" class="btn btn-gold btn-lg px-5 py-3 rounded-pill">
                            <i class="fas fa-coffee me-2"></i>Pesan Sekarang
                        </a>
                        <a href="{{ url('/reservasi') }}" class="btn btn-glass btn-lg px-5 py-3 rounded-pill">
                            <i class="fas fa-calendar-alt me-2"></i>Reservasi Tempat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURED MENU SECTION - Glass Luxury --}}
    <section class="py-5 position-relative">
        <div class="container">
            {{-- Section Header --}}
            <div class="text-center mb-5" data-aos="fade-down">
                <h2 class="font-serif display-5 fw-bold text-gold mb-3">Pilihan Favorit Kami</h2>
                <div style="width: 60px; height: 3px; background: var(--accent-gold); margin: 0 auto;"></div>
                <p class="mt-3 lead text-dim">Lihat empat menu andalan yang wajib Anda coba saat berkunjung</p>
            </div>

            <div class="row g-4">
                {{-- Item Menu 1 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in">
                    <a href="{{ url('/menu/single-origin') }}" class="text-decoration-none">
                        <div class="glass-card h-100">
                            <div class="menu-img-container position-relative">
                                <img src="{{ asset('foto/CAPPUCINO.jpg') }}" class="menu-img" alt="Kopi saring V60">
                                <span class="price-tag">Rp 35.000</span>
                            </div>
                            <div class="p-4 text-center">
                                <h5 class="fw-bold text-light mb-1">Filter Coffee (V60)</h5>
                                <p class="text-gold small text-uppercase ls-1">Seasonal Single Origin</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Item Menu 2 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                    <a href="{{ url('/menu/signature') }}" class="text-decoration-none">
                        <div class="glass-card h-100">
                            <div class="menu-img-container position-relative">
                                <img src="{{ asset('foto/KOPITUBRUKROBUSTA.jpg') }}" class="menu-img" alt="Iced Latte">
                                <span class="price-tag">Rp 32.000</span>
                            </div>
                            <div class="p-4 text-center">
                                <h5 class="fw-bold text-light mb-1">Iced TapalKuda Latte</h5>
                                <p class="text-gold small text-uppercase ls-1">Signature Blend & Creamy</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Item Menu 3 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                    <a href="{{ url('/menu/pastry') }}" class="text-decoration-none">
                        <div class="glass-card h-100">
                            <div class="menu-img-container position-relative">
                                <img src="{{ asset('foto/Latte.jpg') }}" class="menu-img" alt="Matcha Cake">
                                <span class="price-tag">Rp 28.000</span>
                            </div>
                            <div class="p-4 text-center">
                                <h5 class="fw-bold text-light mb-1">Matcha Opera Cake</h5>
                                <p class="text-gold small text-uppercase ls-1">Pairing Dark Roast</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Item Menu 4 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                    <a href="{{ url('/menu#lightbites') }}" class="text-decoration-none">
                        <div class="glass-card h-100">
                            <div class="menu-img-container position-relative">
                                <img src="{{ asset('foto/kosu.jpg') }}" class="menu-img" alt="Avocado Toast">
                                <span class="price-tag">Rp 45.000</span>
                            </div>
                            <div class="p-4 text-center">
                                <h5 class="fw-bold text-light mb-1">Smashed Avocado Toast</h5>
                                <p class="text-gold small text-uppercase ls-1">brunch</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ url('/menu') }}" class="btn btn-glass btn-lg px-5 py-3 rounded-pill">
                    <i class="fas fa-book-open me-2"></i>Lihat Semua Menu
                </a>
            </div>
        </div>
    </section>

    {{-- CATEGORY SECTION --}}
    <section class="py-5 position-relative">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <h2 class="font-serif display-6 fw-bold text-gold">Pilar Utama Rasa Kami</h2>
            </div>

            <div class="row g-5">
                <div class="col-md-4 text-center" data-aos="zoom-in-up">
                    <div class="glass-card p-4 h-100">
                        <i class="fas fa-flask fa-3x text-gold mb-3"></i>
                        <h4 class="fw-bold text-light">Brewing Methods</h4>
                        <p class="text-dim">Eksperimen dengan V60, Chemex, dan Syphon untuk rasa yang berbeda.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center" data-aos="zoom-in-up" data-aos-delay="150">
                    <div class="glass-card p-4 h-100">
                        <i class="fas fa-leaf fa-3x text-gold mb-3"></i>
                        <h4 class="fw-bold text-light">Single Origin</h4>
                        <p class="text-dim">Temukan karakter unik dari biji kopi di setiap daerah. Tersedia Edisi Terbatas.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 text-center" data-aos="zoom-in-up" data-aos-delay="300">
                    <div class="glass-card p-4 h-100">
                        <i class="fas fa-cookie-bite fa-3x text-gold mb-3"></i>
                        <h4 class="fw-bold text-light">Food Pairing</h4>
                        <p class="text-dim">Camilan dan makanan ringan yang dibuat khusus untuk melengkapi kopi Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS SECTION - Glass Luxury --}}
    <section class="py-5 position-relative">
        <div class="container">
            {{-- Section Header --}}
            <div class="text-center mb-5" data-aos="fade-down">
                <h2 class="font-serif display-5 fw-bold text-gold mb-3">Apa Kata Mereka?</h2>
                <div style="width: 60px; height: 3px; background: var(--accent-gold); margin: 0 auto;"></div>
            </div>

            <div class="row g-4">
                {{-- Testimoni 1 --}}
                <div class="col-md-6 col-lg-4" data-aos="flip-up">
                    <div class="glass-card h-100 p-4 position-relative">
                        <i
                            class="fas fa-quote-left display-3 position-absolute top-0 start-0 translate-middle text-gold opacity-25 ms-5 mt-4"></i>
                        <div class="position-relative z-1 pt-3">
                            <p class="text-dim fst-italic">"Rasa kopi yang berani, tapi tetap lembut. Pilihan Single
                                Origin-nya selalu mengejutkan dengan kualitas yang premium."</p>
                            <div class="d-flex align-items-center mt-4">
                                <div class="bg-gold rounded-circle me-3" style="width: 40px; height: 40px;"></div>
                                <div>
                                    <h6 class="fw-bold text-light mb-0">Rina S.</h6>
                                    <small class="text-gold">Desainer Grafis</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Testimoni 2 --}}
                <div class="col-md-6 col-lg-4" data-aos="flip-up" data-aos-delay="150">
                    <div class="glass-card h-100 p-4 position-relative">
                        <i
                            class="fas fa-quote-left display-3 position-absolute top-0 start-0 translate-middle text-gold opacity-25 ms-5 mt-4"></i>
                        <div class="position-relative z-1 pt-3">
                            <p class="text-dim fst-italic">"Tempat yang sempurna untuk bekerja. Kopi dan sandwich-nya
                                ringan, tidak mengganggu fokus."</p>
                            <div class="d-flex align-items-center mt-4">
                                <div class="bg-gold rounded-circle me-3" style="width: 40px; height: 40px;"></div>
                                <div>
                                    <h6 class="fw-bold text-light mb-0">Andi K.</h6>
                                    <small class="text-gold">Entrepreneur</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Testimoni 3 --}}
                <div class="col-md-6 col-lg-4 mx-auto d-none d-lg-block" data-aos="flip-up" data-aos-delay="300">
                    <div class="glass-card h-100 p-4 position-relative">
                        <i
                            class="fas fa-quote-left display-3 position-absolute top-0 start-0 translate-middle text-gold opacity-25 ms-5 mt-4"></i>
                        <div class="position-relative z-1 pt-3">
                            <p class="text-dim fst-italic">"Konsepnya minimalis dan nyaman. Mereka benar-benar ahli dalam
                                menyajikan setiap detail biji kopi."</p>
                            <div class="d-flex align-items-center mt-4">
                                <div class="bg-gold rounded-circle me-3" style="width: 40px; height: 40px;"></div>
                                <div>
                                    <h6 class="fw-bold text-light mb-0">Santi W.</h6>
                                    <small class="text-gold">Food Blogger</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION LOKASI & JAM OPERASIONAL --}}
    <section class="py-5">
        <div class="container">
            <div class="glass-card p-5">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                        <h3 class="font-serif fw-bold mb-3 text-gold">Kunjungi Outlet Kami</h3>
                        <p class="lead text-dim">Kami menunggu Anda di pusat inovasi kopi kami.</p>

                        <div class="d-flex align-items-start mb-4">
                            <i class="fas fa-map-marker-alt fa-2x text-gold me-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1 text-light">Lokasi Utama</h5>
                                <p class="mb-1 text-dim">Margalaksana sumedang</p>
                                <a href="https://maps.app.goo.gl/ContohLinkGoogleMaps" target="_blank"
                                    class="text-decoration-none small text-gold hover:text-white transition-all">
                                    Lihat di Google Maps <i class="fas fa-external-link-alt small ms-1"></i>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <i class="fas fa-clock fa-2x text-gold me-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1 text-light">Jam Operasional</h5>
                                <p class="mb-0 text-dim">Selasa - Minggu: 10.00 - 21.00 WIB</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="ratio ratio-16x9 rounded-3 shadow border border-secondary border-opacity-25"
                            style="overflow: hidden; border-radius: 16px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1687459860623!2d107.88790757573882!3d-6.87037396722298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68d1b8e9ca8793%3A0x786b963c3e8cf075!2sKedai%20Kopi%20Tapal%20Kuda%20Sumedang!5e0!3m2!1sid!2sid!4v1760723900800!5m2!1sid!2sid"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection