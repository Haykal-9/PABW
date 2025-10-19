@extends('customers.layouts.app')

@section('title', 'Daftar Menu Lengkap')

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
                    @foreach($menus as $menu)
                        <div class="col-6 col-md-4 col-lg-3 menu-card-item" data-category="{{ $menu['category'] }}" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card border-0 shadow-sm h-100 bg-secondary bg-opacity-25">
                                <div class="image-wrap">
                                    <img src="{{ asset($menu['image_url']) }}" class="card-img-top" alt="{{ $menu['name'] }}">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-dark">{{ $menu['name'] }}</h5>
                                    <p class="card-text text-secondary small">{{ $menu['description_short'] }}</p>
                                    <p class="fw-bold text-primary-dark">Rp {{ number_format($menu['price'],0,',','.') }}</p>
                                    <div class="mt-3">
                                        <a href="{{ url('/menu/'.$menu['id']) }}" class="btn btn-primary-dark btn-sm">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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