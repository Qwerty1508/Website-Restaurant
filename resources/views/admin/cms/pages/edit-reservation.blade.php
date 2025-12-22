@extends('layouts.admin')

@section('title', 'Edit Reservation Page')

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
    <h1><i class="bi bi-calendar-check"></i> Edit Reservation Page</h1>
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

<form action="{{ url('/admin/developer/pages/reservation') }}" method="POST">
    @csrf

    <div class="cms-section-card">
        <div class="cms-section-header">
            <h3><i class="bi bi-image"></i> Hero Section</h3>
        </div>
        <div class="cms-section-body">
            <div class="cms-form-group">
                <label class="cms-form-label">Page Title</label>
                <input type="text" name="hero_title" class="cms-form-input" 
                       value="{{ $pageData['hero_title'] ?? 'Reserve a Table' }}"
                       placeholder="Reserve a Table">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Page Description</label>
                <textarea name="hero_description" class="cms-form-input cms-form-textarea" 
                          placeholder="Description...">{{ $pageData['hero_description'] ?? 'Book your table now for an unforgettable dining experience.' }}</textarea>
            </div>
        </div>
    </div>

    <div class="cms-section-card">
        <div class="cms-section-header">
            <h3><i class="bi bi-card-text"></i> Booking Form</h3>
        </div>
        <div class="cms-section-body">
            <div class="cms-form-group">
                <label class="cms-form-label">Form Title</label>
                <input type="text" name="form_title" class="cms-form-input" 
                       value="{{ $pageData['form_title'] ?? 'Reservation Form' }}"
                       placeholder="Reservation Form">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Deposit Amount (Rp)</label>
                <input type="number" name="deposit_amount" class="cms-form-input" 
                       value="{{ $pageData['deposit_amount'] ?? 100000 }}"
                       placeholder="100000">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Private Room Deposit (Rp)</label>
                <input type="number" name="private_deposit" class="cms-form-input" 
                       value="{{ $pageData['private_deposit'] ?? 300000 }}"
                       placeholder="300000">
            </div>
        </div>
    </div>

    <div class="cms-section-card">
        <div class="cms-section-header">
            <h3><i class="bi bi-info-square"></i> Terms & Conditions</h3>
        </div>
        <div class="cms-section-body">
            <div class="cms-form-group">
                <label class="cms-form-label">Term 1</label>
                <input type="text" name="term_1" class="cms-form-input" 
                       value="{{ $pageData['term_1'] ?? 'Reservations can be made H-7 to H-1.' }}"
                       placeholder="Term 1">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Term 2</label>
                <input type="text" name="term_2" class="cms-form-input" 
                       value="{{ $pageData['term_2'] ?? 'Deposit is non-refundable for cancellations less than 3 hours prior.' }}"
                       placeholder="Term 2">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Term 3</label>
                <input type="text" name="term_3" class="cms-form-input" 
                       value="{{ $pageData['term_3'] ?? 'Table will be held for 15 minutes from reservation time.' }}"
                       placeholder="Term 3">
            </div>
            <div class="cms-form-group">
                <label class="cms-form-label">Term 4</label>
                <input type="text" name="term_4" class="cms-form-input" 
                       value="{{ $pageData['term_4'] ?? 'Reservation status can be viewed on My Reservations page.' }}"
                       placeholder="Term 4">
            </div>
        </div>
    </div>

    <div class="cms-save-bar">
        <a href="{{ url('/reservation') }}" target="_blank" class="btn btn-outline-primary">
            <i class="bi bi-eye me-2"></i>Preview
        </a>
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
        </button>
    </div>
</form>
@endsection
