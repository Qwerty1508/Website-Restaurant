<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ __('messages.meta_desc') }}">
    <meta name="keywords" content="restaurant, culinary, Indonesian food, fine dining, reservasi, kuliner">
    
    <title>@yield('title', 'Culinaire') - {{ config('app.name', __('messages.premium_restaurant')) }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"></noscript>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    
    @stack('styles')
    
    <script>
        window.translations = {
            en: @json(include(base_path('lang/en/messages.php'))),
            id: @json(include(base_path('lang/id/messages.php')))
        };
        window.currentLocale = "{{ app()->getLocale() }}";
    </script>
</head>
<body>
    @include('components.navbar')
    
    <main>
        @if(session('warning'))
            <div class="modal fade" id="warningModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 650px;">
                    <div class="modal-content border-0 bg-transparent" style="overflow: visible !important; box-shadow: none !important;">
                        <div class="position-relative text-center d-flex justify-content-center">
                            
                            <img src="https://res.cloudinary.com/dh9ysyfit/image/upload/v1765978302/IMG_7839_loero4.png" 
                                 alt="Peringatan Akun" 
                                 class="img-fluid drop-shadow-xl" 
                                 style="border-radius: 0; max-height: 90vh; object-fit: contain; pointer-events: none; -webkit-user-drag: none; user-select: none;"
                                 draggable="false"
                                 oncontextmenu="return false;">
                            
                            <button type="button" class="btn-royal-click-area" data-bs-dismiss="modal" aria-label="Saya Mengerti"></button>
                            
                        </div>
                    </div>
                </div>
            </div>

            <style>
               .btn-royal-click-area {
                   position: absolute;
                   bottom: 10%; 
                   left: 50%;
                   transform: translateX(-50%);
                   width: 35%;
                   height: 12%;
                   background: transparent;
                   border: none;
                   cursor: pointer;
                   border-radius: 50px;
                   z-index: 10;
               }

               .btn-royal-click-area:hover {
                   background: rgba(255, 255, 255, 0.1);
                   box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
               }
               
               .drop-shadow-xl {
                   filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
               }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
                    var backdrop = document.createElement('div');
                    warningModal.show();
                });
            </script>
        @endif
        
        @yield('content')
    </main>
    
    @include('components.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;
        
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-theme', savedTheme);
        
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                htmlElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });
        }
        
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar-culinaire');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });
    </script>
    
    <script src="{{ asset('js/cursor.js') }}"></script>
    <script src="{{ asset('js/performance-core.js') }}"></script>
    <script>
        // Ultimate UI Protection
        document.addEventListener('dragstart', e => e.preventDefault());
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('selectstart', e => e.preventDefault());
        
        document.addEventListener('keydown', function(e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
                (e.ctrlKey && e.key === 'U') ||
                (e.ctrlKey && e.key === 'S')
            ) {
                e.preventDefault();
                return false;
            }
        });

        // --- SMART RESOURCE PRELOADER INTEGRATION ---
        window.addEventListener('load', () => {
             // Let the Optimizer handle these heavy assets intelligently
            const heavyAssets = [
                'https://res.cloudinary.com/dh9ysyfit/image/fetch/w_1920,c_fill,f_auto,q_auto/https://images.unsplash.com/photo-1505935428862-770b6f24f629',
                'https://res.cloudinary.com/dh9ysyfit/image/fetch/w_800,c_fill,f_auto,q_80/https://images.unsplash.com/photo-1516455590571-18256e5bb9ff',
                'https://res.cloudinary.com/dh9ysyfit/image/fetch/w_800,c_fill,f_auto,q_80/https://images.unsplash.com/photo-1559339352-11d035aa65de',
                'https://res.cloudinary.com/dh9ysyfit/image/fetch/w_800,c_fill,f_auto,q_80/https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b',
                // Common Placeholders
                'https://res.cloudinary.com/dh9ysyfit/image/fetch/w_400,h_300,c_fill,f_auto,q_auto/https://images.unsplash.com/photo-1546069901-ba9599a7e63c'
            ];

            // Helper to fetch image in background
            const prefetchImage = (url) => {
                return new Promise((resolve) => {
                    const img = new Image();
                    img.src = url;
                    // Low priority decode
                    img.decoding = 'async'; 
                    img.onload = resolve;
                    img.onerror = resolve; // Continue even if fail
                });
            };

            const runSmartPreload = async () => {
                // Wait 2 seconds for main page to settle interactive state
                await new Promise(r => setTimeout(r, 2000));
                
                // Fetch sequentially (One by one) to prevent CPU spikes/Heat
                for(const url of heavyAssets) {
                    await prefetchImage(url);
                    // Small breathing room between fetches
                    await new Promise(r => setTimeout(r, 200)); 
                }
                console.log('Site assets preloaded in background.');
            };

            // Use requestIdleCallback if available for maximum efficiency
            if ('requestIdleCallback' in window) {
                requestIdleCallback(runSmartPreload);
            } else {
                runSmartPreload();
            }
        });
    </script>
    @stack('scripts')
    
    @if(request()->has('cms_mode') || session('cms_mode'))
        <script src="{{ asset('js/cms-iframe.js') }}"></script>
    @endif
</body>
</html>
