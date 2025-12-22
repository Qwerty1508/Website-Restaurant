@extends('layouts.admin')

@section('title', 'Visual Content Editor')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --cms-bg-dark: #0f172a;
        --cms-sidebar-bg: #1e293b;
        --cms-card-bg: #334155;
        --cms-border: #475569;
        --cms-text-primary: #f1f5f9;
        --cms-text-secondary: #94a3b8;
        --cms-gold: #C89B3A;
        --cms-gold-hover: #b08629;
        --cms-danger: #ef4444;
    }

    body {
        font-family: 'Outfit', sans-serif;
        background-color: var(--cms-bg-dark);
        overflow: hidden; /* Prevent body scroll */
    }

    /* Hide Default Admin Navbar by default but allow toggling */
    .sidebar {
        transition: transform 0.3s ease-in-out;
        z-index: 1000;
    }
    
    .sidebar.collapsed {
        transform: translateX(-100%);
    }

    /* Main content expands when sidebar is collapsed */
    .main-content-admin {
        margin-left: 280px; /* Default width */
        transition: margin-left 0.3s ease-in-out;
        width: calc(100% - 280px);
    }
    
    .sidebar.collapsed + .sidebar-overlay + .main-content-admin,
    .sidebar.collapsed ~ .main-content-admin { /* Handle both DOM structures */
        margin-left: 0 !important;
        width: 100% !important;
    }

    /* Override for this specific page */
    .visual-editor-container {
        height: 100vh;
        overflow: hidden;
        display: flex;
        position: relative;
    }

    /* Toggle Button */
    .btn-toggle-sidebar {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 1100;
        background: var(--cms-gold);
        color: #fff;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        cursor: pointer;
        transition: all 0.2s;
        opacity: 0; /* Hidden when sidebar is open */
        pointer-events: none;
    }

    .sidebar.collapsed ~ .visual-editor-container .btn-toggle-sidebar,
    body.sidebar-closed .btn-toggle-sidebar {
        opacity: 1;
        pointer-events: auto;
    }

    .btn-toggle-sidebar:hover {
        transform: scale(1.1);
        background: #fff;
        color: var(--cms-gold);
    }
    
    /* Close button inside sidebar */
    .btn-close-sidebar {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.5);
        cursor: pointer;
    }
    
    .btn-close-sidebar:hover { color: #fff !important; }

    /* Reset Admin Layout for Full Screen Editor */
    .main-content-admin {
        padding: 0 !important;
        margin-top: 0 !important;
        height: 100vh !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
    }

    /* Hide Standard Admin Navbar */
    .main-content-admin > .navbar {
        display: none !important;
    }

    .container-fluid {
        padding: 0 !important;
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .visual-editor-container {
        flex: 1;
        display: flex;
        height: 100vh;
        width: 100%;
        background-color: var(--cms-bg-dark);
        overflow: hidden;
    }

    /* --- LUXURY SIDEBAR --- */
    .editor-sidebar {
        width: 380px;
        background: var(--cms-sidebar-bg);
        border-right: 1px solid var(--cms-border);
        display: flex;
        flex-direction: column;
        z-index: 100;
        box-shadow: 10px 0 30px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
    }

    .editor-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--cms-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(30, 41, 59, 0.95);
        backdrop-filter: blur(10px);
    }

    .brand-title {
        color: var(--cms-gold);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .connection-badge {
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 20px;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
    }
    
    .connection-badge::before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 8px #10b981;
    }

    .editor-content {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
    }
    
    /* Scrollbar Style */
    .editor-content::-webkit-scrollbar { width: 6px; }
    .editor-content::-webkit-scrollbar-track { background: var(--cms-sidebar-bg); }
    .editor-content::-webkit-scrollbar-thumb { background: var(--cms-border); border-radius: 3px; }

    /* Page Selector Style */
    .page-select-wrapper {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .page-select-label {
        color: var(--cms-text-secondary);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }
    
    .custom-select {
        background-color: var(--cms-card-bg);
        border: 1px solid var(--cms-border);
        color: var(--cms-text-primary);
        padding: 12px 16px;
        border-radius: 12px;
        width: 100%;
        font-size: 0.95rem;
        appearance: none;
        cursor: pointer;
        transition: all 0.2s;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
    }
    
    .custom-select:hover, .custom-select:focus {
        border-color: var(--cms-gold);
        outline: none;
        box-shadow: 0 0 0 3px rgba(200, 155, 58, 0.15);
    }

    /* Editor Fields */
    .editor-card {
        background: var(--cms-card-bg);
        border: 1px solid var(--cms-border);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-dark-control {
        background: var(--cms-sidebar-bg);
        border: 1px solid var(--cms-border);
        color: var(--cms-text-primary);
        border-radius: 8px;
        padding: 10px 14px;
        width: 100%;
        transition: all 0.2s;
    }
    
    .form-dark-control:focus {
        background: var(--cms-sidebar-bg);
        border-color: var(--cms-gold);
        color: var(--cms-text-primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(200, 155, 58, 0.15);
    }
    
    .form-dark-label {
        color: var(--cms-text-secondary);
        font-size: 0.8rem;
        margin-bottom: 6px;
        display: block;
    }

    .no-selection-state {
        text-align: center;
        color: var(--cms-text-secondary);
        padding-top: 4rem;
    }

    .no-selection-icon-wrapper {
        width: 80px;
        height: 80px;
        background: rgba(200, 155, 58, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 1px dashed var(--cms-gold);
    }
    
    /* Footer & Save Button */
    .editor-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--cms-border);
        background: var(--cms-sidebar-bg);
    }

    .btn-gold-gradient {
        background: linear-gradient(135deg, #C89B3A 0%, #a47e2c 100%);
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        width: 100%;
        box-shadow: 0 4px 15px rgba(200, 155, 58, 0.3);
        transition: all 0.3s;
    }
    
    .btn-gold-gradient:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(200, 155, 58, 0.4);
        color: #fff;
    }
    
    .btn-gold-gradient:disabled {
        background: var(--cms-card-bg);
        color: var(--cms-text-secondary);
        box-shadow: none;
        cursor: not-allowed;
    }

    /* --- PREVIEW AREA --- */
    .preview-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: #0c0f16;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(200, 155, 58, 0.03) 0%, transparent 20%),
            radial-gradient(var(--cms-border) 1px, transparent 1px);
        background-size: 100% 100%, 30px 30px;
        position: relative;
    }

    /* Floating Toolbar */
    .preview-toolbar {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 50;
        background: rgba(30, 41, 59, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 8px 12px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.4);
    }
    
    .toolbar-group {
        display: flex;
        align-items: center;
        background: rgba(15, 23, 42, 0.5);
        border-radius: 10px;
        padding: 4px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .device-btn {
        background: transparent;
        border: none;
        color: var(--cms-text-secondary);
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .device-btn:hover {
        color: #fff;
        background: rgba(255,255,255,0.05);
    }
    
    .device-btn.active {
        background: var(--cms-card-bg);
        color: var(--cms-gold);
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .url-display {
        color: var(--cms-text-secondary);
        font-size: 0.8rem;
        padding: 0 12px;
        border-right: 1px solid var(--cms-border);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .model-select {
        background: transparent;
        color: var(--cms-text-primary);
        border: none;
        font-size: 0.85rem;
        padding: 6px 20px 6px 10px;
        cursor: pointer;
    }
    
    .video-rotate-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--cms-card-bg);
        color: var(--cms-text-secondary);
        border: 1px solid var(--cms-border);
        transition: all 0.3s;
    }
    
    .video-rotate-btn:hover {
        background: var(--cms-gold);
        color: #fff;
        border-color: var(--cms-gold);
    }

    /* Iframe & Bezel */
    .iframe-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 100px 20px 40px; /* Top padding for toolbar */
        overflow: auto;
    }
    
    .device-bezel {
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        background: #000;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    }
    
    /* Device Specific Bezels */
    /* --- SIDEBAR TOGGLE LOGIC --- */
    
    /* 1. Sidebar Transition */
    .sidebar {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2000 !important; /* Above everything */
    }
    
    /* When Closed */
    body.sidebar-closed .sidebar {
        transform: translateX(-100%);
    }

    /* 2. Main Content Adjustment */
    .main-content-admin {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0 !important; /* Always 0 padding for CMS */
        
        /* Default Open State */
        margin-left: 280px !important;
        width: calc(100% - 280px) !important;
    }

    /* When Closed: Full Width */
    body.sidebar-closed .main-content-admin {
        margin-left: 0 !important;
        width: 100% !important;
    }
    
    /* Mobile Override */
    @media (max-width: 991.98px) {
        .main-content-admin {
            margin-left: 0 !important;
            width: 100% !important;
        }
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.show {
            transform: translateX(0);
        }
    }

    /* Override for this specific page */
    .visual-editor-container {
        height: 100vh;
        overflow: hidden;
        display: flex;
        position: relative;
    }

    /* Toggle Button */
    .btn-toggle-sidebar {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 1500;
        background: var(--cms-gold);
        color: #fff;
        border: none;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0;
        transform: scale(0.8);
        pointer-events: none;
    }

    /* Show button when sidebar is closed */
    body.sidebar-closed .btn-toggle-sidebar {
        opacity: 1;
        transform: scale(1);
        pointer-events: auto;
    }

    .btn-toggle-sidebar:hover {
        background: #fff;
        color: var(--cms-gold);
        transform: scale(1.1);
    }
    
    .btn-close-sidebar {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-close-sidebar:hover {
        background: var(--cms-gold);
        color: #fff;
        border-color: var(--cms-gold);
    }

    /* Hide Top Admin Navbar on this page specifically */
    .main-content-admin > nav.navbar {
        display: none !important;
    }
    
    /* Device Specific Bezels */
    .mode-mobile .device-bezel {
        border-radius: 40px;
        border: 8px solid #1a1a1a;
        padding: 0;
        position: relative;
    }
    
    .mode-mobile .device-bezel::before {
        content: '';
        position: absolute;
        top: 0; left: 50%; transform: translateX(-50%);
        width: 120px; height: 24px;
        background: #000;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
        z-index: 10;
        pointer-events: none;
    }
    
    .mode-tablet .device-bezel {
        border-radius: 20px;
        border: 12px solid #1a1a1a;
    }
    
    /* Desktop Mode: Maximized Space */
    .mode-desktop {
        padding: 80px 0 0 0 !important; /* Only top padding for toolbar */
        display: block !important;
        overflow: hidden !important;
    }

    .mode-desktop .device-bezel {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 0;
        box-shadow: none;
        padding: 0; /* No internal padding */
    }
    
    .mode-desktop iframe {
        border-radius: 0; /* Sharp corners like browser */
        box-shadow: none;
    }
    
    iframe {
        background: #fff;
        border-radius: 32px; 
    }

    /* Loading Overlay */
    .saving-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(4px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        display: none;
        color: #fff;
    }
    
    .saving-overlay.active { display: flex; }
    
</style>
@endpush

@section('content')
<div class="visual-editor-container">
    <!-- Luxury Sidebar -->
    <div class="editor-sidebar">
        <div class="editor-header">
            <div class="brand-title">
                <i class="bi bi-gem"></i> Culinaire CMS
            </div>
            <span class="connection-badge" id="connection-status">
                Connected
            </span>
        </div>
        
        <div class="editor-content" id="editor-panel">
            <!-- Page Selector -->
            <div class="page-select-wrapper">
                <label class="page-select-label">Halaman Yang Diedit</label>
                <select class="custom-select" id="page-selector">
                    <option value="{{ url('/') }}">Beranda (Home)</option>
                    <option value="{{ url('/menu') }}">Daftar Menu</option>
                    <option value="{{ url('/reservation') }}">Reservasi</option>
                    <option value="{{ url('/about') }}">Tentang Kami</option>
                    <option value="{{ url('/contact') }}">Hubungi Kami</option>
                    <option value="{{ url('/login') }}">Login / Register</option>
                </select>
            </div>
            
            <div class="no-selection-state">
                <div class="no-selection-icon-wrapper">
                    <i class="bi bi-cursor-fill text-gold fs-2" style="color: var(--cms-gold);"></i>
                </div>
                <h6 class="text-white mb-2">Pilih Konten</h6>
                <p class="small text-muted">Klik bagian website di sebelah kanan yang ingin Anda ubah.</p>
            </div>
            
            <form id="edit-form" style="display: none;">
                <input type="hidden" id="field-key" name="key">
                <input type="hidden" id="field-type" name="type">
                
                <div class="editor-card">
                    <div class="mb-3">
                        <label class="form-dark-label">ID Element</label>
                        <input type="text" class="form-dark-control" id="field-key-display" readonly style="opacity: 0.6; cursor: not-allowed;">
                    </div>
                </div>

                <div class="editor-card">
                    <div class="mb-2" id="input-container">
                        <!-- Dynamic Input will be injected here -->
                    </div>
                    
                    <div id="image-upload-container" style="display: none;">
                        <hr style="border-color: var(--cms-border);">
                        <label class="form-dark-label">Upload Gambar Baru</label>
                        <input type="file" class="form-dark-control" id="image-uploader" accept="image/*">
                        <small class="text-muted mt-2 d-block" style="font-size: 0.7rem;">
                            <i class="bi bi-info-circle me-1"></i> Max 5MB. Formats: JPG, PNG, WEBP.
                        </small>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="editor-footer">
            <button type="button" class="btn-gold-gradient" id="btn-save" disabled>
                <i class="bi bi-save2 me-2"></i>Simpan Perubahan
            </button>
        </div>
    </div>

    <!-- Preview Area -->
    <div class="preview-area">
        <div class="saving-overlay">
            <div class="spinner-border text-warning mb-3" role="status"></div>
            <span class="fw-bold tracking-wider">MENYIMPAN PERUBAHAN...</span>
        </div>
        
        <!-- Floating Luxury Toolbar -->
        <div class="preview-toolbar">
            <div class="url-display">
                <i class="bi bi-globe2 me-2 text-muted"></i>
                <span id="current-url">{{ url('/') }}</span>
            </div>
            
            <div class="toolbar-group">
                <button class="device-btn active" onclick="setDeviceType('desktop')" id="btn-desktop" data-bs-toggle="tooltip" title="Desktop">
                    <i class="bi bi-laptop"></i>
                </button>
                <button class="device-btn" onclick="setDeviceType('tablet')" id="btn-tablet" data-bs-toggle="tooltip" title="Tablet">
                    <i class="bi bi-tablet"></i>
                </button>
                <button class="device-btn" onclick="setDeviceType('mobile')" id="btn-mobile" data-bs-toggle="tooltip" title="Mobile">
                    <i class="bi bi-phone"></i>
                </button>
            </div>

            <!-- Model Selector (Hidden unless tablet/mobile) -->
            <div class="model-selector-wrapper" id="model-wrapper">
                <select class="model-select" id="model-selector" onchange="setDeviceModel(this.value)">
                    <!-- Options via JS -->
                </select>
            </div>
            
            <div class="model-selector-wrapper" id="rotate-wrapper">
                <button class="video-rotate-btn" onclick="toggleOrientation()" title="Rotate Device">
                    <i class="bi bi-phone-flip"></i>
                </button>
            </div>
            
            <div style="width: 1px; height: 24px; background: rgba(255,255,255,0.1); margin: 0 4px;"></div>
            
            <a href="{{ url('/') }}" target="_blank" class="device-btn text-warning" title="Open Real Site">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
        </div>
        
        <div class="iframe-wrapper mode-desktop" id="iframe-wrapper">
            <div class="device-bezel" id="device-entity" style="width: 100%; height: 100%;">
                <iframe src="{{ url('/') }}?cms_mode=true" id="site-preview" title="Site Preview" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
        <!-- Toggle Button to Open Sidebar -->
        <button class="btn-toggle-sidebar" id="btn-open-sidebar" title="Open Menu">
            <i class="bi bi-list fs-5"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cms-editor.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;
        const mainSidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('btn-open-sidebar');
        
        // --- 1. Setup Close Button ---
        // We need to inject a close button into the main sidebar if it doesn't exist
        if (mainSidebar && !mainSidebar.querySelector('.btn-close-sidebar')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'btn-close-sidebar';
            closeBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
            closeBtn.title = 'Close Sidebar';
            closeBtn.onclick = toggleMainSidebar;
            
            // Append as first child or near top
            mainSidebar.appendChild(closeBtn);
        }

        // --- 2. Default State: Closed ---
        // Add 'sidebar-closed' to body immediately
        body.classList.add('sidebar-closed'); 
        if(mainSidebar) mainSidebar.classList.add('collapsed'); // Just in case CSS needs it helper

        // --- 3. Toggle Function ---
        function toggleMainSidebar() {
            body.classList.toggle('sidebar-closed');
            // Sync specific class on sidebar if needed (though CSS handles it via body selector)
            if(mainSidebar) mainSidebar.classList.toggle('collapsed');
        }

        // --- 4. Event Listeners ---
        if (openBtn) {
            openBtn.addEventListener('click', toggleMainSidebar);
        }

    
    // Device Definitions
    const devices = {
        mobile: [
            { name: 'iPhone SE', width: 375, height: 667 },
            { name: 'iPhone 13/14', width: 390, height: 844 },
            { name: 'iPhone 14 Pro Max', width: 430, height: 932 },
            { name: 'Pixel 7', width: 412, height: 915 },
            { name: 'Samsung Galaxy S23 Ultra', width: 412, height: 915 }
        ],
        tablet: [
            { name: 'iPad Mini', width: 768, height: 1024 },
            { name: 'iPad Air', width: 820, height: 1180 },
            { name: 'iPad Pro 11"', width: 834, height: 1194 },
            { name: 'iPad Pro 12.9"', width: 1024, height: 1366 },
            { name: 'Galaxy Tab S8', width: 800, height: 1280 }
        ]
    };

    let currentType = 'desktop';
    let currentModel = null;
    let isLandscape = false;

    function setDeviceType(type) {
        currentType = type;
        const modelWrapper = document.getElementById('model-wrapper');
        const rotateWrapper = document.getElementById('rotate-wrapper');
        const deviceEntity = document.getElementById('device-entity');
        const wrapper = document.getElementById('iframe-wrapper');
        
        // Update Buttons
        document.querySelectorAll('.device-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('btn-' + type).classList.add('active');

        // Update Wrapper Class
        wrapper.className = 'iframe-wrapper mode-' + type;

        if (type === 'desktop') {
            modelWrapper.classList.add('visible'); // Allow resolution selection for desktop too
            populateModels('desktop');
        } else {
            modelWrapper.classList.add('visible');
            rotateWrapper.classList.add('visible');
            populateModels(type);
        }
    }

    function populateModels(type) {
        const selector = document.getElementById('model-selector');
        selector.innerHTML = ''; // Clear
        
        if(type === 'desktop') {
             // Desktop Specific Options
             const desktopOptions = [
                 { name: 'Responsive (Fit Screen)', width: '100%', height: '100%' },
                 { name: 'Laptop (1366x768)', width: 1366, height: 768 },
                 { name: 'FHD Monitor (1920x1080)', width: 1920, height: 1080 },
                 { name: 'MacBook Pro 16 (1728x1117)', width: 1728, height: 1117 }
             ];
             
             desktopOptions.forEach((device, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.text = device.name;
                selector.appendChild(option);
             });
             
             // Store for later usage
             devices['desktop'] = desktopOptions;

        } else {
            devices[type].forEach((device, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.text = device.name + ` (${device.width}x${device.height})`;
                selector.appendChild(option);
            });
        }
        
        // Select first by default
        setDeviceModel(0);
    }

    function setDeviceModel(index) {
        if (!devices[currentType]) return;
        
        currentModel = devices[currentType][index];
        applyDimensions();
    }

    function toggleOrientation() {
        isLandscape = !isLandscape;
        applyDimensions();
    }

    function applyDimensions() {
        const deviceEntity = document.getElementById('device-entity');
        const wrapper = document.getElementById('iframe-wrapper');
        
        // Reset Transforms
        deviceEntity.style.transform = 'none';
        
        if (currentType === 'desktop') {
            if (currentModel.width === '100%') {
                deviceEntity.style.width = '100%';
                deviceEntity.style.height = '100%';
                deviceEntity.style.border = 'none';
                deviceEntity.style.borderRadius = '0';
                deviceEntity.style.boxShadow = 'none';
                wrapper.style.overflow = 'auto'; // Allow scroll for full width
            } else {
                deviceEntity.style.width = currentModel.width + 'px';
                deviceEntity.style.height = currentModel.height + 'px';
                // Add bezel for fixed sizes
                deviceEntity.style.border = '16px solid #1a1a1a'; 
                deviceEntity.style.borderRadius = '8px';
                deviceEntity.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.5)';
                deviceEntity.style.transformOrigin = 'center top'; // Scale from top center to nicely fit
                
                // Scale Down Logic
                setTimeout(() => {
                    // Update wrapper overflow to hidden to prevent scrollbars when scaling down large content
                    wrapper.style.overflow = 'hidden';
                    
                    const availableWidth = wrapper.clientWidth - 60; // Padding side
                    const availableHeight = wrapper.clientHeight - 80; // Padding top/bottom
                    
                    const scaleX = availableWidth / currentModel.width;
                    const scaleY = availableHeight / currentModel.height;
                    const scale = Math.min(scaleX, scaleY, 1); // Never scale up, only down
                    
                    if(scale < 1) {
                        deviceEntity.style.transform = `scale(${scale})`;
                        // Add margin top to center vertically if needed
                        const heightDiff = (availableHeight - (currentModel.height * scale)) / 2;
                        if(heightDiff > 0) {
                            deviceEntity.style.marginTop = `${heightDiff}px`;
                        } else {
                            deviceEntity.style.marginTop = '20px';
                        }
                    } else {
                         deviceEntity.style.marginTop = '20px';
                    }
                }, 10);
            }
            return;
        }

        let width = currentModel.width;
        let height = currentModel.height;
        
        if (isLandscape) {
            [width, height] = [height, width];
        }
        
        deviceEntity.style.width = width + 'px';
        deviceEntity.style.height = height + 'px';
        deviceEntity.style.border = ''; // Reset to class default
        deviceEntity.style.borderRadius = '';
        deviceEntity.style.transformOrigin = 'center center'; 
        
        // Scale logic for mobile/tablet
        setTimeout(() => {
            wrapper.style.overflow = 'hidden'; // Ensure hidden overflow for clean scaling
            
            const availableWidth = wrapper.clientWidth - 40;
            const availableHeight = wrapper.clientHeight - 40;
            
            const scaleX = availableWidth / width;
            const scaleY = availableHeight / height;
            const scale = Math.min(scaleX, scaleY, 1); 
            
            if(scale < 1) {
                deviceEntity.style.transform = `scale(${scale})`;
            }
             deviceEntity.style.marginTop = '0';
        }, 10);
    }
    
    // Auto Recalculate on Resize
    window.addEventListener('resize', () => { // Debounce could be added here for performance
        applyDimensions();
    });
    
    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        setDeviceType('desktop');
        
        // Listen for iframe url changes
        window.addEventListener('message', (event) => {
            if (event.data.type === 'cms_url_changed' && event.data.url) {
                document.getElementById('current-url').textContent = event.data.url;
                
                // Update select if matches
                const selector = document.getElementById('page-selector');
                const fullUrl = event.data.url;
                // Try to match value
                for(let i=0; i<selector.options.length; i++) {
                    if(fullUrl.includes(selector.options[i].value)) {
                         selector.selectedIndex = i;
                         break;
                    }
                }
            }
        });
    });
</script>
@endpush
