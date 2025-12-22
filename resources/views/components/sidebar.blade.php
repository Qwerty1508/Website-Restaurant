<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ url('/admin') }}" class="text-decoration-none">
            Culinaire<span>.</span>
            <small class="d-block text-light opacity-50 fw-normal" style="font-size: 0.75rem;">Admin Panel</small>
        </a>
    </div>
    
    <nav>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/dashboard') }}" class="sidebar-nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item mt-4">
                <small class="text-uppercase text-light opacity-50 px-3 mb-2 d-block" style="font-size: 0.7rem;">
                    Manajemen Menu
                </small>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/menus') }}" class="sidebar-nav-link {{ request()->is('admin/menus*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span>Daftar Menu</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/categories') }}" class="sidebar-nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/inventory') }}" class="sidebar-nav-link {{ request()->is('admin/inventory*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Stok Harian</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item mt-4">
                <small class="text-uppercase text-light opacity-50 px-3 mb-2 d-block" style="font-size: 0.7rem;">
                    Pesanan & Reservasi
                </small>
            </li>
            
            <li class="sidebar-nav-item">
                @php $pendingOrders = \DB::table('orders')->where('status', 'pending')->count(); @endphp
                <a href="{{ url('/admin/orders') }}" class="sidebar-nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <i class="bi bi-bag"></i>
                    <span>Pesanan</span>
                    @if($pendingOrders > 0)
                    <span class="badge bg-danger ms-auto">{{ $pendingOrders }}</span>
                    @endif
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                @php $pendingReservations = \DB::table('reservations')->where('status', 'pending')->count(); @endphp
                <a href="{{ url('/admin/reservations') }}" class="sidebar-nav-link {{ request()->is('admin/reservations*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Reservasi</span>
                    @if($pendingReservations > 0)
                    <span class="badge bg-warning text-dark ms-auto">{{ $pendingReservations }}</span>
                    @endif
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/tables') }}" class="sidebar-nav-link {{ request()->is('admin/tables*') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3"></i>
                    <span>Meja</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item mt-4">
                <small class="text-uppercase text-light opacity-50 px-3 mb-2 d-block" style="font-size: 0.7rem;">
                    Laporan & Analitik
                </small>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="#" class="sidebar-nav-link">
                    <i class="bi bi-graph-up"></i>
                    <span>Statistik</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="#" class="sidebar-nav-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Laporan</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item mt-4">
                <small class="text-uppercase text-light opacity-50 px-3 mb-2 d-block" style="font-size: 0.7rem;">
                    Content Management
                </small>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/cms') }}" class="sidebar-nav-link {{ request()->is('admin/cms') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i>
                    <span>CMS Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/cms/pages') }}" class="sidebar-nav-link {{ request()->is('admin/cms/pages*') ? 'active' : '' }}">
                    <i class="bi bi-file-richtext"></i>
                    <span>Pages</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/cms/media') }}" class="sidebar-nav-link {{ request()->is('admin/cms/media*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i>
                    <span>Media Library</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/cms/settings') }}" class="sidebar-nav-link {{ request()->is('admin/cms/settings*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>Site Settings</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item mt-4">
                <small class="text-uppercase text-light opacity-50 px-3 mb-2 d-block" style="font-size: 0.7rem;">
                    Pengaturan
                </small>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="{{ url('/admin/users') }}" class="sidebar-nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Pengguna</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item">
                <a href="#" class="sidebar-nav-link">
                    <i class="bi bi-gear"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="mt-auto p-3 border-top border-light border-opacity-10">
        <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm w-100">
            <i class="bi bi-house me-2"></i>Kembali ke Website
        </a>
    </div>
</aside>
