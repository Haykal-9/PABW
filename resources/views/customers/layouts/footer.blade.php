<footer class="footer-glass">
    <div class="container">
        <div class="row g-4 py-5">

            <!-- Brand Section -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fas fa-coffee text-gold fs-3"></i>
                    <h3 class="font-serif fw-bold text-gold mb-0">TapalKuda</h3>
                </div>
                <p class="text-gold opacity-75 fw-medium small text-uppercase ls-1">Seni Menyeduh. Inovasi Rasa.</p>
                <p class="text-dim">
                    Menghadirkan pengalaman kopi yang autentik dengan sentuhan modern,
                    di mana setiap tegukan bercerita tentang kualitas dan kehangatan.
                </p>

                <!-- Social Links -->
                <div class="d-flex gap-3 mt-4">
                    <a href="#"
                        class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 36px; height: 36px;" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#"
                        class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 36px; height: 36px;" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 36px; height: 36px;" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold text-gold mb-4">Navigasi</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/home') }}"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Home</a></li>
                    <li class="mb-2"><a href="{{ url('/menu') }}"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Daftar Menu</a></li>
                    <li class="mb-2"><a href="{{ url('/reservasi') }}"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Reservasi</a></li>
                    <li class="mb-2"><a href="{{ url('/about') }}"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Tentang Kami</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold text-gold mb-4">Layanan</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Dine In</a></li>
                    <li class="mb-2"><a href="#"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Take Away</a></li>
                    <li class="mb-2"><a href="#"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Delivery</a></li>
                    <li class="mb-2"><a href="#"
                            class="text-dim text-decoration-none hover:text-gold transition-all">Private Event</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold text-gold mb-4">Kontak</h5>
                <ul class="list-unstyled text-dim">
                    <li class="d-flex mb-3">
                        <i class="fas fa-map-marker-alt text-gold mt-1 me-3"></i>
                        <span>Pasanggrahan Baru, Kec. Sumedang Sel., Kabupaten Sumedang, Jawa Barat 45311</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="fas fa-phone text-gold mt-1 me-3"></i>
                        <span>(+62) 812-8484-2484</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="fab fa-instagram text-gold mt-1 me-3"></i>
                        <span>@kedaitapalkuda</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="fas fa-clock text-gold mt-1 me-3"></i>
                        <span>10.00 - 21.00 WIB</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="border-top border-secondary border-opacity-25 py-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="text-dim small mb-0">
                        &copy; {{ date('Y') }} <span class="text-gold fw-bold">TapalKuda</span>.
                        <span class="opacity-75">All Rights Reserved.</span>
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex justify-content-center justify-content-md-end gap-3 text-dim small">
                        <span><i class="fas fa-star text-gold me-1"></i> Premium Quality</span>
                        <span><i class="fas fa-mug-hot text-gold me-1"></i> Artisan Coffee</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</footer>

<style>
    .hover\:text-gold:hover {
        color: var(--accent-gold) !important;
        padding-left: 5px;
    }

    .transition-all {
        transition: all 0.3s ease;
    }
</style>