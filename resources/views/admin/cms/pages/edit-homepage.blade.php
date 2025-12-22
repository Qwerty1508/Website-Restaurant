@extends('layouts.admin')

@section('title', 'Edit Homepage')

@push('styles')
<style>
.cms-edit-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.cms-edit-header h1 {
    margin: 0;
    font-size: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-edit-header h1 i {
    color: var(--accent);
}

.cms-section-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.25rem;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.cms-section-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.03) 0%, rgba(200, 155, 58, 0.05) 100%);
    border-bottom: 1px solid rgba(12, 42, 54, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.cms-section-header h3 {
    margin: 0;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.cms-section-header h3 i {
    color: var(--accent);
}

.cms-section-body {
    padding: 1.5rem;
}

.cms-form-group {
    margin-bottom: 1.25rem;
}

.cms-form-group:last-child {
    margin-bottom: 0;
}

.cms-form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--primary);
}

.cms-form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid rgba(12, 42, 54, 0.1);
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.cms-form-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(200, 155, 58, 0.15);
    outline: none;
}

.cms-form-textarea {
    min-height: 120px;
    resize: vertical;
}

.cms-save-bar {
    position: sticky;
    bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

[data-theme="dark"] .cms-section-card {
    background: rgba(22, 37, 43, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-section-header {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.06);
}

[data-theme="dark"] .cms-form-input {
    background: rgba(22, 37, 43, 0.8);
    border-color: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

[data-theme="dark"] .cms-form-label {
    color: var(--text-light);
}

[data-theme="dark"] .cms-save-bar {
    background: rgba(22, 37, 43, 0.95);
}
</style>
@endpush

@section('content')
<div class="cms-edit-header">
    <h1><i class="bi bi-house-heart"></i> Edit Homepage</h1>
    <a href="{{ url('/admin/developer') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ url('/admin/developer/pages/homepage') }}" method="POST">
    @csrf

    <div class="cms-section-card">
        <div class="cms-section-header">
            <h3><i class="bi bi-image"></i> Hero Section</h3>
        </div>
        <div class="cms-section-body">
            <div class="cms-form-group">
                <label class="cms-form-label">Subtitle</label>
                <input type="text" name="hero_subtitle" class="cms-form-input" 
                       value="{{ $pageData['hero_subtitle'] ?? 'EST. 2023 • INDONESIA' }}"
                       placeholder="EST. 2023 • INDONESIA">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Title Line 1</label>
                <input type="text" name="hero_title_1" class="cms-form-input" 
                       value="{{ $pageData['hero_title_1'] ?? 'Taste' }}"
                       placeholder="Taste">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Title Line 2</label>
                <input type="text" name="hero_title_2" class="cms-form-input" 
                       value="{{ $pageData['hero_title_2'] ?? 'the' }}"
                       placeholder="the">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Title Line 3</label>
                <input type="text" name="hero_title_3" class="cms-form-input" 
                       value="{{ $pageData['hero_title_3'] ?? 'Luxury' }}"
                       placeholder="Luxury">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Description</label>
                <textarea name="hero_description" class="cms-form-input cms-form-textarea" 
                          placeholder="Hero description...">{{ $pageData['hero_description'] ?? 'Experience the finest fusion of Indonesian heritage and modern gastronomy.' }}</textarea>
            </div>
        </div>
    </div>

    <div class="cms-section-card">
        <div class="cms-section-header">
            <h3><i class="bi bi-star"></i> Featured Menu Section</h3>
        </div>
        <div class="cms-section-body">
            <div class="cms-form-group">
                <label class="cms-form-label">Section Title</label>
                <input type="text" name="featured_title" class="cms-form-input" 
                       value="{{ $pageData['featured_title'] ?? 'Best Selling Menu' }}"
                       placeholder="Best Selling Menu">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Section Description</label>
                <textarea name="featured_description" class="cms-form-input cms-form-textarea" 
                          placeholder="Description...">{{ $pageData['featured_description'] ?? 'Selected based on popularity and customer ratings' }}</textarea>
            </div>
        </div>
    </div>

    <div class="cms-section-card">
        <div class="cms-section-header">
            <h3><i class="bi bi-list-ol"></i> How to Order Section</h3>
        </div>
        <div class="cms-section-body">
            <div class="cms-form-group">
                <label class="cms-form-label">Section Title</label>
                <input type="text" name="howto_title" class="cms-form-input" 
                       value="{{ $pageData['howto_title'] ?? 'How to Order' }}"
                       placeholder="How to Order">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Section Description</label>
                <textarea name="howto_description" class="cms-form-input cms-form-textarea" 
                          placeholder="Description...">{{ $pageData['howto_description'] ?? 'Order your favorite food in 4 easy steps' }}</textarea>
            </div>
        </div>
    </div>

    <div class="cms-section-card">
        <div class="cms-section-header">
            <h3><i class="bi bi-chat-quote"></i> Testimonials Section</h3>
        </div>
        <div class="cms-section-body">
            <div class="cms-form-group">
                <label class="cms-form-label">Section Title</label>
                <input type="text" name="testimonials_title" class="cms-form-input" 
                       value="{{ $pageData['testimonials_title'] ?? 'What Our Customers Say' }}"
                       placeholder="What Our Customers Say">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Section Description</label>
                <textarea name="testimonials_description" class="cms-form-input cms-form-textarea" 
                          placeholder="Description...">{{ $pageData['testimonials_description'] ?? 'Testimonials from loyal Culinaire customers' }}</textarea>
            </div>
        </div>
    </div>

    <div class="cms-save-bar">
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary">
            <i class="bi bi-eye me-2"></i>Preview
        </a>
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
        </button>
    </div>
</form>
@endsection
