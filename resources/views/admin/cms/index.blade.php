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

    /* Device Widths */
    .mode-desktop iframe#site-preview { width: 100%; }
    .mode-tablet iframe#site-preview { width: 768px; }
    .mode-mobile iframe#site-preview { width: 375px; }

    /* Editor Inputs */
    .editor-field {
        margin-bottom: 1.5rem;
    }
    
    .editor-field label {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        color: #495057;
        display: block;
    }
    
    .no-selection-state {
        text-align: center;
        color: #adb5bd;
        padding-top: 3rem;
    }
    
    .no-selection-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    /* Loading overlay */
    .saving-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        display: none;
    }
    
    .saving-overlay.active {
        display: flex;
    }
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
            <div class="url-bar">
                <i class="bi bi-globe me-2"></i>
                <span id="current-url">{{ url('/') }}</span>
            </div>
            
            <div class="device-toggles btn-group">
                <button class="btn btn-outline-secondary active" onclick="setDeviceMode('desktop')" title="Desktop">
                    <i class="bi bi-laptop"></i>
                </button>
                <button class="btn btn-outline-secondary" onclick="setDeviceMode('tablet')" title="Tablet">
                    <i class="bi bi-tablet"></i>
                </button>
                <button class="btn btn-outline-secondary" onclick="setDeviceMode('mobile')" title="Mobile">
                    <i class="bi bi-phone"></i>
                </button>
            </div>
            
            <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-box-arrow-up-right"></i> Open Real Site
            </a>
        </div>
        
        <div class="iframe-wrapper mode-desktop" id="iframe-wrapper">
            <iframe src="{{ url('/') }}?cms_mode=true" id="site-preview" title="Site Preview"></iframe>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<Script src="{{ asset('js/cms-editor.js') }}"></script>
<script>
    function setDeviceMode(mode) {
        document.getElementById('iframe-wrapper').className = 'iframe-wrapper mode-' + mode;
        document.querySelectorAll('.device-toggles .btn').forEach(b => b.classList.remove('active'));
        event.currentTarget.classList.add('active');
    }
</script>
@endpush
