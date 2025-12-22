@extends('layouts.guest')

@section('title', 'About • Cylinaire')

@section('content')
<div class="cursor-follower"></div>
<div class="cursor-dot"></div>

<div class="preloader">
    <div class="preloader-content">
        <h1 class="preloader-brand font-display">CULINAIRE</h1>
        <div class="preloader-line"></div>
        <div class="preloader-counter font-mono">0%</div>
    </div>
</div>

<div class="noise-overlay"></div>

    <div class="main-content">

        <section class="hero-section text-center text-white position-relative" data-scroll-section style="background-color: #0C2A36;">
            <div class="hero-bg parallax-img" style="background-image: url('https://res.cloudinary.com/dh9ysyfit/image/fetch/w_1920,c_fill,f_auto,q_auto/https://images.unsplash.com/photo-1505935428862-770b6f24f629'); opacity: 0.6;" data-speed="0.5"></div>
            <div class="hero-overlay" style="background: linear-gradient(to bottom, rgba(12,42,54,0.3), #0C2A36);"></div>
            
            <div class="container-fluid h-100 px-4 px-lg-5 d-flex flex-column justify-content-center align-items-center position-relative z-2">
                <div class="hero-text-wrapper overflow-hidden">
                    <h6 class="text-gold tracking-widest font-mono mb-4 text-hero-sup animate-fadeInUp" data-i18n="about_hero_subtitle">{{ __('messages.about_hero_subtitle') }}</h6>
                </div>
                <div class="hero-title-wrapper">
                    <h1 class="font-display display-giant text-hero-main text-white mb-4">
                        <span class="d-block overflow-hidden animate-fadeInUp delay-1" data-i18n="about_hero_title">{{ __('messages.about_hero_title') }}</span>
                    </h1>
                </div>
                <div class="scroll-indicator animate-fadeInUp delay-3">
                    <div class="scroll-line bg-gold"></div>
                    <span class="font-mono text-xs text-gold" data-i18n="scroll">{{ __('messages.scroll') }}</span>
                </div>
            </div>
        </section>

        <section class="history-chapter section-padding position-relative text-white" style="background-color: #1a3d4d;" data-scroll-section>
            <div class="container-fluid px-4 px-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="chapter-content pe-lg-5 animate-slideInRight">
                            <span class="chapter-year display-1 font-display text-gold-faint d-block mb-3" style="opacity: 0.2;" data-i18n="chapter_1_year">{{ __('messages.chapter_1_year') }}</span>
                            <h2 class="font-display display-4 mb-2 text-gold" data-i18n="chapter_1_subtitle">{{ __('messages.chapter_1_subtitle') }}</h2>
                            <h4 class="font-mono tracking-widest text-light mb-4" data-i18n="chapter_1_title">{{ __('messages.chapter_1_title') }}</h4>
                            <p class="text-white-50 lead font-body text-justify" data-i18n="chapter_1_desc">
                                {{ __('messages.chapter_1_desc') }}
                            </p>
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="image-frame-rustic position-relative animate-fadeInLeft delay-2">
                            <div class="position-absolute w-100 h-100 border border-gold" style="top: 20px; left: 20px; opacity: 0.3; z-index: 0;"></div>
                            <img src="https://res.cloudinary.com/dh9ysyfit/image/fetch/w_800,c_fill,f_auto,q_80/https://images.unsplash.com/photo-1516455590571-18256e5bb9ff" 
                                 class="img-fluid position-relative z-1 shadow-2xl" 
                                 alt="Rustic Wooden Interior" style="filter: sepia(30%) contrast(1.1);"
                                 loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="transition-spacer" style="height: 100px; background: linear-gradient(to bottom, #1a3d4d, #2a5060);" data-scroll-section></div>

        <section class="history-chapter section-padding position-relative text-white" style="background-color: #2a5060;" data-scroll-section>
            <div class="container-fluid px-4 px-lg-5">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="chapter-content ps-lg-5 text-lg-end animate-slideInLeft">
                            <span class="chapter-year display-1 font-display text-white-50 d-block mb-3" style="opacity: 0.1;" data-i18n="chapter_2_year">{{ __('messages.chapter_2_year') }}</span>
                            <h2 class="font-display display-4 mb-2 text-white" data-i18n="chapter_2_subtitle">{{ __('messages.chapter_2_subtitle') }}</h2>
                            <h4 class="font-mono tracking-widest text-gold mb-4" data-i18n="chapter_2_title">{{ __('messages.chapter_2_title') }}</h4>
                            <p class="text-white-50 lead font-body text-justify" data-i18n="chapter_2_desc">
                                {{ __('messages.chapter_2_desc') }}
                            </p>
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="image-frame-industrial position-relative animate-fadeInRight delay-2">
                             <div class="position-absolute w-100 h-100 bg-dark" style="top: -20px; right: -20px; opacity: 0.5; z-index: 0;"></div>
                            <img src="https://res.cloudinary.com/dh9ysyfit/image/fetch/w_800,c_fill,f_auto,q_80/https://images.unsplash.com/photo-1559339352-11d035aa65de" 
                                 class="img-fluid position-relative z-1 shadow-2xl grayscale-hover" 
                                 alt="Brick Restaurant Interior"
                                 loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="transition-spacer" style="height: 100px; background: linear-gradient(to bottom, #2a5060, #F6F2EE);" data-scroll-section></div>

        <section class="history-chapter section-padding position-relative" style="background-color: #F6F2EE;" data-scroll-section>
            <div class="container-fluid px-4 px-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="chapter-content pe-lg-5 animate-slideInRight">
                            <span class="chapter-year display-1 font-display text-gold-faint d-block mb-3" style="opacity: 0.2;" data-i18n="chapter_3_year">{{ __('messages.chapter_3_year') }}</span>
                            <h2 class="font-display display-4 mb-2 text-dark" data-i18n="chapter_3_subtitle">{{ __('messages.chapter_3_subtitle') }}</h2>
                            <h4 class="font-mono tracking-widest text-gold mb-4" data-i18n="chapter_3_title">{{ __('messages.chapter_3_title') }}</h4>
                            <p class="text-muted lead font-body text-justify" data-i18n="chapter_3_desc">
                                {{ __('messages.chapter_3_desc') }}
                            </p>
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="image-frame-luxury position-relative animate-fadeInLeft delay-2">
                             <div class="position-absolute rounded-circle border border-gold" style="width: 150px; height: 150px; top: -40px; right: -40px; z-index: 2; opacity: 0.6;"></div>
                            <img src="https://res.cloudinary.com/dh9ysyfit/image/fetch/w_800,c_fill,f_auto,q_80/https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b" 
                                 class="img-fluid position-relative z-1 shadow-gold rounded-4" 
                                 alt="Luxury Fine Dining"
                                 loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="quote-section section-padding bg-gold text-dark overflow-hidden position-relative" data-scroll-section>
            <div class="marquee-wrapper">
                <div class="marquee-text font-display">
                    CULINAIRE • EXCELLENCE • PASSION • TRADITION • FUTURE • 
                    CULINAIRE • EXCELLENCE • PASSION • TRADITION • FUTURE •
                </div>
            </div>
            
            <div class="container-fluid position-relative z-2 px-4 px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center">
                        <blockquote class="font-display display-4 text-dark mb-5 quote-anim" data-i18n="about_quote">
                            {{ __('messages.about_quote') }}
                        </blockquote>
                        <div class="chef-sign font-mono tracking-widest" data-i18n="about_chef">
                            {{ __('messages.about_chef') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <div style="height: 10vh;" data-scroll-section></div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const preloader = document.querySelector('.preloader');
        const counter = document.querySelector('.preloader-counter');
        const line = document.querySelector('.preloader-line');
        let width = 0;
        
        function updateLoader() {
            width += Math.random() * 5;
            if(width > 100) width = 100;
            
            counter.textContent = Math.floor(width) + '%';
            line.style.width = width + '%';
            
            if(width < 100) {
                requestAnimationFrame(updateLoader);
            } else {
                setTimeout(() => {
                    preloader.classList.add('finished');
                    document.body.classList.add('is-loaded');
                    initAnimations();
                }, 500);
            }
        }
        requestAnimationFrame(updateLoader);

        function initAnimations() {
            const heroChars = document.querySelectorAll('.recruit-char');
            heroChars.forEach((char, index) => {
                setTimeout(() => {
                    char.parentElement.parentElement.classList.add('is-visible');
                    char.style.transitionDelay = (index * 0.05) + 's';
                }, 500);
            });

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        
                        if(entry.target.querySelector('.recruit-char')) {
                            entry.target.classList.add('is-visible');
                        }
                    }
                });
            }, { threshold: 0.1 });
            

            const timelineSection = document.querySelector('.timeline-section');
            const svgPath = document.querySelector('.timeline-path');
            
            if(timelineSection && svgPath) {
                const pathLength = svgPath.getTotalLength();
                
                svgPath.style.strokeDasharray = pathLength;
                svgPath.style.strokeDashoffset = pathLength;
                
                window.addEventListener('scroll', () => {
                    const sectionTop = timelineSection.offsetTop;
                    const sectionHeight = timelineSection.offsetHeight;
                    const scrollY = window.scrollY;
                    const windowHeight = window.innerHeight;
                    
                    let percentage = (scrollY + windowHeight / 2 - sectionTop) / (sectionHeight * 0.8);
                    
                    if(percentage < 0) percentage = 0;
                    if(percentage > 1) percentage = 1;
                    
                    const drawLength = pathLength * (1 - percentage);
                    svgPath.style.strokeDashoffset = drawLength;
                });
            }
            
            document.querySelectorAll('.img-reveal-wrapper, .split-text, .reveal-type, .quote-anim, .heritage-section, .manifesto-section, .history-chapter, .timeline-item').forEach(el => observer.observe(el));
        }
    });
</script>
@endpush
