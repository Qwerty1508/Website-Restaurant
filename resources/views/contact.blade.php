@extends('layouts.guest')

@section('title', 'Contact Us - Culinaire')

@section('content')
<div class="contact-wrapper">

    <div class="luxury-bg">
        <video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
            <source src="https://res.cloudinary.com/dh9ysyfit/video/upload/v1766045650/IMG_7855_dv47s8.mov" type="video/mp4">
        </video>
    </div>


    <div class="popup-overlay form-panel-overlay">
        <div class="popup-container form-panel p-5">
            <div class="h-100 d-flex flex-column justify-content-center px-lg-4">
                <div class="mb-4 text-center">
                    <h2 class="font-heading mb-3 text-dark">Send a Message</h2>
                    <p class="text-muted">Your feedback and enquiries are paramount to us.</p>
                </div>

                <form action="#" method="POST" class="luxury-form">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input type="text" class="form-control" id="name" placeholder=" " required>
                                <label for="name">Your Name</label>
                                <span class="line-focus"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input type="email" class="form-control" id="email" placeholder=" " required>
                                <label for="email">Email Address</label>
                                <span class="line-focus"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group floating-label">
                                <input type="text" class="form-control" id="subject" placeholder=" " required>
                                <label for="subject">Subject</label>
                                <span class="line-focus"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group floating-label">
                                <textarea class="form-control" id="message" rows="3" placeholder=" " required></textarea>
                                <label for="message">Message</label>
                                <span class="line-focus"></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="privacy-note text-muted small">
                            * Your details are kept strictly confidential.
                        </div>
                        <button type="button" class="btn-luxury">
                            <span class="btn-text">Send Message</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="scroll-content">

        <div class="scroll-spacer"></div>


        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="info-panel p-5">
                        <div class="row align-items-center">
                            <div class="col-md-5 mb-4 mb-md-0">
                                <h6 class="text-gold text-uppercase letter-spacing-3 mb-3">Get in Touch</h6>
                                <h1 class="display-5 font-heading text-white mb-4">Let's Start a<br>Conversation</h1>
                                <p class="text-white-50 font-light">
                                    We invite you to experience the extraordinary.
                                </p>
                                <div class="signature-line mt-4"></div>
                            </div>

                            <div class="col-md-1"></div>

                            <div class="col-md-6 contact-details">
                                <div class="contact-item mb-4">
                                    <div class="d-flex align-items-baseline">
                                        <span class="contact-number text-gold opacity-50 me-3">01</span>
                                        <div>
                                            <h5 class="text-white mb-1 font-heading">Visit Us</h5>
                                            <p class="text-white-50 mb-0">Jl. Ketintang No.156, Surabaya<br>East Java, Indonesia 60231</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="contact-item mb-4">
                                    <div class="d-flex align-items-baseline">
                                        <span class="contact-number text-gold opacity-50 me-3">02</span>
                                        <div>
                                            <h5 class="text-white mb-1 font-heading">Call Us</h5>
                                            <p class="text-white-50 mb-0">+62 31 828 6500<br>Mon - Sun, 08:00 - 20:00</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <div class="d-flex align-items-baseline">
                                        <span class="contact-number text-gold opacity-50 me-3">03</span>
                                        <div>
                                            <h5 class="text-white mb-1 font-heading">Write Us</h5>
                                            <p class="text-white-50 mb-0">info@surabaya.telkomuniversity.ac.id</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="map-section">
                        <div class="map-frame">
                            <iframe src="https://maps.google.com/maps?q=Universitas%20Telkom%20Surabaya,%20Jl.%20Ketintang%20No.156,%20Surabaya&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                                width="100%" height="400" style="border:0; filter: grayscale(100%) invert(92%) contrast(83%);" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --gold: #D4AF37;
        --dark-bg: #1a1a1a;
        --transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    body { background-color: #111; }

    .contact-wrapper {
        position: relative;
        min-height: 100vh;
    }

    .luxury-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: #111;
        z-index: -1;
    }


    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: all 0.8s ease;
    }

    .popup-overlay.visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .popup-container {
        max-width: 900px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 8px;
        transform: translateY(50px) scale(0.95);
        transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    .popup-overlay.visible .popup-container {
        transform: translateY(0) scale(1);
    }


    .scroll-content {
        position: relative;
        z-index: 10;
    }

    .scroll-spacer {
        height: 300vh;
    }


    .form-panel {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    }


    .info-panel {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        border-radius: 8px;
        opacity: 0;
        transform: translateY(50px);
        transition: all 1s ease;
    }

    .info-panel.visible {
        opacity: 1;
        transform: translateY(0);
    }


    .map-section {
        opacity: 0;
        transform: translateY(30px);
        transition: all 1s ease;
    }

    .map-section.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .map-frame {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        height: 400px;
        overflow: hidden;
        border-radius: 8px;
    }

    .text-gold { color: var(--gold) !important; }
    .letter-spacing-3 { letter-spacing: 3px; }
    .font-heading { font-family: 'Playfair Display', serif; }
    .font-light { font-weight: 300; }
    
    .contact-number {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-style: italic;
    }
    
    .signature-line {
        width: 50px;
        height: 2px;
        background: var(--gold);
        opacity: 0.5;
    }
    

    .form-group { position: relative; margin-bottom: 1.5rem; }
    
    .form-control {
        border: none;
        border-bottom: 1px solid #ddd;
        border-radius: 0;
        padding: 0.8rem 0;
        font-family: inherit;
        background: transparent;
        transition: var(--transition);
        font-size: 0.95rem;
        color: #333;
    }
    
    .form-control:focus {
        box-shadow: none;
        background: transparent;
        border-bottom-color: var(--gold);
    }
    
    .form-control::placeholder { color: transparent; }
    
    .floating-label label {
        position: absolute;
        top: 0.8rem;
        left: 0;
        color: #555;
        font-size: 0.95rem;
        pointer-events: none;
        transition: var(--transition);
    }
    
    .form-control:focus ~ label,
    .form-control:not(:placeholder-shown) ~ label {
        top: -1.2rem;
        font-size: 0.75rem;
        color: var(--gold);
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    .line-focus {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 1px;
        background-color: var(--gold);
        transition: var(--transition);
    }
    
    .form-control:focus ~ .line-focus { width: 100%; }
    
    .btn-luxury {
        background: transparent;
        border: 1px solid #333;
        padding: 12px 30px;
        font-family: 'Playfair Display', serif;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }
    
    .btn-luxury .btn-text {
         position: relative; z-index: 2; color: #333; transition: color 0.3s; 
    }
    .btn-luxury::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 0; background-color: #333; transition: var(--transition); z-index: 1;
    }
    .btn-luxury:hover::after { height: 100%; }
    .btn-luxury:hover .btn-text { color: #fff; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formOverlay = document.querySelector('.form-panel-overlay');
        const infoPanel = document.querySelector('.info-panel');
        const mapSection = document.querySelector('.map-section');
        
        checkScroll();
        window.addEventListener('scroll', checkScroll);

        function checkScroll() {
            const scrollY = window.scrollY;
            const windowHeight = window.innerHeight;

            // 1. Form Panel Popup: Appear 300-2000px (fixed centered, stays long)
            if (scrollY > 300 && scrollY < 2000) {
                formOverlay.classList.add('visible');
            } else {
                formOverlay.classList.remove('visible');
            }

            // 2. Info Panel: Animate in/out when scrolled into/out of view
            const infoPanelTop = infoPanel.getBoundingClientRect().top;
            if (infoPanelTop < windowHeight * 0.8) {
                infoPanel.classList.add('visible');
            } else {
                infoPanel.classList.remove('visible');
            }

            // 3. Map: Animate in/out when scrolled into/out of view
            const mapTop = mapSection.getBoundingClientRect().top;
            if (mapTop < windowHeight * 0.9) {
                mapSection.classList.add('visible');
            } else {
                mapSection.classList.remove('visible');
            }
        }
    });
</script>
@endpush
