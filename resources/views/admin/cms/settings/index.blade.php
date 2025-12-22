@extends('layouts.admin')

@section('title', 'Site Settings')

@push('styles')
<style>
.cms-settings-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.cms-settings-header h1 {
    margin: 0;
    font-size: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-settings-header h1 i {
    color: var(--accent);
}

.cms-settings-container {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 1.5rem;
    align-items: start;
}

.cms-settings-nav {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1rem;
    padding: 1rem;
    position: sticky;
    top: 1rem;
}

.cms-settings-nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    color: var(--text-secondary);
    font-weight: 500;
}

.cms-settings-nav-item:hover {
    background: rgba(200, 155, 58, 0.1);
    color: var(--primary);
}

.cms-settings-nav-item.active {
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%);
    color: var(--text-on-accent);
}

.cms-settings-nav-item i {
    font-size: 1.25rem;
}

.cms-settings-panel {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.5rem;
    overflow: hidden;
}

.cms-settings-panel-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.03) 0%, rgba(200, 155, 58, 0.05) 100%);
    border-bottom: 1px solid rgba(12, 42, 54, 0.08);
}

.cms-settings-panel-header h3 {
    margin: 0 0 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-settings-panel-header h3 i {
    color: var(--accent);
}

.cms-settings-panel-header p {
    margin: 0;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.cms-settings-panel-body {
    padding: 1.5rem;
}

.cms-settings-group {
    margin-bottom: 2rem;
}

.cms-settings-group:last-child {
    margin-bottom: 0;
}

.cms-settings-row {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}

.cms-settings-row:last-child {
    margin-bottom: 0;
}

.cms-settings-label {
    flex: 0 0 200px;
    padding-top: 0.75rem;
}

.cms-settings-label h6 {
    margin: 0 0 0.25rem;
    font-weight: 600;
}

.cms-settings-label p {
    margin: 0;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.cms-settings-field {
    flex: 1;
}

.cms-settings-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid rgba(12, 42, 54, 0.1);
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.cms-settings-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(200, 155, 58, 0.15);
    outline: none;
}

.cms-settings-textarea {
    min-height: 100px;
    resize: vertical;
}

.cms-logo-upload {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.cms-logo-preview {
    width: 120px;
    height: 120px;
    border: 2px dashed rgba(12, 42, 54, 0.2);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(12, 42, 54, 0.02);
    overflow: hidden;
}

.cms-logo-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.cms-logo-preview i {
    font-size: 2.5rem;
    color: var(--text-muted);
    opacity: 0.5;
}

.cms-logo-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.cms-social-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.cms-social-item:last-child {
    margin-bottom: 0;
}

.cms-social-icon {
    width: 44px;
    height: 44px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
}

.cms-social-icon.facebook { background: #1877f2; }
.cms-social-icon.instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.cms-social-icon.twitter { background: #1da1f2; }

.cms-social-input {
    flex: 1;
}

.cms-save-bar {
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%);
    border-top: 1px solid rgba(25, 135, 84, 0.2);
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.cms-tab-content {
    display: none;
}

.cms-tab-content.active {
    display: block;
}

[data-theme="dark"] .cms-settings-nav,
[data-theme="dark"] .cms-settings-panel {
    background: rgba(22, 37, 43, 0.9);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-settings-panel-header {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.06);
}

[data-theme="dark"] .cms-settings-input {
    background: rgba(22, 37, 43, 0.8);
    border-color: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

[data-theme="dark"] .cms-logo-preview {
    border-color: rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.03);
}

@media (max-width: 992px) {
    .cms-settings-container {
        grid-template-columns: 1fr;
    }
    
    .cms-settings-nav {
        display: flex;
        overflow-x: auto;
        gap: 0.5rem;
        position: static;
    }
    
    .cms-settings-nav-item {
        white-space: nowrap;
        flex-shrink: 0;
    }
    
    .cms-settings-row {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .cms-settings-label {
        flex: none;
        padding-top: 0;
    }
}
</style>
@endpush

@section('content')
<div class="cms-settings-header">
    <h1><i class="bi bi-sliders"></i> Site Settings</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ url('/admin/developer/settings') }}" method="POST">
    @csrf
    
    <div class="cms-settings-container">
        <nav class="cms-settings-nav">
            <a href="#general" class="cms-settings-nav-item active" data-tab="general">
                <i class="bi bi-house"></i>
                <span>General</span>
            </a>
            <a href="#contact" class="cms-settings-nav-item" data-tab="contact">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
            <a href="#social" class="cms-settings-nav-item" data-tab="social">
                <i class="bi bi-share"></i>
                <span>Social Media</span>
            </a>
        </nav>
        
        <div class="cms-settings-panel">
            <div class="cms-tab-content active" id="general">
                <div class="cms-settings-panel-header">
                    <h3><i class="bi bi-house"></i> General Settings</h3>
                    <p>Configure your website's basic information</p>
                </div>
                <div class="cms-settings-panel-body">
                    <div class="cms-settings-row">
                        <div class="cms-settings-label">
                            <h6>Site Name</h6>
                            <p>Your website's display name</p>
                        </div>
                        <div class="cms-settings-field">
                            <input type="text" name="site_name" class="cms-settings-input" 
                                   value="{{ $settings['general']['site_name'] ?? 'Culinaire' }}"
                                   placeholder="Enter site name">
                        </div>
                    </div>
                    
                    <div class="cms-settings-row">
                        <div class="cms-settings-label">
                            <h6>Tagline</h6>
                            <p>A short description of your site</p>
                        </div>
                        <div class="cms-settings-field">
                            <input type="text" name="site_tagline" class="cms-settings-input" 
                                   value="{{ $settings['general']['site_tagline'] ?? '' }}"
                                   placeholder="Your site tagline">
                        </div>
                    </div>
                    
                    <div class="cms-settings-row">
                        <div class="cms-settings-label">
                            <h6>Site Logo</h6>
                            <p>Upload your logo image</p>
                        </div>
                        <div class="cms-settings-field">
                            <div class="cms-logo-upload">
                                <div class="cms-logo-preview" id="logoPreview">
                                    @if(isset($settings['general']['site_logo']))
                                        <img src="{{ $settings['general']['site_logo'] }}" alt="Logo">
                                    @else
                                        <i class="bi bi-image"></i>
                                    @endif
                                </div>
                                <div class="cms-logo-actions">
                                    <a href="{{ url('/admin/developer/media') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-folder2-open me-1"></i>Choose from Media
                                    </a>
                                    <input type="hidden" name="site_logo" value="{{ $settings['general']['site_logo'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cms-tab-content" id="contact">
                <div class="cms-settings-panel-header">
                    <h3><i class="bi bi-envelope"></i> Contact Information</h3>
                    <p>Set your contact details for customers</p>
                </div>
                <div class="cms-settings-panel-body">
                    <div class="cms-settings-row">
                        <div class="cms-settings-label">
                            <h6>Email Address</h6>
                            <p>Primary contact email</p>
                        </div>
                        <div class="cms-settings-field">
                            <input type="email" name="contact_email" class="cms-settings-input" 
                                   value="{{ $settings['contact']['contact_email'] ?? '' }}"
                                   placeholder="contact@example.com">
                        </div>
                    </div>
                    
                    <div class="cms-settings-row">
                        <div class="cms-settings-label">
                            <h6>Phone Number</h6>
                            <p>Main contact number</p>
                        </div>
                        <div class="cms-settings-field">
                            <input type="tel" name="contact_phone" class="cms-settings-input" 
                                   value="{{ $settings['contact']['contact_phone'] ?? '' }}"
                                   placeholder="+62 xxx xxxx xxxx">
                        </div>
                    </div>
                    
                    <div class="cms-settings-row">
                        <div class="cms-settings-label">
                            <h6>Address</h6>
                            <p>Physical location</p>
                        </div>
                        <div class="cms-settings-field">
                            <textarea name="contact_address" class="cms-settings-input cms-settings-textarea" 
                                      placeholder="Enter your full address">{{ $settings['contact']['contact_address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="cms-tab-content" id="social">
                <div class="cms-settings-panel-header">
                    <h3><i class="bi bi-share"></i> Social Media Links</h3>
                    <p>Connect your social media profiles</p>
                </div>
                <div class="cms-settings-panel-body">
                    <div class="cms-social-item">
                        <div class="cms-social-icon facebook">
                            <i class="bi bi-facebook"></i>
                        </div>
                        <div class="cms-social-input">
                            <input type="url" name="social_facebook" class="cms-settings-input" 
                                   value="{{ $settings['social']['social_facebook'] ?? '' }}"
                                   placeholder="https://facebook.com/yourpage">
                        </div>
                    </div>
                    
                    <div class="cms-social-item">
                        <div class="cms-social-icon instagram">
                            <i class="bi bi-instagram"></i>
                        </div>
                        <div class="cms-social-input">
                            <input type="url" name="social_instagram" class="cms-settings-input" 
                                   value="{{ $settings['social']['social_instagram'] ?? '' }}"
                                   placeholder="https://instagram.com/yourprofile">
                        </div>
                    </div>
                    
                    <div class="cms-social-item">
                        <div class="cms-social-icon twitter">
                            <i class="bi bi-twitter-x"></i>
                        </div>
                        <div class="cms-social-input">
                            <input type="url" name="social_twitter" class="cms-settings-input" 
                                   value="{{ $settings['social']['social_twitter'] ?? '' }}"
                                   placeholder="https://twitter.com/yourhandle">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="cms-save-bar">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-2"></i>Save Settings
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.cms-settings-nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        
        document.querySelectorAll('.cms-settings-nav-item').forEach(i => i.classList.remove('active'));
        document.querySelectorAll('.cms-tab-content').forEach(c => c.classList.remove('active'));
        
        this.classList.add('active');
        const tabId = this.dataset.tab;
        document.getElementById(tabId)?.classList.add('active');
    });
});
</script>
@endpush
