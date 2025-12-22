@extends('layouts.admin')

@section('title', 'Content Management System')

@push('styles')
<style>
.cms-hero {
    background: linear-gradient(135deg, var(--primary) 0%, rgba(12, 42, 54, 0.95) 50%, var(--primary) 100%);
    border-radius: 1.5rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.cms-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(200, 155, 58, 0.2) 0%, transparent 70%);
    animation: pulse-glow 4s ease-in-out infinite;
}

@keyframes pulse-glow {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.1); }
}

.cms-hero h1 {
    margin: 0 0 0.5rem;
    font-size: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-hero h1 i {
    color: var(--accent);
}

.cms-hero p {
    opacity: 0.8;
    margin: 0;
}

.cms-pages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.cms-page-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.25rem;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.cms-page-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(12, 42, 54, 0.15);
}

.cms-page-preview {
    height: 140px;
    background: linear-gradient(135deg, var(--primary) 0%, rgba(12, 42, 54, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.cms-page-preview i {
    font-size: 3rem;
    color: var(--accent);
    opacity: 0.8;
}

.cms-page-preview::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 60%, rgba(0,0,0,0.3) 100%);
}

.cms-page-content {
    padding: 1.25rem;
}

.cms-page-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.cms-page-url {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: 'Monaco', 'Consolas', monospace;
    margin-bottom: 1rem;
}

.cms-sections-list {
    margin-bottom: 1rem;
}

.cms-section-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    background: rgba(12, 42, 54, 0.03);
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.cms-section-item:last-child {
    margin-bottom: 0;
}

.cms-section-name {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.cms-section-name i {
    color: var(--accent);
    font-size: 0.9rem;
}

.cms-section-edit {
    color: var(--primary);
    font-size: 0.8rem;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.2s;
}

.cms-section-edit:hover {
    opacity: 1;
    color: var(--accent);
}

.cms-page-actions {
    display: flex;
    gap: 0.5rem;
}

.cms-btn-edit {
    flex: 1;
    padding: 0.75rem;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%);
    color: var(--text-on-accent);
    border: none;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.cms-btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(200, 155, 58, 0.3);
    color: var(--text-on-accent);
}

.cms-btn-view {
    padding: 0.75rem 1rem;
    background: rgba(12, 42, 54, 0.08);
    color: var(--primary);
    border: none;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.cms-btn-view:hover {
    background: var(--primary);
    color: white;
}

.cms-quick-settings {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.25rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.cms-quick-settings h3 {
    margin: 0 0 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
}

.cms-quick-settings h3 i {
    color: var(--accent);
}

.cms-settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.cms-setting-item {
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.03) 0%, rgba(200, 155, 58, 0.05) 100%);
    padding: 1rem;
    border-radius: 0.75rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.cms-setting-item:hover {
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.15) 0%, rgba(200, 155, 58, 0.08) 100%);
    transform: translateY(-3px);
    color: inherit;
}

.cms-setting-item i {
    font-size: 1.75rem;
    color: var(--accent);
    display: block;
    margin-bottom: 0.5rem;
}

.cms-setting-item span {
    font-weight: 600;
    font-size: 0.9rem;
}

[data-theme="dark"] .cms-page-card {
    background: rgba(22, 37, 43, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-page-title {
    color: var(--text-light);
}

[data-theme="dark"] .cms-section-item {
    background: rgba(255, 255, 255, 0.05);
}

[data-theme="dark"] .cms-quick-settings {
    background: rgba(22, 37, 43, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-setting-item {
    background: rgba(255, 255, 255, 0.05);
}

[data-theme="dark"] .cms-btn-view {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

@media (max-width: 768px) {
    .cms-pages-grid {
        grid-template-columns: 1fr;
    }
    
    .cms-hero {
        padding: 1.5rem;
    }
    
    .cms-hero h1 {
        font-size: 1.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="cms-hero">
    <h1><i class="bi bi-collection"></i> Content Management System</h1>
    <p>Kelola semua halaman customer dari sini - edit hero, content, gambar, dan lainnya</p>
</div>

<div class="cms-quick-settings">
    <h3><i class="bi bi-lightning"></i> Aksi Cepat</h3>
    <div class="cms-settings-grid">
        <a href="{{ url('/admin/developer/settings') }}" class="cms-setting-item">
            <i class="bi bi-gear"></i>
            <span>Site Settings</span>
        </a>
        <a href="{{ url('/admin/developer/media') }}" class="cms-setting-item">
            <i class="bi bi-images"></i>
            <span>Media Library</span>
        </a>
        <a href="{{ url('/admin/menus') }}" class="cms-setting-item">
            <i class="bi bi-book"></i>
            <span>Kelola Menu</span>
        </a>
        <a href="{{ url('/admin/reservations') }}" class="cms-setting-item">
            <i class="bi bi-calendar-check"></i>
            <span>Reservasi</span>
        </a>
    </div>
</div>

<h4 class="mb-3"><i class="bi bi-file-richtext text-accent me-2"></i>Halaman Customer</h4>

<div class="cms-pages-grid">
    {{-- Homepage --}}
    <div class="cms-page-card">
        <div class="cms-page-preview">
            <i class="bi bi-house-heart"></i>
        </div>
        <div class="cms-page-content">
            <div class="cms-page-title">
                <i class="bi bi-house"></i> Homepage
            </div>
            <div class="cms-page-url">/</div>
            <div class="cms-sections-list">
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-image"></i> Hero Section</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-star"></i> Featured Menu</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-list-ol"></i> How to Order</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-chat-quote"></i> Testimonials</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
            </div>
            <div class="cms-page-actions">
                <a href="{{ url('/admin/developer/pages/homepage/edit') }}" class="cms-btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit Page
                </a>
                <a href="{{ url('/') }}" target="_blank" class="cms-btn-view">
                    <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Menu Page --}}
    <div class="cms-page-card">
        <div class="cms-page-preview">
            <i class="bi bi-book"></i>
        </div>
        <div class="cms-page-content">
            <div class="cms-page-title">
                <i class="bi bi-book"></i> Menu
            </div>
            <div class="cms-page-url">/menu</div>
            <div class="cms-sections-list">
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-image"></i> Hero Banner</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-grid"></i> Menu Grid</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-funnel"></i> Categories Filter</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
            </div>
            <div class="cms-page-actions">
                <a href="{{ url('/admin/developer/pages/menu/edit') }}" class="cms-btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit Page
                </a>
                <a href="{{ url('/menu') }}" target="_blank" class="cms-btn-view">
                    <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- About Page --}}
    <div class="cms-page-card">
        <div class="cms-page-preview">
            <i class="bi bi-info-circle"></i>
        </div>
        <div class="cms-page-content">
            <div class="cms-page-title">
                <i class="bi bi-info-circle"></i> About Us
            </div>
            <div class="cms-page-url">/about</div>
            <div class="cms-sections-list">
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-image"></i> Hero Section</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-clock-history"></i> History Timeline</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-people"></i> Team Section</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-trophy"></i> Values</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
            </div>
            <div class="cms-page-actions">
                <a href="{{ url('/admin/developer/pages/about/edit') }}" class="cms-btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit Page
                </a>
                <a href="{{ url('/about') }}" target="_blank" class="cms-btn-view">
                    <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Contact Page --}}
    <div class="cms-page-card">
        <div class="cms-page-preview">
            <i class="bi bi-envelope"></i>
        </div>
        <div class="cms-page-content">
            <div class="cms-page-title">
                <i class="bi bi-envelope"></i> Contact
            </div>
            <div class="cms-page-url">/contact</div>
            <div class="cms-sections-list">
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-image"></i> Hero Section</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-geo-alt"></i> Contact Info</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-envelope-paper"></i> Contact Form</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-map"></i> Map Location</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
            </div>
            <div class="cms-page-actions">
                <a href="{{ url('/admin/developer/pages/contact/edit') }}" class="cms-btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit Page
                </a>
                <a href="{{ url('/contact') }}" target="_blank" class="cms-btn-view">
                    <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Reservation Page --}}
    <div class="cms-page-card">
        <div class="cms-page-preview">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div class="cms-page-content">
            <div class="cms-page-title">
                <i class="bi bi-calendar-check"></i> Reservation
            </div>
            <div class="cms-page-url">/reservation</div>
            <div class="cms-sections-list">
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-image"></i> Hero Section</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-card-text"></i> Booking Form</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-info-square"></i> Info Section</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
            </div>
            <div class="cms-page-actions">
                <a href="{{ url('/admin/developer/pages/reservation/edit') }}" class="cms-btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit Page
                </a>
                <a href="{{ url('/reservation') }}" target="_blank" class="cms-btn-view">
                    <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Login Page --}}
    <div class="cms-page-card">
        <div class="cms-page-preview">
            <i class="bi bi-door-open"></i>
        </div>
        <div class="cms-page-content">
            <div class="cms-page-title">
                <i class="bi bi-door-open"></i> Login
            </div>
            <div class="cms-page-url">/login</div>
            <div class="cms-sections-list">
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-image"></i> Background</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
                <div class="cms-section-item">
                    <span class="cms-section-name"><i class="bi bi-card-text"></i> Login Form</span>
                    <i class="bi bi-pencil cms-section-edit"></i>
                </div>
            </div>
            <div class="cms-page-actions">
                <a href="{{ url('/admin/developer/pages/login/edit') }}" class="cms-btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit Page
                </a>
                <a href="{{ url('/login') }}" target="_blank" class="cms-btn-view">
                    <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="cms-quick-settings">
    <h3><i class="bi bi-puzzle"></i> Komponen Global</h3>
    <div class="cms-settings-grid">
        <a href="{{ url('/admin/developer/components/navbar') }}" class="cms-setting-item">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Navbar</span>
        </a>
        <a href="{{ url('/admin/developer/components/footer') }}" class="cms-setting-item">
            <i class="bi bi-layout-text-sidebar-reverse"></i>
            <span>Footer</span>
        </a>
        <a href="{{ url('/admin/developer/settings') }}" class="cms-setting-item">
            <i class="bi bi-share"></i>
            <span>Social Media</span>
        </a>
        <a href="{{ url('/admin/developer/settings') }}" class="cms-setting-item">
            <i class="bi bi-palette"></i>
            <span>Theme Colors</span>
        </a>
    </div>
</div>
@endsection
