<footer class="vintage-footer">
    <!-- Decorative top border -->
    <div class="footer-ornament-top">
        <div class="ornament-line"></div>
        <div class="ornament-center">☕</div>
        <div class="ornament-line"></div>
    </div>

    <div class="container">
        <div class="row g-4 py-5">

            <!-- Brand Section -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                <div class="footer-brand">
                    <h3 class="brand-name">TapalKuda</h3>
                    <p class="brand-tagline">Seni Menyeduh. Inovasi Rasa.</p>
                    <p class="brand-description">
                        Menghadirkan pengalaman kopi yang autentik dengan sentuhan modern,
                        di mana setiap tegukan bercerita tentang kualitas dan kehangatan.
                    </p>

                    <!-- Social Links -->
                    <div class="social-links mt-4">
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="footer-section">
                    <h5 class="footer-title">Navigasi</h5>
                    <div class="footer-divider"></div>
                    <ul class="footer-links">
                        <li><a href="{{ url('/home') }}">Home</a></li>
                        <li><a href="{{ url('/menu') }}">Daftar Menu</a></li>
                        <li><a href="{{ url('/reservasi') }}">Reservasi</a></li>
                        <li><a href="{{ url('/about') }}">Tentang Kami</a></li>
                    </ul>
                </div>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="150">
                <div class="footer-section">
                    <h5 class="footer-title">Layanan</h5>
                    <div class="footer-divider"></div>
                    <ul class="footer-links">
                        <li><a href="#">Dine In</a></li>
                        <li><a href="#">Take Away</a></li>
                        <li><a href="#">Delivery</a></li>
                        <li><a href="#">Catering</a></li>
                        <li><a href="#">Private Event</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="footer-section">
                    <h5 class="footer-title">Kontak</h5>
                    <div class="footer-divider"></div>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Pasanggrahan Baru, Kec. Sumedang Sel., Kabupaten Sumedang, Jawa Barat 45311</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>(+62) 812-8484-2484</span>
                        </li>
                        <li>
                            <i class="fab fa-instagram"></i>
                            <span>@kedaitapalkuda</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>10.00 - 21.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="footer-ornament-bottom">
                <div class="ornament-line"></div>
            </div>
            <div class="row align-items-center py-4">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="copyright mb-0">
                        &copy; {{ date('Y') }} <span class="brand-highlight">TapalKuda</span>.
                        Seluruh Hak Cipta Dilindungi.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-badges">
                        <span class="badge-item">🌟 Premium Quality</span>
                        <span class="badge-item">☕ Artisan Coffee</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Decorative coffee bean scatter -->
    <div class="footer-decoration">
        <span class="coffee-bean bean-1">☕</span>
        <span class="coffee-bean bean-2">☕</span>
        <span class="coffee-bean bean-3">☕</span>
    </div>
</footer>