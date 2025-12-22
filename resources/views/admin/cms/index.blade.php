@extends('layouts.admin')

@section('title', 'Visual Content Editor')

@push('styles')
<style>
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
        height: 100%;
        width: 100%;
        background-color: #f8f9fa;
        overflow: hidden;
    }

    /* Sidebar Editor Panel */
    .editor-sidebar {
        width: 350px;
        background: white;
        border-right: 1px solid #dee2e6;
        display: flex;
        flex-direction: column;
        z-index: 100;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    }

    .editor-header {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }

    .editor-content {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
    }

    .editor-footer {
        padding: 1rem;
        border-top: 1px solid #dee2e6;
        background: #f8f9fa;
    }

    /* Iframe Preview Area */
    .preview-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #e9ecef;
        position: relative;
    }

    .preview-toolbar {
        height: 50px;
        background: white;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        padding: 0 1rem;
        gap: 1rem;
    }

    .url-bar {
        flex: 1;
        background: #f1f3f5;
        border-radius: 4px;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
    }

    .device-toggles .btn {
        padding: 0.2rem 0.5rem;
    }

    .iframe-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        padding: 1rem;
        overflow: auto;
    }

    iframe#site-preview {
        width: 100%;
        height: 100%;
        border: none;
        background: white;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        transition: width 0.3s ease;
    }

    /* Advanced Preview Toolbar */
    .preview-toolbar {
        height: 60px;
        background: white;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        padding: 0 1.5rem;
        gap: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    
    .url-bar-container {
        flex: 1;
        min-width: 200px;
    }
    
    .url-bar {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        color: #495057;
        display: flex;
        align-items: center;
        transition: all 0.2s;
    }
    
    .url-bar:hover {
        border-color: #ced4da;
        background: #fff;
    }
    
    /* Device Controls */
    .device-controls-group {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        padding: 4px;
        border-radius: 10px;
        border: 1px solid #dee2e6;
    }
    
    .device-btn {
        border: none;
        background: transparent;
        padding: 6px 12px;
        border-radius: 8px;
        color: #6c757d;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
    }
    
    .device-btn:hover {
        background: #e9ecef;
        color: #212529;
    }
    
    .device-btn.active {
        background: #fff;
        color: #0d6efd;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-weight: 500;
    }
    
    .model-selector-wrapper {
        margin-left: 1rem;
        position: relative;
        min-width: 160px;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        transform: translateX(-10px);
    }
    
    .model-selector-wrapper.visible {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }
    
    .btn-rotate {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid #dee2e6;
        background: white;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.2s;
        margin-left: 0.5rem;
    }
    
    .btn-rotate:hover {
        background: #f8f9fa;
        color: #0d6efd;
        transform: rotate(15deg);
    }

    /* Realistic Device Bezel */
    .iframe-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center; /* Center vertically too */
        padding: 2rem;
        overflow: auto;
        background-color: #e9ecef;
        background-image: radial-gradient(#dee2e6 1px, transparent 1px);
        background-size: 20px 20px;
        transition: all 0.3s ease;
    }

    .device-bezel {
        background: #111;
        padding: 12px; /* Bezel Thickness */
        border-radius: 4px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
    }
    
    .device-bezel::after { 
        /* Notch/Camera indicator */
        content: '';
        display: block;
        width: 30px;
        height: 4px;
        background: #333;
        position: absolute;
        top: 6px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 4px;
        opacity: 0; /* Hidden on desktop */
    }
    
    /* Device Specific Styles */
    .mode-mobile .device-bezel {
        border-radius: 36px;
        padding: 12px;
        border: 4px solid #333;
    }
    
    .mode-mobile .device-bezel::after { opacity: 1; width: 80px; height: 16px; top: 12px; border-radius: 10px; }

    .mode-tablet .device-bezel {
        border-radius: 20px;
        padding: 16px;
    }

    .mode-desktop .device-bezel {
        width: 100%;
        height: 100%;
        padding: 0;
        background: transparent;
        box-shadow: none;
        border-radius: 0;
    }

    iframe#site-preview {
        width: 100%;
        height: 100%;
        border: none;
        background: white;
        border-radius: 2px; /* Inner radius */
        display: block;
    }
    
    .mode-mobile iframe#site-preview { border-radius: 24px; }
    .mode-tablet iframe#site-preview { border-radius: 12px; }

</style>
@endpush

@section('content')
<div class="visual-editor-container">
    <!-- Sidebar -->
    <div class="editor-sidebar">
        <div class="editor-header">
            <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Editor</h5>
            <span class="badge bg-light text-dark border" id="connection-status">Disconnected</span>
        </div>
        
        <div class="editor-content" id="editor-panel">
            <!-- Page Selector -->
            <div class="mb-4">
                <label class="small text-muted fw-bold mb-2 text-uppercase">Halaman Aktif</label>
                <select class="form-select" id="page-selector">
                    <option value="{{ url('/') }}">Beranda (Home)</option>
                    <option value="{{ url('/menu') }}">Daftar Menu</option>
                    <option value="{{ url('/reservation') }}">Reservasi</option>
                    <option value="{{ url('/about') }}">Tentang Kami</option>
                    <option value="{{ url('/contact') }}">Hubungi Kami</option>
                    <option value="{{ url('/login') }}">Login / Register</option>
                </select>
            </div>
            
            <div class="no-selection-state">
                <i class="bi bi-cursor"></i>
                <h6>Pilih Elemen</h6>
                <p class="small">Klik elemen apapun di halaman sebelah kanan untuk mulai mengedit kontennya.</p>
            </div>
            
            <form id="edit-form" style="display: none;">
                <input type="hidden" id="field-key" name="key">
                <input type="hidden" id="field-type" name="type">
                
                <div class="editor-field">
                    <label>Key ID</label>
                    <input type="text" class="form-control form-control-sm bg-light" id="field-key-display" readonly>
                </div>
                
                <div class="editor-field" id="input-container">
                    <!-- Dynamic Input will be injected here -->
                </div>
                
                <div class="editor-field" id="image-upload-container" style="display: none;">
                    <label>Upload New Image</label>
                    <input type="file" class="form-control" id="image-uploader" accept="image/*">
                    <small class="text-muted mt-1 d-block">Max 5MB. Formats: JPG, PNG, WEBP.</small>
                </div>
            </form>
        </div>
        
        <div class="editor-footer">
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-primary" id="btn-save" disabled>
                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <!-- Preview Area -->
    <div class="preview-area">
        <div class="saving-overlay">
            <div class="spinner-border text-primary me-2" role="status"></div>
            <span class="fw-bold">Menyimpan...</span>
        </div>
        
        <div class="preview-toolbar">
            <div class="url-bar-container">
                <div class="url-bar">
                    <i class="bi bi-globe me-2 text-primary"></i>
                    <span id="current-url">{{ url('/') }}</span>
                </div>
            </div>
            
            <!-- Type Selector -->
            <div class="device-controls-group">
                <button class="device-btn active" onclick="setDeviceType('desktop')" id="btn-desktop" title="Desktop View">
                    <i class="bi bi-laptop"></i> Desktop
                </button>
                <div style="width: 1px; height: 16px; background: #dee2e6; margin: 0 4px;"></div>
                <button class="device-btn" onclick="setDeviceType('tablet')" id="btn-tablet" title="Tablet View">
                    <i class="bi bi-tablet"></i> Tablet
                </button>
                <button class="device-btn" onclick="setDeviceType('mobile')" id="btn-mobile" title="Mobile View">
                    <i class="bi bi-phone"></i> Mobile
                </button>
            </div>

            <!-- Model Selector (Hidden unless tablet/mobile) -->
            <div class="model-selector-wrapper" id="model-wrapper">
                <select class="form-select form-select-sm" id="model-selector" onchange="setDeviceModel(this.value)">
                    <!-- Options populated via JS -->
                </select>
            </div>
            
            <!-- Rotate (Hidden unless tablet/mobile) -->
            <div class="model-selector-wrapper" id="rotate-wrapper" style="min-width: auto; margin-left: 0;">
                <button class="btn-rotate" onclick="toggleOrientation()" title="Rotate Device">
                    <i class="bi bi-arrow-repeat"></i>
                </button>
            </div>
            
            <a href="{{ url('/') }}" target="_blank" class="btn btn-primary d-flex align-items-center ms-auto">
                <i class="bi bi-box-arrow-up-right me-2"></i> Preview Real
            </a>
        </div>
        
        <div class="iframe-wrapper mode-desktop" id="iframe-wrapper">
            <div class="device-bezel" id="device-entity" style="width: 100%; height: 100%;">
                <iframe src="{{ url('/') }}?cms_mode=true" id="site-preview" title="Site Preview"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cms-editor.js') }}"></script>
<script>
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
            modelWrapper.classList.remove('visible');
            rotateWrapper.classList.remove('visible');
            deviceEntity.style.width = '100%';
            deviceEntity.style.height = '100%';
        } else {
            // Show Selector
            modelWrapper.classList.add('visible');
            rotateWrapper.classList.add('visible');
            populateModels(type);
        }
    }

    function populateModels(type) {
        const selector = document.getElementById('model-selector');
        selector.innerHTML = ''; // Clear
        
        devices[type].forEach((device, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.text = device.name + ` (${device.width}x${device.height})`;
            selector.appendChild(option);
        });
        
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
        
        // Rotate Icon Animation
        const icon = document.querySelector('.btn-rotate i');
        icon.style.transform = isLandscape ? 'rotate(90deg)' : 'rotate(0deg)';
        icon.style.transition = 'transform 0.3s';
    }

    function applyDimensions() {
        const deviceEntity = document.getElementById('device-entity');
        
        if (currentType === 'desktop') {
            deviceEntity.style.width = '100%';
            deviceEntity.style.height = '100%';
            return;
        }

        let width = currentModel.width;
        let height = currentModel.height;
        
        if (isLandscape) {
            // Swap
            [width, height] = [height, width];
        }

        deviceEntity.style.width = width + 'px';
        deviceEntity.style.height = height + 'px';
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        // Just empty init if needed, currently setDeviceType default is desktop via HTML
    });
</script>
@endpush
