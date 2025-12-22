@extends('layouts.guest')
@section('title', 'Daftar')
@section('content')
<section class="min-vh-100 d-flex align-items-center bg-cream py-5">
    <div class="container">
        <div class="row g-0 justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-xl overflow-hidden" style="border-radius: 1.5rem;">
                    <div class="row g-0">
                        <div class="col-lg-6 order-lg-1 order-2">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <a href="{{ url('/') }}" class="text-decoration-none">
                                        <h3 class="font-heading text-burgundy mb-2">
                                            Culinaire<span class="text-gold">.</span>
                                        </h3>
                                    </a>
                                    <p class="text-muted" data-i18n="create_account">{{ __('messages.create_account') }}</p>
                                </div>
                                <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary w-100 py-3 mb-4 d-flex align-items-center justify-content-center gap-2">
                                    <svg width="20" height="20" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                    <span data-i18n="register_with_google">{{ __('messages.register_with_google') }}</span>
                                </a>
                                <div class="text-center my-4 position-relative">
                                    <hr class="my-0">
                                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small" data-i18n="register_with_email">
                                        {{ __('messages.register_with_email') }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('register') ?? '#' }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label" data-i18n="full_name">{{ __('messages.full_name') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-person text-muted"></i>
                                                </span>
                                                <input type="text" 
                                                       class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                                       id="name" 
                                                       name="name" 
                                                       value="{{ old('name') }}"
                                                       placeholder="{{ __('messages.name_placeholder') }}" data-i18n="name_placeholder"
                                                       required>
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label" data-i18n="phone_number">{{ __('messages.phone_number') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-phone text-muted"></i>
                                                </span>
                                                <input type="tel" 
                                                       class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" 
                                                       id="phone" 
                                                       name="phone" 
                                                       value="{{ old('phone') }}"
                                                       placeholder="{{ __('messages.phone_placeholder') }}" data-i18n="phone_placeholder">
                                            </div>
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label" data-i18n="email">{{ __('messages.email') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope text-muted"></i>
                                            </span>
                                            <input type="email" 
                                                   class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email') }}"
                                                   placeholder="{{ __('messages.email_placeholder') }}" data-i18n="email_placeholder"
                                                   required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label" data-i18n="password">{{ __('messages.password') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-lock text-muted"></i>
                                                </span>
                                                <input type="password" 
                                                       class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror" 
                                                       id="password" 
                                                       name="password" 
                                                       placeholder="{{ __('messages.password_min_placeholder') }}" data-i18n="password_min_placeholder"
                                                       required>
                                                <button class="input-group-text bg-light border-start-0" type="button" id="togglePassword">
                                                    <i class="bi bi-eye text-muted"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label" data-i18n="confirm_password">{{ __('messages.confirm_password') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-lock-fill text-muted"></i>
                                                </span>
                                                <input type="password" 
                                                       class="form-control border-start-0 ps-0" 
                                                       id="password_confirmation" 
                                                       name="password_confirmation" 
                                                       placeholder="{{ __('messages.password_repeat_placeholder') }}" data-i18n="password_repeat_placeholder"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input @error('terms') is-invalid @enderror" 
                                                   type="checkbox" 
                                                   name="terms" 
                                                   id="terms" 
                                                   required>
                                            <label class="form-check-label text-muted small" for="terms">
                                                <span data-i18n="i_agree">{{ __('messages.i_agree') }}</span> 
                                                <a href="#" class="text-primary" data-i18n="terms_conditions">{{ __('messages.terms_conditions') }}</a> <span data-i18n="and">{{ __('messages.and') }}</span> 
                                                <a href="#" class="text-primary" data-i18n="privacy_policy">{{ __('messages.privacy_policy') }}</a>
                                            </label>
                                        </div>
                                        @error('terms')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                                        <i class="bi bi-person-plus me-2"></i><span data-i18n="register_now">{{ __('messages.register_now') }}</span>
                                    </button>
                                </form>
                                <p class="text-center text-muted mb-0">
                                    <span data-i18n="already_have_account">{{ __('messages.already_have_account') }}</span> 
                                    <a href="{{ route('login') ?? url('/login') }}" class="text-primary fw-semibold" data-i18n="login">
                                        {{ __('messages.login') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-2 order-1 d-none d-lg-block">
                            <div class="h-100 position-relative" 
                                 style="background: linear-gradient(135deg, rgba(12, 42, 54, 0.95), rgba(12, 42, 54, 0.85)), 
                                        url('https://res.cloudinary.com/dh9ysyfit/image/fetch/w_800,h_1000,c_fill,f_auto,q_auto/https://images.unsplash.com/photo-1552566626-52f8b828add9') center/cover;">
                                <div class="p-5 d-flex flex-column justify-content-center h-100 text-white">
                                    <h2 class="display-6 fw-bold text-white mb-4" data-i18n="join_us">
                                        {{ __('messages.join_us') }}
                                    </h2>
                                    <p class="lead opacity-75 mb-4" data-i18n="join_desc">
                                        {{ __('messages.join_desc') }}
                                    </p>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="glass-effect rounded-3 p-3 text-center">
                                                <i class="bi bi-percent fs-2 mb-2 d-block" style="color: #C89B3A;"></i>
                                                <small data-i18n="member_discount">{{ __('messages.member_discount') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="glass-effect rounded-3 p-3 text-center">
                                                <i class="bi bi-gift fs-2 mb-2 d-block" style="color: #C89B3A;"></i>
                                                <small data-i18n="special_promo">{{ __('messages.special_promo') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="glass-effect rounded-3 p-3 text-center">
                                                <i class="bi bi-star fs-2 mb-2 d-block" style="color: #C89B3A;"></i>
                                                <small data-i18n="reward_points">{{ __('messages.reward_points') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="glass-effect rounded-3 p-3 text-center">
                                                <i class="bi bi-calendar-heart fs-2 mb-2 d-block" style="color: #C89B3A;"></i>
                                                <small data-i18n="priority_booking">{{ __('messages.priority_booking') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    }
</script>
@endpush