@extends('layouts.app')

@section('title', 'TapalKuda - Daftar Menu Lengkap')

@section('content')

{{-- ASUMSI: Anda sudah mendefinisikan .text-primary-dark dan .btn-primary-dark di CSS atau utilitas Bootstrap Anda. --}}

<section class="menu-list py-5" id="menu-section">
    <div class="container-fluid">
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="display-5 fw-bold text-primary-dark">Daftar Menu Kami</h1>
            <p class="lead text-muted">Eksplorasi seluruh inovasi rasa dari biji kopi hingga sajian ringan.</p>
        </div>

        <div class="row g-5">
            
            {{-- KOLOM KIRI: SIDEBAR KATEGORI (2 Kolom) --}}
            <div class="col-lg-2" data-aos="fade-right">
                
                {{-- Judul Filter --}}
                <h5 class="fw-bold text-uppercase text-primary-dark mb-4 border-bottom pb-2">Kategori</h5>
                
                {{-- NAVIGASI SIDEBAR: Tag/Pills Vertikal (Hanya Bootstrap) --}}
                <nav class="nav flex-column gap-2" id="menu-pills-tab" role="tablist">
                    
                    {{-- Tombol 'Semua Menu' (Active secara default) --}}
                    <button type="button" 
                            {{-- Gunakan btn-outline-dark sebagai state default --}}
                            class="btn btn-outline-dark text-start menu-filter-btn active fw-bold w-100 py-2 rounded-pill shadow-sm"
                            data-category="all">
                        <i class="fas fa-list me-2"></i>Semua Menu
                    </button>
                    
                    {{-- Tombol Kopi --}}
                    <button type="button" 
                            class="btn btn-outline-dark text-start menu-filter-btn active fw-bold w-100 py-2 rounded-pill shadow-sm"
                            data-category="coffee">
                        <i class="fas fa-mug-hot me-2"></i>Kopi
                    </button>
                    
                    {{-- Tombol Non-Kopi --}}
                    <button type="button" 
                            class="btn btn-outline-dark text-start menu-filter-btn active fw-bold w-100 py-2 rounded-pill shadow-sm"
                            data-category="non-coffee">
                        <i class="fas fa-tint me-2"></i>Non-Kopi
                    </button>
                    
                    {{-- Tombol Cemilan --}}
                    <button type="button" 
                            class="btn btn-outline-dark text-start menu-filter-btn active fw-bold w-100 py-2 rounded-pill shadow-sm"
                            data-category="cemilan">
                        <i class="fas fa-cookie-bite me-2"></i>Cemilan
                    </button>

                    {{-- Tombol Makanan (ditambahkan) --}}
                    <button type="button"
                            class="btn btn-outline-dark text-start menu-filter-btn active fw-bold w-100 py-2 rounded-pill shadow-sm"
                            data-category="makanan">
                        <i class="fas fa-hamburger me-2"></i>Makanan
                    </button>

                </nav>
            </div> 

            
            {{-- KOLOM KANAN: DAFTAR MENU (MENU CARDS) (10 Kolom) --}}
            <div class="col-lg-10" data-aos="fade-left">
                <div class="row g-4" id="menu-cards-container">
                    
                    {{-- Item Menu 1 (Contoh Kopi) --}}
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="coffee" data-aos="zoom-in">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/arabika.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Arabika</h5>
                                 <p class="card-text text-muted small">Espresso, Fresh Milk, Sirup Vanila.</p>
                                 <p class="fw-bold text-primary-dark">Rp 35.000</p>
                             </div>
                        </div>
                    </div>

                    {{-- Item Menu 2 (Contoh Non-Kopi) --}}
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="non-coffee" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/red.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Matcha Premium</h5>
                                 <p class="card-text text-muted small">Bubuk matcha Jepang dan susu segar.</p>
                                 <p class="fw-bold text-primary-dark">Rp 40.000</p>
                             </div>
                        </div>
                    </div>
                    
                    {{-- Item Menu 3 (Contoh Cemilan) --}}
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="cemilan" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/kentangSosis.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Classic Croissant</h5>
                                 <p class="card-text text-muted small">Roti lapis mentega Prancis.</p>
                                 <p class="fw-bold text-primary-dark">Rp 25.000</p>
                             </div>
                        </div>
                    </div>
                    
                    {{-- Item Menu 4 (Contoh Kopi) --}}
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="makanan" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/AyamTeriyaki.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="cemilan" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/balabala.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="makanan" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/cuanki.png') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="coffee" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/ESPRESSO.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="coffee" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/JAPAN.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="non-coffee" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/taro.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="non-coffee" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/TehManis.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="non-coffee" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/wedang.jpg') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="makanan" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card border-0 shadow-sm h-100">
                             <img src="{{ asset('foto/nasiTutug.webp') }}" class="card-img-top" alt="Menu Item">
                             <div class="card-body">
                                 <h5 class="card-title fw-bold">Americano Dingin</h5>
                                 <p class="card-text text-muted small">House blend TapalKuda dengan air dingin.</p>
                                 <p class="fw-bold text-primary-dark">Rp 20.000</p>
                             </div>
                        </div>
                    </div>

                    {{-- ... Tambahkan lebih banyak item menu di sini ... --}}
                    
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.menu-filter-btn');
        const menuItems = document.querySelectorAll('.menu-card-item');

        // Kelas default saat tidak aktif (tanpa hover)
        const DEFAULT_CLASSES = 'border border-dark text-dark bg-transparent fw-semibold';
        // Kelas saat aktif (menggunakan warna tema)
        const ACTIVE_CLASSES = 'btn-primary-dark text-white shadow-sm fw-bold';

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // 1. Kelola Kelas Aktif
                filterButtons.forEach(btn => {
                    // Hapus kelas aktif
                    btn.classList.remove('active', 'btn-primary-dark', 'text-white', 'shadow-sm');
                    // Tambahkan kelas default non-hover
                    btn.className = btn.className.replace(ACTIVE_CLASSES, '').trim(); // Hapus kelas active
                    btn.classList.add(...DEFAULT_CLASSES.split(' ')); 
                });
                
                // Tambahkan kelas active ke tombol yang diklik
                this.className = this.className.replace(DEFAULT_CLASSES, '').trim(); // Hapus kelas default
                this.classList.add('active', 'btn-primary-dark', 'text-white', 'shadow-sm', 'fw-bold'); 
                
                // Logika Filter
                const selectedCategory = this.getAttribute('data-category');
                menuItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    
                    if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                        item.classList.remove('d-none');
                        item.style.display = 'block'; 
                    } else {
                        item.classList.add('d-none');
                        item.style.display = 'none';
                    }
                });
            });
        });

        // 2. Inisialisasi Active State pada tombol 'All' saat pertama kali dimuat
        const initialActiveButton = document.querySelector('.menu-filter-btn[data-category="all"]');
        if(initialActiveButton) {
             // Pastikan tombol awal menggunakan kelas aktif yang benar
             initialActiveButton.classList.remove(...DEFAULT_CLASSES.split(' '));
             initialActiveButton.classList.add('active', 'btn-primary-dark', 'text-white', 'shadow-sm', 'fw-bold');
        }
    });
</script>
@endpush