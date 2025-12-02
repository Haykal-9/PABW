@extends('customers.layouts.app')

@section('title', 'Inovasi Kopi')

@section('content')

    {{-- HERO SECTION - Vintage Modern --}}
    <section class="vintage-hero d-flex align-items-center text-white vh-100 position-relative overflow-hidden"
        id="hero-section"
        style="background-image: url('{{ asset('logo/biji.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">

        {{-- Vintage Overlay with Gradient --}}
        <div class="vintage-hero-overlay"></div>

        {{-- Decorative Top Border --}}
        <div class="hero-ornament-top">
            <div class="ornament-line-hero"></div>
            <div class="ornament-diamond">◆</div>
            <div class="ornament-line-hero"></div>
        </div>

        {{-- Main Content --}}
        <div class="container position-relative" style="z-index: 10;">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">


                    {{-- Main Heading --}}
                    <h1 class="hero-title display-2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100">
                        TapalKuda
                    </h1>

                    {{-- Decorative Divider --}}
                    <div class="hero-divider mx-auto" data-aos="zoom-in" data-aos-delay="200">
                        <span class="divider-ornament"></span>
                    </div>

                    {{-- Tagline --}}
                    <h2 class="hero-subtitle display-4 fw-light mb-4" data-aos="fade-up" data-aos-delay="300">
                        Seni Menyeduh, Inovasi Rasa
                    </h2>

                    {{-- Description --}}
                    <p class="hero-description lead mb-5 mx-auto" data-aos="fade-up" data-aos-delay="400">
                        Kami memperlakukan kopi sebagai seni dan sains. Eksplorasi rasa terbaru <br
                            class="d-none d-md-block">
                        dari biji lokal yang dikurasi khusus untuk Anda.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="hero-cta-group" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ url('/menu') }}" class="btn btn-vintage-gold btn-lg px-5 py-3 me-3 mb-3">
                            <i class="fas fa-coffee me-2"></i>Pesan Sekarang
                        </a>
                        <a href="{{ url('/reservasi') }}" class="btn btn-vintage-outline btn-lg px-5 py-3 mb-3">
                            <i class="fas fa-calendar-alt me-2"></i>Reservasi Tempat
                        </a>
                    </div>

                    {{-- Scroll Indicator --}}
                    <div class="scroll-indicator mt-5" data-aos="fade-up" data-aos-delay="600">
                        <div class="scroll-mouse">
                            <div class="scroll-wheel"></div>
                        </div>
                        <p class="scroll-text mt-2">Scroll untuk Jelajahi</p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Decorative Bottom Border --}}
        <div class="hero-ornament-bottom">
            <div class="ornament-line-hero"></div>
        </div>

        {{-- Floating Coffee Beans Decoration --}}
        <div class="hero-floating-beans">
            <span class="floating-bean bean-hero-1">☕</span>
            <span class="floating-bean bean-hero-2">☕</span>
            <span class="floating-bean bean-hero-3">☕</span>
            <span class="floating-bean bean-hero-4">☕</span>
        </div>

    </section>

    {{-- FEATURED MENU SECTION - Vintage Modern --}}
    <section class="vintage-menu-section py-5 bg-light position-relative">
        <div class="container">
            {{-- Section Header with Ornaments --}}
            <div class="text-center mb-5" data-aos="fade-down">
                <div class="vintage-section-ornament mb-3">
                    <span class="ornament-left">◆</span>
                    <span class="ornament-coffee">☕</span>
                    <span class="ornament-right">◆</span>
                </div>
                <h2 class="vintage-section-title display-5 fw-bold text-primary-dark mb-3">Pilihan Favorit Kami</h2>
                <div class="vintage-divider-small mx-auto mb-3"></div>
                <p class="lead text-muted">Lihat empat menu andalan yang wajib Anda coba saat berkunjung</p>
            </div>

            <div class="row g-4">
                {{-- Item Menu 1 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in">
                    <a href="{{ url('/menu/single-origin') }}" class="text-decoration-none">
                        <div class="vintage-menu-card h-100">
                            <div class="vintage-card-image-wrapper">
                                <img src="{{ asset('foto/CAPPUCINO.jpg') }}" class="vintage-card-image"
                                    alt="Kopi saring V60 disajikan di gelas bening">
                                <div class="vintage-card-overlay"></div>
                            </div>
                            <div class="vintage-card-body text-center">
                                <div class="card-ornament-top">◆</div>
                                <h5 class="vintage-card-title fw-bold">Filter Coffee (V60)</h5>
                                <p class="vintage-card-subtitle">Seasonal Single Origin</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Item Menu 2 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                    <a href="{{ url('/menu/signature') }}" class="text-decoration-none">
                        <div class="vintage-menu-card h-100">
                            <div class="vintage-card-image-wrapper">
                                <img src="{{ asset('foto/KOPITUBRUKROBUSTA.jpg') }}" class="vintage-card-image"
                                    alt="Iced Latte dengan lapisan susu dan espresso">
                                <div class="vintage-card-overlay"></div>
                            </div>
                            <div class="vintage-card-body text-center">
                                <div class="card-ornament-top">◆</div>
                                <h5 class="vintage-card-title fw-bold">Iced TapalKuda Latte</h5>
                                <p class="vintage-card-subtitle">Signature Blend & Creamy</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Item Menu 3 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                    <a href="{{ url('/menu/pastry') }}" class="text-decoration-none">
                        <div class="vintage-menu-card h-100">
                            <div class="vintage-card-image-wrapper">
                                <img src="{{ asset('foto/Latte.jpg') }}" class="vintage-card-image"
                                    alt="Slice of Matcha Cake dengan garnish">
                                <div class="vintage-card-overlay"></div>
                            </div>
                            <div class="vintage-card-body text-center">
                                <div class="card-ornament-top">◆</div>
                                <h5 class="vintage-card-title fw-bold">Matcha Opera Cake</h5>
                                <p class="vintage-card-subtitle">Pairing terbaik dengan Dark Roast</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Item Menu 4 --}}
                <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                    <a href="{{ url('/menu#lightbites') }}" class="text-decoration-none">
                        <div class="vintage-menu-card h-100">
                            <div class="vintage-card-image-wrapper">
                                <img src="{{ asset('foto/kosu.jpg') }}" class="vintage-card-image"
                                    alt="Avocado Toast dengan telur dan biji-bijian">
                                <div class="vintage-card-overlay"></div>
                            </div>
                            <div class="vintage-card-body text-center">
                                <div class="card-ornament-top">◆</div>
                                <h5 class="vintage-card-title fw-bold">Smashed Avocado Toast</h5>
                                <p class="vintage-card-subtitle">Pilihan sarapan dan brunch</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ url('/menu') }}" class="btn btn-vintage-outline btn-lg px-5 py-3">
                    <i class="fas fa-book-open me-2"></i>Lihat Semua Menu
                </a>
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
                    <p class="text-muted">Temukan karakter unik dari biji kopi di setiap daerah. Tersedia Edisi Terbatas.
                    </p>
                </div>
                <div class="col-md-4 text-center" data-aos="zoom-in-up" data-aos-delay="300">
                    <i class="fas fa-cookie-bite fa-3x text-primary-dark mb-3"></i>
                    <h4 class="fw-bold">Food Pairing</h4>
                    <p class="text-muted">Camilan dan makanan ringan yang dibuat khusus untuk melengkapi kopi Anda.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS SECTION - Vintage Modern --}}
    <section class="vintage-testimonials py-5 bg-white position-relative">
        <div class="container">
            {{-- Section Header --}}
            <div class="text-center mb-5" data-aos="fade-down">
                <div class="vintage-section-ornament mb-3">
                    <span class="ornament-left">◆</span>
                    <span class="ornament-quote">❝</span>
                    <span class="ornament-right">◆</span>
                </div>
                <h2 class="vintage-section-title display-5 fw-bold text-primary-dark mb-3">Apa Kata Mereka?</h2>
                <div class="vintage-divider-small mx-auto mb-3"></div>
            </div>

            <div class="row g-4">
                {{-- Testimoni 1 --}}
                <div class="col-md-6 col-lg-4" data-aos="flip-up">
                    <div class="vintage-testimonial-card h-100">
                        <div class="testimonial-quote-mark">❝</div>
                        <p class="testimonial-text fst-italic">"Rasa kopi yang berani, tapi tetap lembut. Pilihan Single
                            Origin-nya selalu
                            mengejutkan dengan kualitas yang premium. Favorit saya!"</p>
                        <div class="testimonial-author mt-4">
                            <div class="author-ornament mb-2"></div>
                            <p class="author-name fw-bold mb-0">Rina S.</p>
                            <small class="author-title">Desainer Grafis</small>
                        </div>
                    </div>
                </div>
                {{-- Testimoni 2 --}}
                <div class="col-md-6 col-lg-4" data-aos="flip-up" data-aos-delay="150">
                    <div class="vintage-testimonial-card h-100">
                        <div class="testimonial-quote-mark">❝</div>
                        <p class="testimonial-text fst-italic">"Tempat yang sempurna untuk bekerja. Kopi dan sandwich-nya
                            ringan, tidak
                            mengganggu fokus. Pelayanannya sangat ramah."</p>
                        <div class="testimonial-author mt-4">
                            <div class="author-ornament mb-2"></div>
                            <p class="author-name fw-bold mb-0">Andi K.</p>
                            <small class="author-title">Entrepreneur Digital</small>
                        </div>
                    </div>
                </div>
                {{-- Testimoni 3 --}}
                <div class="col-md-6 col-lg-4 mx-auto d-none d-lg-block" data-aos="flip-up" data-aos-delay="300">
                    <div class="vintage-testimonial-card h-100">
                        <div class="testimonial-quote-mark">❝</div>
                        <p class="testimonial-text fst-italic">"Konsepnya minimalis dan nyaman. Mereka benar-benar ahli
                            dalam menyajikan
                            setiap detail biji kopi. Benar-benar seni menyeduh."</p>
                        <div class="testimonial-author mt-4">
                            <div class="author-ornament mb-2"></div>
                            <p class="author-name fw-bold mb-0">Santi W.</p>
                            <small class="author-title">Food Blogger</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- SECTION LOKASI & JAM OPERASIONAL --}}
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
                            <p class="mb-0">Margalaksana sumedang</p>
                            <a href="https://maps.app.goo.gl/ContohLinkGoogleMaps" target="_blank"
                                class="text-decoration-none small text-primary-dark">Lihat di Google Maps <i
                                    class="fas fa-external-link-alt small"></i></a>
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
                    <div class="ratio ratio-16x9 rounded-3 shadow">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1687459860623!2d107.88790757573882!3d-6.87037396722298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68d1b8e9ca8793%3A0x786b963c3e8cf075!2sKedai%20Kopi%20Tapal%20Kuda%20Sumedang!5e0!3m2!1sid!2sid!4v1760723900800!5m2!1sid!2sid"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection