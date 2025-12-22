@extends('layouts.admin')

@section('title', 'CMS Dashboard')

@push('styles')
<style>
.cms-hero {
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.1) 0%, rgba(12, 42, 54, 0.05) 100%);
    border-radius: 1.5rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.cms-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(200, 155, 58, 0.15) 0%, transparent 70%);
    animation: pulse-slow 4s ease-in-out infinite;
}

.cms-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(12, 42, 54, 0.1) 0%, transparent 70%);
    animation: pulse-slow 5s ease-in-out infinite reverse;
}

@keyframes pulse-slow {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.cms-hero-content {
    position: relative;
    z-index: 1;
}

.cms-hero h1 {
    font-size: 2.5rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.cms-stat-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.25rem;
    padding: 1.75rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.cms-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent), var(--primary));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.cms-stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(12, 42, 54, 0.15);
}

.cms-stat-card:hover::before {
    transform: scaleX(1);
}

.cms-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 1rem;
    position: relative;
}

.cms-stat-icon.pages {
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.2) 0%, rgba(200, 155, 58, 0.1) 100%);
    color: var(--accent);
}

.cms-stat-icon.published {
    background: linear-gradient(135deg, rgba(25, 135, 84, 0.2) 0%, rgba(25, 135, 84, 0.1) 100%);
    color: #198754;
}

.cms-stat-icon.media {
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.2) 0%, rgba(13, 110, 253, 0.1) 100%);
    color: #0d6efd;
}

.cms-stat-icon.sections {
    background: linear-gradient(135deg, rgba(111, 66, 193, 0.2) 0%, rgba(111, 66, 193, 0.1) 100%);
    color: #6f42c1;
}

.cms-stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.cms-stat-label {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
}

.cms-quick-action {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(200, 155, 58, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    display: block;
    color: inherit;
}

.cms-quick-action:hover {
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%);
    border-color: var(--accent);
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 35px rgba(200, 155, 58, 0.3);
    color: var(--text-on-accent);
}

.cms-quick-action:hover i,
.cms-quick-action:hover span {
    color: var(--text-on-accent);
}

.cms-quick-action i {
    font-size: 2rem;
    margin-bottom: 0.75rem;
    display: block;
    color: var(--accent);
    transition: color 0.3s ease;
}

.cms-quick-action span {
    font-weight: 600;
    display: block;
    transition: color 0.3s ease;
}

.cms-recent-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.25rem;
    overflow: hidden;
}

.cms-recent-card .card-header {
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.03) 0%, rgba(200, 155, 58, 0.05) 100%);
    border-bottom: 1px solid rgba(12, 42, 54, 0.08);
    padding: 1.25rem 1.5rem;
}

.cms-recent-card .card-header h5 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-recent-card .card-header h5 i {
    color: var(--accent);
}

.cms-page-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(12, 42, 54, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.2s ease;
}

.cms-page-item:hover {
    background: rgba(200, 155, 58, 0.05);
}

.cms-page-item:last-child {
    border-bottom: none;
}

.cms-page-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.cms-page-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.15) 0%, rgba(200, 155, 58, 0.05) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--accent);
}

.cms-page-title {
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.125rem;
}

.cms-page-meta {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.cms-status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.cms-status-badge.published {
    background: rgba(25, 135, 84, 0.15);
    color: #198754;
}

.cms-status-badge.draft {
    background: rgba(108, 117, 125, 0.15);
    color: #6c757d;
}

.cms-media-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
}

.cms-media-thumb {
    aspect-ratio: 1;
    border-radius: 0.75rem;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
}

.cms-media-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.cms-media-thumb:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(12, 42, 54, 0.2);
}

.cms-media-thumb:hover img {
    transform: scale(1.1);
}

.cms-media-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 50%, rgba(12, 42, 54, 0.8) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 0.75rem;
}

.cms-media-thumb:hover .cms-media-overlay {
    opacity: 1;
}

.cms-media-overlay span {
    color: white;
    font-size: 0.75rem;
    font-weight: 500;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.cms-empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--text-muted);
}

.cms-empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

[data-theme="dark"] .cms-stat-card {
    background: rgba(22, 37, 43, 0.8);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-stat-number {
    color: var(--text-light);
}

[data-theme="dark"] .cms-quick-action {
    background: rgba(22, 37, 43, 0.8);
    border-color: rgba(200, 155, 58, 0.3);
}

[data-theme="dark"] .cms-recent-card {
    background: rgba(22, 37, 43, 0.9);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-recent-card .card-header {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.06);
}

[data-theme="dark"] .cms-page-item {
    border-color: rgba(255, 255, 255, 0.06);
}

[data-theme="dark"] .cms-page-title {
    color: var(--text-light);
}

[data-theme="dark"] .cms-hero {
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.08) 0%, rgba(22, 37, 43, 0.3) 100%);
}

[data-theme="dark"] .cms-hero h1 {
    background: linear-gradient(135deg, var(--accent) 0%, var(--text-light) 100%);
    -webkit-background-clip: text;
    background-clip: text;
}

@media (max-width: 768px) {
    .cms-hero {
        padding: 1.5rem;
    }
    
    .cms-hero h1 {
        font-size: 1.75rem;
    }
    
    .cms-stat-card {
        padding: 1.25rem;
    }
    
    .cms-stat-number {
        font-size: 2rem;
    }
    
    .cms-stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }
    
    .cms-media-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endpush

@section('content')
<div class="cms-hero">
    <div class="cms-hero-content">
        <h1><i class="bi bi-collection me-2"></i>Content Management System</h1>
        <p class="text-muted mb-0">Kelola konten website Anda dengan mudah dan elegan</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="cms-stat-card">
            <div class="cms-stat-icon pages">
                <i class="bi bi-file-richtext"></i>
            </div>
            <div class="cms-stat-number">{{ $stats['total_pages'] }}</div>
            <div class="cms-stat-label">Total Pages</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="cms-stat-card">
            <div class="cms-stat-icon published">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="cms-stat-number">{{ $stats['published_pages'] }}</div>
            <div class="cms-stat-label">Published</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="cms-stat-card">
            <div class="cms-stat-icon media">
                <i class="bi bi-images"></i>
            </div>
            <div class="cms-stat-number">{{ $stats['total_media'] }}</div>
            <div class="cms-stat-label">Media Files</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="cms-stat-card">
            <div class="cms-stat-icon sections">
                <i class="bi bi-layers"></i>
            </div>
            <div class="cms-stat-number">{{ $stats['total_sections'] }}</div>
            <div class="cms-stat-label">Sections</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ url('/admin/cms/pages/create') }}" class="cms-quick-action">
            <i class="bi bi-plus-circle"></i>
            <span>New Page</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ url('/admin/cms/media') }}" class="cms-quick-action">
            <i class="bi bi-upload"></i>
            <span>Upload Media</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ url('/admin/cms/pages') }}" class="cms-quick-action">
            <i class="bi bi-pencil-square"></i>
            <span>Edit Pages</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ url('/admin/cms/settings') }}" class="cms-quick-action">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="cms-recent-card h-100">
            <div class="card-header">
                <h5><i class="bi bi-clock-history"></i> Recent Pages</h5>
            </div>
            <div class="card-body p-0">
                @if($recentPages->count() > 0)
                    @foreach($recentPages as $page)
                    <div class="cms-page-item">
                        <div class="cms-page-info">
                            <div class="cms-page-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div>
                                <div class="cms-page-title">{{ $page->title }}</div>
                                <div class="cms-page-meta">Updated {{ $page->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <span class="cms-status-badge {{ $page->is_published ? 'published' : 'draft' }}">
                            {{ $page->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <div class="cms-empty-state">
                        <i class="bi bi-file-earmark"></i>
                        <p>No pages yet</p>
                        <a href="{{ url('/admin/cms/pages/create') }}" class="btn btn-primary btn-sm">Create First Page</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="cms-recent-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-images"></i> Recent Media</h5>
                <a href="{{ url('/admin/cms/media') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                @if($recentMedia->count() > 0)
                    <div class="cms-media-grid">
                        @foreach($recentMedia as $media)
                        <div class="cms-media-thumb">
                            @if($media->type === 'image')
                                <img src="{{ $media->url }}" alt="{{ $media->alt_text ?? $media->original_name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <i class="bi bi-file-earmark fs-2"></i>
                                </div>
                            @endif
                            <div class="cms-media-overlay">
                                <span>{{ $media->original_name }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="cms-empty-state">
                        <i class="bi bi-image"></i>
                        <p>No media files yet</p>
                        <a href="{{ url('/admin/cms/media') }}" class="btn btn-primary btn-sm">Upload Media</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
