<nav class="navbar navbar-expand-lg navbar-culinaire fixed-top" id="mainNavbar">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand" href="{{ url('/') }}">
            Culinaire<span>.</span>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-4"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}" data-i18n="home">
                        {{ __('messages.home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('menu*') ? 'active' : '' }}" href="{{ url('/menu') }}" data-i18n="menu">
                        {{ __('messages.menu') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('reservation*') ? 'active' : '' }}" href="{{ url('/reservation') }}" data-i18n="reservation">
                        {{ __('messages.reservation') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}" data-i18n="about">
                        {{ __('messages.about') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}" data-i18n="contact">
                        {{ __('messages.contact') }}
                    </a>
                </li>

                <li class="nav-item d-flex align-items-center gap-3 ms-lg-2">
                    <div class="lang-switch d-flex align-items-center">
                        <a href="{{ route('lang.switch', 'en') }}" class="lang-link {{ app()->getLocale() == 'en' ? 'active-lang' : '' }}">EN</a>
                        <span class="mx-1 text-muted">|</span>
                        <a href="{{ route('lang.switch', 'id') }}" class="lang-link {{ app()->getLocale() == 'id' ? 'active-lang' : '' }}">ID</a>
                    </div>

                    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                        <i class="bi bi-moon-fill icon-moon"></i>
                        <i class="bi bi-sun-fill icon-sun"></i>
                    </button>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 text-truncate" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false" style="max-width: 200px;">
                                <i class="bi bi-person-circle"></i>
                                <span class="d-none d-md-inline text-truncate">{{ Auth::user()->name ?? 'User' }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li>
                                    <a class="dropdown-item" href="{{ Auth::user()->isAdmin() ? url('/admin/dashboard') : url('/dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i><span data-i18n="dashboard">{{ __('messages.dashboard') }}</span>
                                    </a>
                                </li>
                                @if(!Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ url('/customer/orders') }}">
                                        <i class="bi bi-bag me-2"></i><span data-i18n="my_orders">{{ __('messages.my_orders') }}</span>
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/customer/profile') }}">
                                        <i class="bi bi-person me-2"></i><span data-i18n="profile">{{ __('messages.profile') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') ?? '#' }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i><span data-i18n="logout">{{ __('messages.logout') }}</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') ?? url('/login') }}" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            <span data-i18n="login">{{ __('messages.login') }}</span>
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-culinaire {
        padding: 15px 0;
        transition: all 0.12s ease;
        background-color: transparent;
    }

    .navbar-culinaire.scrolled {
        background-color: #0C2A36;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 6px -1px rgba(12, 42, 54, 0.2);
        padding: 10px 0;
    }

    .navbar-culinaire.scrolled .navbar-brand {
        color: #F6F2EE !important;
    }
    
    .navbar-culinaire.scrolled .navbar-brand span {
        color: #C89B3A !important;
    }

    .navbar-culinaire.scrolled .nav-link {
        color: #F6F2EE !important;
    }

    .navbar-culinaire.scrolled .nav-link:hover,
    .navbar-culinaire.scrolled .nav-link.active {
        color: #C89B3A !important;
    }

    .navbar-culinaire.scrolled .lang-link {
        color: rgba(246, 242, 238, 0.6);
    }

    .navbar-culinaire.scrolled .lang-link:hover,
    .navbar-culinaire.scrolled .lang-link.active-lang {
        color: #C89B3A;
    }

    .navbar-culinaire.scrolled .navbar-toggler i {
        color: #F6F2EE;
    }

    .navbar-brand {
        font-family: var(--font-heading, "Playfair Display", serif);
        font-weight: 700;
        font-size: 1.75rem;
        color: #0C2A36 !important;
    }
    
    .navbar-brand span {
        color: #C89B3A !important;
    }

    .lang-link {
        font-size: 0.85rem;
        font-weight: 600;
        color: rgba(12, 42, 54, 0.5);
        text-decoration: none;
        transition: color 0.12s ease;
    }
    .lang-link:hover { color: #C89B3A; }
    .lang-link.active-lang { color: #C89B3A; }
    
    .navbar-nav .nav-link {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
        color: #0C2A36;
    }
    .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
        color: #C89B3A;
    }

    /* Dark mode navbar */
    [data-theme="dark"] .navbar-brand {
        color: #E6EFEF !important;
    }
    
    [data-theme="dark"] .navbar-brand span {
        color: #D4AF37 !important;
    }

    [data-theme="dark"] .navbar-nav .nav-link {
        color: #E6EFEF;
    }

    [data-theme="dark"] .navbar-nav .nav-link:hover,
    [data-theme="dark"] .navbar-nav .nav-link.active {
        color: #D4AF37;
    }

    [data-theme="dark"] .lang-link {
        color: rgba(230, 239, 239, 0.5);
    }

    [data-theme="dark"] .lang-link:hover,
    [data-theme="dark"] .lang-link.active-lang {
        color: #D4AF37;
    }

    [data-theme="dark"] .navbar-culinaire.scrolled {
        background-color: #16252B;
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background-color: #0C2A36;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
            box-shadow: 0 10px 30px rgba(12, 42, 54, 0.3);
            position: absolute;
            top: 100%;
            left: 15px;
            right: 15px;
            border: 1px solid rgba(200, 155, 58, 0.2);
        }

        .navbar-collapse .nav-link {
            color: #F6F2EE !important;
        }

        .navbar-collapse .nav-link:hover,
        .navbar-collapse .nav-link.active {
            color: #C89B3A !important;
        }

        .navbar-collapse .lang-link {
            color: rgba(246, 242, 238, 0.6);
        }

        .navbar-collapse .lang-link:hover,
        .navbar-collapse .lang-link.active-lang {
            color: #C89B3A;
        }
        
        .navbar-nav {
            gap: 15px !important;
            align-items: center !important;
            text-align: center;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
            padding: 10px 0;
            display: block;
        }

        .nav-item.d-flex.gap-3.ms-2 {
            margin-left: 0 !important;
            margin-top: 20px;
            flex-direction: column;
            width: 100%;
            gap: 1rem !important;
        }

        .lang-switch {
            justify-content: center;
            width: 100%;
            margin-bottom: 15px;
        }

        .btn-primary, .btn-outline-primary {
            width: 100%;
            justify-content: center;
        }

        .theme-toggle {
            margin: 0 auto;
        }

        [data-theme="dark"] .navbar-collapse {
            background-color: #16252B;
            border-color: rgba(212, 175, 55, 0.2);
        }
    }
</style>

<div style="height: 80px;"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const langLinks = document.querySelectorAll('.lang-link');
    
    langLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetLang = this.textContent.trim().toLowerCase();
            
            if (window.translations && window.translations[targetLang]) {
                const terms = window.translations[targetLang];
                
                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (terms[key]) {
                        el.style.opacity = '0.5';
                        setTimeout(() => {
                            if((el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') && el.getAttribute('placeholder')) {
                                el.placeholder = terms[key];
                            } else {
                                el.innerHTML = terms[key]; 
                            }
                            el.style.opacity = '1';
                        }, 50);
                    }
                });

                document.querySelectorAll('.lang-link').forEach(l => l.classList.remove('active-lang'));
                this.classList.add('active-lang');
                
                document.documentElement.lang = targetLang === 'id' ? 'id-ID' : 'en-US';
            }

            fetch(this.href).catch(err => console.error('Background session sync failed', err));
        });
    });
});
</script>
