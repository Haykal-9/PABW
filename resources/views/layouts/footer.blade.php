{{-- FOOTER: Menggunakan warna gelap primer (primary-dark) untuk kontras --}}
<footer class="bg-primary-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            
            {{-- KOLOM 1: BRANDING & SOSIAL --}}
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <h4 class="fw-bolder mb-3">TapalKuda</h4>
                <p class="small text-muted">Seni Menyeduh. Inovasi Rasa.</p>
                
                {{-- Tautan Media Sosial --}}
                <div class="social-links mt-3">
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            
            {{-- KOLOM 2: QUICK LINKS (Navigasi Sekunder) --}}
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <h5 class="fw-bold mb-3 border-bottom border-secondary pb-2">Navigasi</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ url('/menu') }}" class="text-decoration-none text-muted hover-primary">Daftar Menu</a></li>
                    <li class="mb-2"><a href="{{ url('/specialty') }}" class="text-decoration-none text-muted hover-primary">Single Origin</a></li>
                    <li class="mb-2"><a href="{{ url('/reservasi') }}" class="text-decoration-none text-muted hover-primary">Reservasi Tempat</a></li>
                    <li class="mb-2"><a href="{{ url('/about') }}" class="text-decoration-none text-muted hover-primary">Tentang Kami</a></li>
                </ul>
            </div>
            
            {{-- KOLOM 3: KONTAK & LOKASI --}}
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <h5 class="fw-bold mb-3 border-bottom border-secondary pb-2">Kontak Kami</h5>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Kopi Inovasi No. 18, Bandung</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> +62 812-3456-7890</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@tapalkudacoffee.com</li>
                    <li class="mb-2"><i class="fas fa-clock me-2"></i> Jam Buka: 08.00 - 21.00 WIB</li>
                </ul>
            </div>
            
        </div>
        
        <hr class="border-secondary my-4">
        
        {{-- COPYRIGHT --}}
        <div class="row">
            <div class="col-12 text-center">
                <p class="small text-muted mb-0">&copy; {{ date('Y') }} TapalKuda. Seluruh Hak Cipta Dilindungi.</p>
            </div>
        </div>

    </div>
</footer>