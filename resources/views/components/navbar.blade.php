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
                        <div class="dropdown" id="profileDropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 text-truncate" 
                                    type="button" id="profileDropdownBtn" aria-expanded="false" style="max-width: 200px;">
                                <i class="bi bi-person-circle"></i>
                                <span class="d-none d-md-inline text-truncate">{{ Auth::user()->name ?? 'User' }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" id="profileDropdownMenu">
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
        padding: 18px 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
        border-bottom: none;
        box-shadow: none;
        z-index: 9999 !important;
    }

    .navbar-culinaire.scrolled {
        background: rgba(255, 255, 255, 0.30);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        padding: 12px 0;
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

    .navbar-nav .nav-link {
        color: #0C2A36 !important;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: #C89B3A !important;
    }

    .lang-link {
        font-size: 0.85rem;
        font-weight: 600;
        color: rgba(12, 42, 54, 0.5);
        text-decoration: none;
        transition: color 0.12s ease;
    }

    .lang-link:hover,
    .lang-link.active-lang {
        color: #C89B3A;
    }

    .navbar-toggler i {
        color: #0C2A36;
    }

    .navbar-culinaire .dropdown {
        position: relative;
        z-index: 10000;
        overflow: visible !important;
    }

    .navbar-culinaire,
    .navbar-culinaire .container-fluid,
    .navbar-culinaire .navbar-collapse,
    .navbar-culinaire .navbar-nav {
        overflow: visible !important;
    }

    .navbar-culinaire .btn-outline-primary {
        color: #0C2A36 !important;
        border-color: rgba(12, 42, 54, 0.3) !important;
        background: rgba(255, 255, 255, 0.2);
        cursor: pointer;
        pointer-events: auto;
    }

    .navbar-culinaire .btn-outline-primary:hover {
        background: rgba(200, 155, 58, 0.2) !important;
        border-color: #C89B3A !important;
        color: #C89B3A !important;
    }

    .navbar-culinaire .dropdown-menu {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 0;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        z-index: 10001;
        position: absolute;
        min-width: 180px;
        padding: 8px 0;
    }

    .navbar-culinaire .dropdown-item {
        color: #0C2A36;
    }

    .navbar-culinaire .dropdown-item:hover {
        background: rgba(200, 155, 58, 0.15);
        color: #C89B3A;
    }

    .navbar-culinaire .dropdown-divider {
        border-color: rgba(12, 42, 54, 0.1);
    }

    .navbar-nav .nav-link {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(165deg, rgba(12, 42, 54, 0.97) 0%, rgba(8, 28, 36, 0.99) 100%);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            display: flex !important;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            padding: 2rem;
            margin: 0;
            border-radius: 0;
            border: none;
            box-shadow: none;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .navbar-collapse.show {
            opacity: 1;
            visibility: visible;
        }

        .navbar-collapse::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at 30% 20%, rgba(200, 155, 58, 0.08) 0%, transparent 50%),
                        radial-gradient(ellipse at 70% 80%, rgba(200, 155, 58, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .navbar-collapse::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            border: 1px solid rgba(200, 155, 58, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .navbar-nav {
            flex-direction: column;
            align-items: center !important;
            gap: 0.5rem !important;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .navbar-nav .nav-item {
            opacity: 0;
            transform: translateY(20px);
            animation: navItemFadeIn 0.5s ease forwards;
        }

        .navbar-collapse.show .navbar-nav .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .navbar-collapse.show .navbar-nav .nav-item:nth-child(2) { animation-delay: 0.15s; }
        .navbar-collapse.show .navbar-nav .nav-item:nth-child(3) { animation-delay: 0.2s; }
        .navbar-collapse.show .navbar-nav .nav-item:nth-child(4) { animation-delay: 0.25s; }
        .navbar-collapse.show .navbar-nav .nav-item:nth-child(5) { animation-delay: 0.3s; }
        .navbar-collapse.show .navbar-nav .nav-item:nth-child(6) { animation-delay: 0.35s; }

        @keyframes navItemFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .navbar-collapse .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-family: var(--font-heading, "Playfair Display", serif);
            font-size: 1.5rem;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 1rem 2rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar-collapse .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0.5rem;
            left: 50%;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #C89B3A, transparent);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-collapse .nav-link:hover,
        .navbar-collapse .nav-link.active {
            color: #C89B3A !important;
        }

        .navbar-collapse .nav-link:hover::after,
        .navbar-collapse .nav-link.active::after {
            width: 60%;
        }

        .nav-item.d-flex.gap-3.ms-lg-2 {
            margin-left: 0 !important;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(200, 155, 58, 0.15);
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 1.5rem !important;
            width: auto;
        }

        .navbar-collapse .lang-switch {
            background: rgba(200, 155, 58, 0.1);
            border: 1px solid rgba(200, 155, 58, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 30px;
        }

        .navbar-collapse .lang-link {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .navbar-collapse .lang-link:hover,
        .navbar-collapse .lang-link.active-lang {
            color: #C89B3A;
        }

        .navbar-collapse .theme-toggle {
            background: rgba(200, 155, 58, 0.1);
            border: 1px solid rgba(200, 155, 58, 0.2);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-collapse .btn-primary {
            background: linear-gradient(135deg, #C89B3A 0%, #D4AF5A 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(200, 155, 58, 0.3);
        }

        .navbar-collapse .btn-outline-primary {
            background: rgba(200, 155, 58, 0.1);
            border: 1px solid rgba(200, 155, 58, 0.3);
            color: #C89B3A !important;
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
        }

        .navbar-collapse .dropdown-menu {
            background: rgba(12, 42, 54, 0.95);
            border: 1px solid rgba(200, 155, 58, 0.2);
            border-radius: 12px;
        }

        .navbar-collapse .dropdown-item {
            color: rgba(255, 255, 255, 0.85);
        }

        .navbar-collapse .dropdown-item:hover {
            background: rgba(200, 155, 58, 0.15);
            color: #C89B3A;
        }

        [data-theme="dark"] .navbar-collapse {
            background: linear-gradient(165deg, rgba(11, 14, 16, 0.98) 0%, rgba(5, 7, 9, 0.99) 100%);
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

    const dropdownBtn = document.getElementById('profileDropdownBtn');
    const dropdownMenu = document.getElementById('profileDropdownMenu');
    
    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = dropdownMenu.classList.contains('show');
            dropdownMenu.classList.toggle('show');
            dropdownMenu.style.display = isOpen ? 'none' : 'block';
            this.setAttribute('aria-expanded', !isOpen);
        });

        document.addEventListener('click', function(e) {
            if (dropdownBtn && dropdownMenu && !dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                dropdownMenu.style.display = 'none';
                dropdownBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
</script>
