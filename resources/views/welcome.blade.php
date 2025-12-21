@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
<section class="hero-section" id="home">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row align-items-center min-vh-100 py-5">
            <div class="col-lg-8 hero-content">
                <span class="badge bg-gradient-secondary text-dark mb-3 px-3 py-2 rounded-pill animate-fadeInUp">
                    <i class="bi bi-star-fill me-1"></i> <span data-i18n="hero_subtitle">{{ __('messages.hero_subtitle') }}</span>
                </span>
                <!-- Typing Animation Containers -->
                <h1 class="hero-title animate-fadeInUp delay-1 text-white min-h-title" aria-label="{{ __('messages.hero_title_1') }} {{ __('messages.hero_title_2') }} {{ __('messages.hero_title_3') }}">
                    <span id="typing-title" 
                          data-segments='[
                              {"text": "{{ __('messages.hero_title_1') }} ", "class": ""},
                              {"text": "{{ __('messages.hero_title_2') }} ", "class": ""},
                              {"text": "{{ __('messages.hero_title_3') }}", "class": "highlight"}
                          ]'></span><span class="typing-cursor">|</span>
                </h1>
                
                <p class="hero-subtitle animate-fadeInUp delay-2 text-light opacity-75 min-h-subtitle">
                    <span id="typing-subtitle" data-text="{{ __('messages.hero_desc') }}"></span><span class="typing-cursor" id="subtitle-cursor" style="display:none;">|</span>
                </p>
                <div class="hero-actions animate-fadeInUp delay-3">
                    <a href="{{ url('/menu') }}" class="btn btn-lg rounded-pill px-5 me-3 shadow-lg btn-glass-gold">
                        <i class="bi bi-book me-2"></i><span data-i18n="explore_menu">{{ __('messages.explore_menu') }}</span>
                    </a>
                    
                    <a href="{{ url('/reservation') }}" class="btn btn-lg rounded-pill px-5 shadow-sm btn-glass-light">
                        <i class="bi bi-calendar-check me-2"></i><span data-i18n="reservation">{{ __('messages.reservation') }}</span>
                    </a>
                </div>
                
                <div class="row mt-5 animate-fadeInUp delay-4">
                    <div class="col-4">
                        <h3 class="text-gold mb-0 display-6 fw-bold">50+</h3>
                        <small class="text-white-50 text-uppercase fw-semibold" style="letter-spacing: 1px;" data-i18n="menu_choice">{{ __('messages.menu_choice') }}</small>
                    </div>
                    <div class="col-4">
                        <h3 class="text-gold mb-0 display-6 fw-bold">10K+</h3>
                        <small class="text-white-50 text-uppercase fw-semibold" style="letter-spacing: 1px;" data-i18n="customers">{{ __('messages.customers') }}</small>
                    </div>
                    <div class="col-4">
                        <h3 class="text-gold mb-0 display-6 fw-bold">4.9</h3>
                        <small class="text-white-50 text-uppercase fw-semibold" style="letter-spacing: 1px;" data-i18n="rating">{{ __('messages.rating') }}</small>
                    </div>
                </div>
            </div>
            

    </div>
    
    <div class="position-absolute" style="top: 20%; left: 5%; opacity: 0.1;">
        <i class="bi bi-flower1 display-1 text-gold"></i>
    </div>
    <div class="position-absolute" style="bottom: 20%; right: 5%; opacity: 0.1;">
        <i class="bi bi-flower2 display-1 text-gold"></i>
    </div>
</section>

<section class="section bg-white" id="trending">
    <div class="container">
        <div class="section-title">
            <span class="badge bg-gradient-primary text-white mb-3 px-3 py-2 rounded-pill">
                <i class="bi bi-lightning-fill me-1"></i> AI Recommended
            </span>
            <h2><span data-i18n="best_selling_title">{{ __('messages.best_selling_title') }}</span></h2>
            <p class="subtitle" data-i18n="best_selling_desc">{{ __('messages.best_selling_desc') }}</p>
            <div class="divider"></div>
        </div>
        
        <div class="row g-4">
            @forelse($featuredMenus as $index => $menu)
            <div class="col-lg-4 col-md-6">
                <div class="card menu-card h-100">
                    <div class="position-relative">
                        @if($menu->image_url)
                            <img src="{{ $menu->image_url }}" 
                                 class="card-img-top" alt="{{ $menu->name }}" style="height: 250px; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='https://res.cloudinary.com/dh9ysyfit/image/fetch/w_400,h_300,c_fill,f_auto,q_auto/https://images.unsplash.com/photo-1546069901-ba9599a7e63c';">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <i class="bi bi-image fs-1 text-muted"></i>
                            </div>
                        @endif
                        @if($index == 0)
                        <span class="trending-badge">
                            <i class="bi bi-fire"></i> <span data-i18n="trending_1">{{ __('messages.trending_1') }}</span>
                        </span>
                        @elseif($index == 1)
                        <span class="trending-badge" style="background: linear-gradient(135deg, #C89B3A 0%, #B07F23 100%); color: #0B0B0B;">
                            <i class="bi bi-trophy-fill"></i> <span data-i18n="popular_2">{{ __('messages.popular_2') }}</span>
                        </span>
                        @else
                        <span class="trending-badge" style="background: linear-gradient(135deg, #198754 0%, #0d5c38 100%);">
                            <i class="bi bi-graph-up-arrow"></i> <span data-i18n="rising_3">{{ __('messages.rising_3') }}</span>
                        </span>
                        @endif
                        <span class="price-tag">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $menu->name }}</h5>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill filled"></i>
                                <span class="ms-1">{{ number_format(4.5 + (rand(0, 4) / 10), 1) }}</span>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">
                            {{ Str::limit($menu->description, 80) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-bag-check me-1"></i> {{ rand(100, 250) }} <span data-i18n="sold_today">{{ __('messages.sold_today') }}</span>
                            </small>
                            <a href="{{ url('/menu') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus"></i> <span data-i18n="order_btn">{{ __('messages.order_btn') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada menu tersedia</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ url('/menu') }}" class="btn btn-primary btn-lg">
                <span data-i18n="see_all_menu">{{ __('messages.see_all_menu') }}</span> <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="section bg-cream">
    <div class="container">
        <div class="section-title">
            <h2 data-i18n="why_choose_us">{{ __('messages.why_choose_us') }}</h2>
            <p class="subtitle" data-i18n="why_choose_desc">{{ __('messages.why_choose_desc') }}</p>
            <div class="divider"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card card-glass h-100 text-center p-4 hover-lift">
                    <div class="mb-3">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 70px; height: 70px;">
                            <i class="bi bi-award text-white fs-3"></i>
                        </div>
                    </div>
                    <h5 data-i18n="feature_1_title">{{ __('messages.feature_1_title') }}</h5>
                    <p class="text-muted small mb-0" data-i18n="feature_1_desc">
                        {{ __('messages.feature_1_desc') }}
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-glass h-100 text-center p-4 hover-lift">
                    <div class="mb-3">
                        <div class="bg-gradient-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 70px; height: 70px;">
                            <i class="bi bi-person-check fs-3"></i>
                        </div>
                    </div>
                    <h5 data-i18n="feature_2_title">{{ __('messages.feature_2_title') }}</h5>
                    <p class="text-muted small mb-0" data-i18n="feature_2_desc">
                        {{ __('messages.feature_2_desc') }}
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-glass h-100 text-center p-4 hover-lift">
                    <div class="mb-3">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 70px; height: 70px;">
                            <i class="bi bi-lightning-charge text-white fs-3"></i>
                        </div>
                    </div>
                    <h5 data-i18n="feature_3_title">{{ __('messages.feature_3_title') }}</h5>
                    <p class="text-muted small mb-0" data-i18n="feature_3_desc">
                        {{ __('messages.feature_3_desc') }}
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card card-glass h-100 text-center p-4 hover-lift">
                    <div class="mb-3">
                        <div class="bg-gradient-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-check fs-3"></i>
                        </div>
                    </div>
                    <h5 data-i18n="feature_4_title">{{ __('messages.feature_4_title') }}</h5>
                    <p class="text-muted small mb-0" data-i18n="feature_4_desc">
                        {{ __('messages.feature_4_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-white" id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative overflow-hidden rounded-4">
                    <video autoplay loop muted playsinline class="img-fluid rounded-4 shadow-lg" style="width: 100%; object-fit: cover;">
                        <source src="https://res.cloudinary.com/dh9ysyfit/video/upload/v1766171775/gemini_generated_video_1C6E4459_ge0iic.mov" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    
                    <div class="position-absolute glass-badge text-white rounded-4 p-4 shadow-lg" 
                         style="bottom: 20px; right: 20px;">
                        <h2 class="mb-0">15+</h2>
                        <small data-i18n="years_experience">{{ __('messages.years_experience') }}</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <span class="badge bg-gradient-secondary text-dark mb-3 px-3 py-2 rounded-pill">
                    <i class="bi bi-info-circle me-1"></i> <span data-i18n="about">{{ __('messages.about') }}</span>
                </span>
                <h2 class="mb-4" data-i18n="about_journey_title">{{ __('messages.about_journey_title') }}</h2>
                <p class="text-muted mb-4" data-i18n="about_journey_desc">
                    {{ __('messages.about_journey_desc') }}
                </p>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-3">
                        <i class="bi bi-check-circle-fill text-gold fs-5 me-3"></i>
                        <span data-i18n="about_point_1">{{ __('messages.about_point_1') }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bi bi-check-circle-fill text-gold fs-5 me-3"></i>
                        <span data-i18n="about_point_2">{{ __('messages.about_point_2') }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bi bi-check-circle-fill text-gold fs-5 me-3"></i>
                        <span data-i18n="about_point_3">{{ __('messages.about_point_3') }}</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-gold fs-5 me-3"></i>
                        <span data-i18n="about_point_4">{{ __('messages.about_point_4') }}</span>
                    </li>
                </ul>
                
                <a href="#contact" class="btn btn-primary btn-lg mt-3">
                    <i class="bi bi-telephone me-2"></i><span data-i18n="contact_us">{{ __('messages.contact_us') }}</span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section bg-brown text-white">
    <div class="container">
        <div class="section-title">
            <h2 class="text-white" data-i18n="how_to_order">{{ __('messages.how_to_order') }}</h2>
            <p class="subtitle text-light opacity-75" data-i18n="how_to_order_desc">{{ __('messages.how_to_order_desc') }}</p>
            <div class="divider"></div>
        </div>
        
        <div class="row g-4 luxury-scroll-container">
            <!-- Step 1 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="luxury-card-wrapper h-100">
                    <div class="luxury-card-border"></div>
                    <div class="luxury-card-glow"></div>
                    <div class="luxury-card-content p-4">
                        <div class="icon-stage mb-4">
                            <div class="golden-ring"></div>
                            <div class="icon-gem">
                                <i class="bi bi-person-plus fs-2 text-dark"></i>
                            </div>
                            <div class="floating-badge">1</div>
                        </div>
                        <h5 class="luxury-title mb-2" data-i18n="step_1_title">{{ __('messages.step_1_title') }}</h5>
                        <p class="luxury-desc small mb-0" data-i18n="step_1_desc">
                            {{ __('messages.step_1_desc') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="luxury-card-wrapper h-100">
                    <div class="luxury-card-border"></div>
                    <div class="luxury-card-glow"></div>
                    <div class="luxury-card-content p-4">
                        <div class="icon-stage mb-4 delay-1">
                            <div class="golden-ring"></div>
                            <div class="icon-gem">
                                <i class="bi bi-menu-button-wide fs-2 text-dark"></i>
                            </div>
                            <div class="floating-badge">2</div>
                        </div>
                        <h5 class="luxury-title mb-2" data-i18n="step_2_title">{{ __('messages.step_2_title') }}</h5>
                        <p class="luxury-desc small mb-0" data-i18n="step_2_desc">
                            {{ __('messages.step_2_desc') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="luxury-card-wrapper h-100">
                    <div class="luxury-card-border"></div>
                    <div class="luxury-card-glow"></div>
                    <div class="luxury-card-content p-4">
                        <div class="icon-stage mb-4 delay-2">
                            <div class="golden-ring"></div>
                            <div class="icon-gem">
                                <i class="bi bi-credit-card fs-2 text-dark"></i>
                            </div>
                            <div class="floating-badge">3</div>
                        </div>
                        <h5 class="luxury-title mb-2" data-i18n="step_3_title">{{ __('messages.step_3_title') }}</h5>
                        <p class="luxury-desc small mb-0" data-i18n="step_3_desc">
                            {{ __('messages.step_3_desc') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Step 4 -->
            <div class="col-lg-3 col-md-6 text-center">
                <div class="luxury-card-wrapper h-100">
                    <div class="luxury-card-border"></div>
                    <div class="luxury-card-glow"></div>
                    <div class="luxury-card-content p-4">
                        <div class="icon-stage mb-4 delay-3">
                            <div class="golden-ring"></div>
                            <div class="icon-gem">
                                <i class="bi bi-bag-check fs-2 text-dark"></i>
                            </div>
                            <div class="floating-badge">4</div>
                        </div>
                        <h5 class="luxury-title mb-2" data-i18n="step_4_title">{{ __('messages.step_4_title') }}</h5>
                        <p class="luxury-desc small mb-0" data-i18n="step_4_desc">
                            {{ __('messages.step_4_desc') }}
                        </p>
                    </div>
                </div>
            </div>
    </div>
</section>

<section class="section luxury-testimonials">
    <div class="container">
        <div class="section-title text-center mb-5">
            <span class="luxury-badge-sm">
                <i class="bi bi-star-fill"></i>
                <span data-i18n="testimonials_desc">{{ __('messages.testimonials_desc') }}</span>
            </span>
            <h2 class="luxury-section-title mt-3" data-i18n="testimonials_title">{{ __('messages.testimonials_title') }}</h2>
            <div class="luxury-divider mx-auto mt-4"></div>
        </div>
        
        <div class="luxury-testimonial-container">
            <div class="luxury-testimonial-card">
                <div class="testimonial-quote-icon">
                    <i class="bi bi-quote"></i>
                </div>
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text" data-i18n="testimonial_1">{{ __('messages.testimonial_1') }}</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/100?img=1" alt="Sarah Wijaya">
                    </div>
                    <div class="author-info">
                        <h5>Sarah Wijaya</h5>
                        <span data-i18n="cust_loyal">{{ __('messages.cust_loyal') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="luxury-testimonial-card">
                <div class="testimonial-quote-icon">
                    <i class="bi bi-quote"></i>
                </div>
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text" data-i18n="testimonial_2">{{ __('messages.testimonial_2') }}</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/100?img=3" alt="Budi Santoso">
                    </div>
                    <div class="author-info">
                        <h5>Budi Santoso</h5>
                        <span data-i18n="cust_blogger">{{ __('messages.cust_blogger') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="luxury-testimonial-card">
                <div class="testimonial-quote-icon">
                    <i class="bi bi-quote"></i>
                </div>
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                </div>
                <p class="testimonial-text" data-i18n="testimonial_3">{{ __('messages.testimonial_3') }}</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/100?img=5" alt="Andi Pratama">
                    </div>
                    <div class="author-info">
                        <h5>Andi Pratama</h5>
                        <span data-i18n="cust_regular">{{ __('messages.cust_regular') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="luxury-testimonial-card">
                <div class="testimonial-quote-icon">
                    <i class="bi bi-quote"></i>
                </div>
                <div class="testimonial-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text" data-i18n="testimonial_4">{{ __('messages.testimonial_4') }}</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/100?img=9" alt="Diana Kusuma">
                    </div>
                    <div class="author-info">
                        <h5>Diana Kusuma</h5>
                        <span data-i18n="cust_executive">{{ __('messages.cust_executive') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-gradient-primary text-white text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-3" data-i18n="cta_ready_title">{{ __('messages.cta_ready_title') }}</h2>
                <p class="text-light opacity-75 mb-4" data-i18n="cta_ready_desc">
                    {{ __('messages.cta_ready_desc') }}
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ url('/reservation') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-calendar-plus me-2"></i><span data-i18n="reserve_now">{{ __('messages.reserve_now') }}</span>
                    </a>
                    <a href="{{ url('/menu') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-book me-2"></i><span data-i18n="see_menu">{{ __('messages.see_menu') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="preload" as="image" href="https://res.cloudinary.com/dh9ysyfit/image/upload/v1766046687/IMG_7856_esb0xz.jpg">
<style>
    .hero-section {
        padding-top: 0;
        margin-top: -80px;
        background-image: linear-gradient(to right, rgba(12, 42, 54, 0.92) 0%, rgba(12, 42, 54, 0.7) 50%, rgba(12, 42, 54, 0.22) 100%), url('https://res.cloudinary.com/dh9ysyfit/image/upload/v1766046687/IMG_7856_esb0xz.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .hero-section .container {
        padding-top: 80px;
    }

    /* Navbar transparent state on hero */
    .navbar-culinaire:not(.scrolled) .nav-link,
    .navbar-culinaire:not(.scrolled) .navbar-brand {
        color: #F6F2EE !important;
    }
    .navbar-culinaire:not(.scrolled) .navbar-brand span {
        color: #C89B3A !important;
    }
    .navbar-culinaire:not(.scrolled) .btn-outline-primary {
        color: #F6F2EE !important;
        border-color: #F6F2EE !important;
    }
    .navbar-culinaire:not(.scrolled) .btn-outline-primary:hover {
        background-color: #F6F2EE !important;
        color: #0C2A36 !important;
    }
    .navbar-culinaire:not(.scrolled) .lang-link {
        color: rgba(246, 242, 238, 0.6);
    }
    .navbar-culinaire:not(.scrolled) .lang-link:hover,
    .navbar-culinaire:not(.scrolled) .lang-link.active-lang {
        color: #C89B3A;
    }
    .navbar-culinaire:not(.scrolled) .navbar-toggler i {
        color: #F6F2EE;
    }

    .highlight {
        color: #C89B3A !important;
        text-shadow: 0 2px 4px rgba(12, 42, 54, 0.5);
    }
    
    .hero-title {
        text-shadow: 0 2px 10px rgba(12, 42, 54, 0.5);
    }

    /* Glass buttons with Metallic Gold accent */
    .btn-glass-gold {
        background: rgba(200, 155, 58, 0.25) !important;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(200, 155, 58, 0.4) !important;
        color: #C89B3A !important;
        transition: all 0.12s ease;
    }
    
    .btn-glass-gold:hover {
        background: rgba(200, 155, 58, 0.5) !important;
        color: #F6F2EE !important;
        box-shadow: 0 8px 32px rgba(200, 155, 58, 0.3);
    }

    .btn-glass-light {
        background: rgba(246, 242, 238, 0.2) !important;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(246, 242, 238, 0.25) !important;
        color: #F6F2EE !important;
        transition: all 0.12s ease;
    }
    
    .btn-glass-light:hover {
        background: rgba(246, 242, 238, 0.4) !important;
        color: #0C2A36 !important;
        box-shadow: 0 8px 32px rgba(246, 242, 238, 0.2);
    }

    /* Text gold utility */
    .text-gold {
        color: #C89B3A !important;
    }

    [data-theme="dark"] .text-gold {
        color: #D4AF37 !important;
    }

    /* Luxury Typing Styles - Ethereal Edition */
    .typing-cursor {
        display: inline-block;
        width: 1px; /* Thinner for elegance */
        background-color: #C89B3A;
        animation: smoothBlink 1.5s ease-in-out infinite; /* Slower breath */
        margin-left: 2px;
        vertical-align: text-bottom;
        height: 1.2em;
        opacity: 0.6;
        box-shadow: 0 0 5px rgba(200, 155, 58, 0.5); /* Subtle glow */
    }
    
    .char-reveal {
        display: inline-block;
        opacity: 0;
        animation: etherealReveal 1.2s cubic-bezier(0.19, 1, 0.22, 1) forwards;
        white-space: pre; 
        will-change: transform, opacity, filter;
    }
    
    @keyframes etherealReveal {
        0% { 
            opacity: 0; 
            transform: translateY(12px) scale(0.95); 
            filter: blur(8px); 
        }
        20% {
            opacity: 1;
        }
        100% { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
            filter: blur(0); 
        }
    }

    @keyframes smoothBlink {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 0.8; }
    }
    
    .min-h-title { min-height: 1.2em; }
    .min-h-subtitle { min-height: 3em; }

</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleContainer = document.getElementById('typing-title');
        const subtitleContainer = document.getElementById('typing-subtitle');
        const subtitleCursor = document.getElementById('subtitle-cursor');
        
        // Luxury Configuration - "Elegance takes time"
        const baseSpeed = 90; // Slower, more confident
        const variance = 40; // More natural variance
        const startDelay = 800; // Let the page breathe first
        
        try {
            const titleSegments = JSON.parse(titleContainer.dataset.segments);
            const subtitleText = subtitleContainer.dataset.text;
            
            // Clear
            titleContainer.innerHTML = '';
            subtitleContainer.innerHTML = '';
            
            setTimeout(() => processTitleSegments(0), startDelay);
            
            function processTitleSegments(index) {
                if (index >= titleSegments.length) {
                    // Transition to subtitle
                    const tCursor = document.querySelector('.hero-title .typing-cursor');
                    if(tCursor) tCursor.style.opacity = '0';
                    setTimeout(() => {
                         if(tCursor) tCursor.style.display = 'none';
                         if(subtitleCursor) {
                             subtitleCursor.style.display = 'inline-block';
                             typeString(subtitleContainer, subtitleText, 0, () => {
                                 // Vanish immediately
                                 subtitleCursor.style.display = 'none';
                             });
                         }
                    }, 800);
                    return;
                }
                
                const segment = titleSegments[index];
                const span = document.createElement('span');
                if (segment.class) span.className = segment.class;
                titleContainer.appendChild(span);
                
                typeString(span, segment.text, 0, () => {
                    setTimeout(() => processTitleSegments(index + 1), 100);
                });
            }
            
            function typeString(container, text, index, callback) {
                if (index >= text.length) {
                     callback();
                     return;
                }
                
                const char = text.charAt(index);
                const charSpan = document.createElement('span');
                charSpan.textContent = char;
                charSpan.classList.add('char-reveal');
                container.appendChild(charSpan);
                
                // Humanize timing - Slower = More Luxury
                let delay = baseSpeed + (Math.random() * variance * 2 - variance);
                
                // Pause gracefully on punctuation
                if (char === ',' || char === '.') delay += 300;
                if (char === ' ') delay += 30; // Slight micro-pause between words
                
                setTimeout(() => {
                    typeString(container, text, index + 1, callback);
                }, delay);
            }
            
        } catch (e) {
            console.error(e);
            titleContainer.innerHTML = titleContainer.ariaLabel;
            subtitleContainer.innerHTML = subtitleContainer.dataset.text;
        }
    });
</script>
@endpush

