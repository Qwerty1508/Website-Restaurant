<footer class="footer" id="contact">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">
                    Culinaire<span>.</span>
                </div>
                <p class="text-light opacity-75 mb-4">
                    Nikmati pengalaman kuliner premium dengan cita rasa autentik Indonesia. 
                    Kami menyajikan hidangan terbaik dengan bahan-bahan berkualitas tinggi.
                </p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h5>Menu</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/menu') }}">Menu Kami</a></li>
                    <li><a href="{{ url('/reservation') }}">Reservasi</a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6">
                <h5>Layanan</h5>
                <ul class="footer-links">
                    <li><a href="#">Dine In</a></li>
                    <li><a href="#">Take Away</a></li>
                    <li><a href="#">Reservasi Meja</a></li>
                    <li><a href="#">Private Dining</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5>Hubungi Kami</h5>
                <ul class="footer-links">
                    <li>
                        <i class="bi bi-geo-alt me-2 text-warning"></i>
                        Jl. Kuliner No. 123, Jakarta Selatan
                    </li>
                    <li>
                        <i class="bi bi-telephone me-2 text-warning"></i>
                        +62 21 1234 5678
                    </li>
                    <li>
                        <i class="bi bi-envelope me-2 text-warning"></i>
                        info@culinaire.com
                    </li>
                    <li>
                        <i class="bi bi-clock me-2 text-warning"></i>
                        Senin - Minggu: 10:00 - 22:00
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">
                        &copy; {{ date('Y') }} <strong>Culinaire</strong>. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-light opacity-75 me-3">Privacy Policy</a>
                    <a href="#" class="text-light opacity-75">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>