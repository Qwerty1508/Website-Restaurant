@extends('layouts.admin')

@section('title', 'Manage Pages')

@push('styles')
<style>
.cms-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.cms-page-header h1 {
    margin: 0;
    font-size: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-page-header h1 i {
    color: var(--accent);
}

.cms-pages-container {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.5rem;
    overflow: hidden;
}

.cms-pages-toolbar {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.03) 0%, rgba(200, 155, 58, 0.05) 100%);
    border-bottom: 1px solid rgba(12, 42, 54, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.cms-search-box {
    position: relative;
    max-width: 300px;
    width: 100%;
}

.cms-search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid rgba(12, 42, 54, 0.1);
    border-radius: 0.75rem;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
}

.cms-search-box input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(200, 155, 58, 0.15);
    outline: none;
}

.cms-search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
}

.cms-page-row {
    display: flex;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(12, 42, 54, 0.06);
    transition: all 0.3s ease;
    gap: 1rem;
}

.cms-page-row:hover {
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.05) 0%, rgba(12, 42, 54, 0.02) 100%);
}

.cms-page-row:last-child {
    border-bottom: none;
}

.cms-page-drag {
    cursor: grab;
    padding: 0.5rem;
    color: var(--text-muted);
    opacity: 0.5;
    transition: opacity 0.2s;
}

.cms-page-row:hover .cms-page-drag {
    opacity: 1;
}

.cms-page-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.15) 0%, rgba(200, 155, 58, 0.05) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--accent);
    font-size: 1.25rem;
    flex-shrink: 0;
}

.cms-page-details {
    flex-grow: 1;
    min-width: 0;
}

.cms-page-name {
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.cms-page-slug {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: 'Monaco', 'Consolas', monospace;
}

.cms-page-stats {
    display: flex;
    gap: 1.5rem;
    flex-shrink: 0;
}

.cms-page-stat {
    text-align: center;
}

.cms-page-stat-value {
    font-weight: 700;
    font-size: 1rem;
    color: var(--primary);
}

.cms-page-stat-label {
    font-size: 0.7rem;
    color: var(--text-muted);
    text-transform: uppercase;
}

.cms-page-status {
    flex-shrink: 0;
}

.cms-toggle {
    position: relative;
    width: 50px;
    height: 26px;
    display: inline-block;
}

.cms-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.cms-toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--gray-400);
    transition: 0.3s;
    border-radius: 26px;
}

.cms-toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.cms-toggle input:checked + .cms-toggle-slider {
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%);
}

.cms-toggle input:checked + .cms-toggle-slider:before {
    transform: translateX(24px);
}

.cms-page-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

.cms-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 0.5rem;
    border: none;
    background: rgba(12, 42, 54, 0.05);
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.cms-action-btn:hover {
    background: var(--accent);
    color: var(--text-on-accent);
    transform: scale(1.1);
}

.cms-action-btn.delete:hover {
    background: var(--danger);
    color: white;
}

.cms-empty-pages {
    padding: 4rem 2rem;
    text-align: center;
}

.cms-empty-pages i {
    font-size: 4rem;
    color: var(--text-muted);
    opacity: 0.3;
    margin-bottom: 1rem;
}

.cms-empty-pages h4 {
    margin-bottom: 0.5rem;
}

.cms-empty-pages p {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
}

[data-theme="dark"] .cms-pages-container {
    background: rgba(22, 37, 43, 0.9);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-pages-toolbar {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.06);
}

[data-theme="dark"] .cms-search-box input {
    background: rgba(22, 37, 43, 0.8);
    border-color: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

[data-theme="dark"] .cms-page-row {
    border-color: rgba(255, 255, 255, 0.06);
}

[data-theme="dark"] .cms-page-name {
    color: var(--text-light);
}

[data-theme="dark"] .cms-page-stat-value {
    color: var(--text-light);
}

[data-theme="dark"] .cms-action-btn {
    background: rgba(255, 255, 255, 0.08);
}

@media (max-width: 768px) {
    .cms-page-row {
        flex-wrap: wrap;
    }
    
    .cms-page-stats {
        width: 100%;
        justify-content: flex-start;
        margin-top: 0.5rem;
        gap: 1rem;
    }
    
    .cms-page-actions {
        margin-top: 0.5rem;
    }
    
    .cms-page-drag {
        display: none;
    }
}
</style>
@endpush

@section('content')
<div class="cms-page-header">
    <h1><i class="bi bi-file-richtext"></i> Pages</h1>
    <a href="{{ url('/admin/developer/pages/create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Page
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="cms-pages-container">
    <div class="cms-pages-toolbar">
        <div class="cms-search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search pages..." id="searchPages">
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-secondary">{{ $pages->count() }} pages</span>
        </div>
    </div>
    
    @if($pages->count() > 0)
    <div class="cms-pages-list" id="pagesList">
        @foreach($pages as $page)
        <div class="cms-page-row" data-id="{{ $page->id }}" data-title="{{ strtolower($page->title) }}">
            <div class="cms-page-drag">
                <i class="bi bi-grip-vertical"></i>
            </div>
            <div class="cms-page-icon-wrap">
                <i class="bi bi-file-text"></i>
            </div>
            <div class="cms-page-details">
                <div class="cms-page-name">{{ $page->title }}</div>
                <div class="cms-page-slug">/{{ $page->slug }}</div>
            </div>
            <div class="cms-page-stats d-none d-md-flex">
                <div class="cms-page-stat">
                    <div class="cms-page-stat-value">{{ $page->sections->count() }}</div>
                    <div class="cms-page-stat-label">Sections</div>
                </div>
            </div>
            <div class="cms-page-status">
                <label class="cms-toggle" title="{{ $page->is_published ? 'Published' : 'Draft' }}">
                    <input type="checkbox" {{ $page->is_published ? 'checked' : '' }} onchange="togglePublish({{ $page->id }}, this.checked)">
                    <span class="cms-toggle-slider"></span>
                </label>
            </div>
            <div class="cms-page-actions">
                <a href="{{ url('/admin/developer/pages/' . $page->id . '/edit') }}" class="cms-action-btn" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <button class="cms-action-btn delete" title="Delete" onclick="confirmDelete({{ $page->id }}, '{{ $page->title }}')">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="cms-empty-pages">
        <i class="bi bi-file-earmark-plus"></i>
        <h4>No pages yet</h4>
        <p>Start building your website by creating your first page</p>
        <a href="{{ url('/admin/developer/pages/create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Create First Page
        </a>
    </div>
    @endif
</div>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
document.getElementById('searchPages')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.cms-page-row').forEach(row => {
        const title = row.dataset.title;
        row.style.display = title.includes(search) ? 'flex' : 'none';
    });
});

function togglePublish(id, status) {
    fetch(`/admin/cms/pages/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ is_published: status })
    }).then(response => {
        if (!response.ok) {
            location.reload();
        }
    });
}

function confirmDelete(id, title) {
    if (confirm(`Are you sure you want to delete "${title}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/cms/pages/${id}`;
        form.submit();
    }
}
</script>
@endpush
