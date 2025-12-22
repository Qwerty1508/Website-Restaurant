@extends('layouts.admin')

@section('title', isset($page) ? 'Edit Page' : 'Create Page')

@push('styles')
<style>
.cms-form-container {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 1.5rem;
    align-items: start;
}

.cms-form-main {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.5rem;
    padding: 2rem;
}

.cms-form-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.cms-form-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1rem;
    overflow: hidden;
}

.cms-form-card-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.03) 0%, rgba(200, 155, 58, 0.05) 100%);
    border-bottom: 1px solid rgba(12, 42, 54, 0.08);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.cms-form-card-header i {
    color: var(--accent);
}

.cms-form-card-body {
    padding: 1.25rem;
}

.cms-form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.cms-form-header h1 {
    margin: 0;
    font-size: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-form-header h1 i {
    color: var(--accent);
}

.cms-form-group {
    margin-bottom: 1.5rem;
}

.cms-form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--primary);
}

.cms-form-label small {
    font-weight: 400;
    color: var(--text-muted);
}

.cms-form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid rgba(12, 42, 54, 0.1);
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.cms-form-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(200, 155, 58, 0.15);
    outline: none;
}

.cms-form-input.title-input {
    font-size: 1.5rem;
    font-weight: 600;
    font-family: var(--font-heading);
}

.cms-form-textarea {
    min-height: 120px;
    resize: vertical;
}

.cms-slug-preview {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
    font-family: 'Monaco', 'Consolas', monospace;
}

.cms-slug-preview span {
    color: var(--accent);
}

.cms-content-editor {
    border: 2px solid rgba(12, 42, 54, 0.1);
    border-radius: 0.75rem;
    overflow: hidden;
    min-height: 400px;
}

.cms-editor-toolbar {
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.03) 0%, rgba(200, 155, 58, 0.05) 100%);
    padding: 0.75rem;
    border-bottom: 1px solid rgba(12, 42, 54, 0.08);
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.cms-editor-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: transparent;
    border-radius: 0.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    transition: all 0.2s;
}

.cms-editor-btn:hover {
    background: var(--accent);
    color: var(--text-on-accent);
}

.cms-editor-content {
    padding: 1.25rem;
    min-height: 350px;
    outline: none;
}

.cms-editor-content:focus {
    background: rgba(200, 155, 58, 0.02);
}

.cms-publish-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%);
    border-radius: 0.75rem;
    margin-bottom: 1rem;
}

.cms-publish-info h6 {
    margin: 0 0 0.25rem;
    font-weight: 600;
}

.cms-publish-info small {
    color: var(--text-muted);
}

.cms-template-select {
    display: grid;
    gap: 0.5rem;
}

.cms-template-option {
    padding: 0.75rem 1rem;
    border: 2px solid rgba(12, 42, 54, 0.1);
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cms-template-option:hover {
    border-color: var(--accent);
    background: rgba(200, 155, 58, 0.05);
}

.cms-template-option.selected {
    border-color: var(--accent);
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.15) 0%, rgba(200, 155, 58, 0.05) 100%);
}

.cms-template-option input {
    display: none;
}

.cms-template-option i {
    font-size: 1.25rem;
    color: var(--accent);
}

.cms-btn-group {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
}

.cms-btn-group .btn {
    flex: 1;
}

[data-theme="dark"] .cms-form-main,
[data-theme="dark"] .cms-form-card {
    background: rgba(22, 37, 43, 0.9);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-form-card-header {
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

[data-theme="dark"] .cms-content-editor {
    border-color: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .cms-editor-toolbar {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.06);
}

[data-theme="dark"] .cms-editor-content {
    color: var(--text-light);
}

[data-theme="dark"] .cms-template-option {
    border-color: rgba(255, 255, 255, 0.1);
}

@media (max-width: 992px) {
    .cms-form-container {
        grid-template-columns: 1fr;
    }
    
    .cms-form-sidebar {
        order: -1;
    }
}
</style>
@endpush

@section('content')
<form action="{{ isset($page) ? url('/admin/developer/pages/' . $page->id) : url('/admin/developer/pages') }}" method="POST">
    @csrf
    @if(isset($page))
        @method('PUT')
    @endif
    
    <div class="cms-form-header">
        <h1>
            <i class="bi bi-{{ isset($page) ? 'pencil-square' : 'plus-circle' }}"></i>
            {{ isset($page) ? 'Edit Page' : 'Create New Page' }}
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ url('/admin/developer/pages') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-2"></i>{{ isset($page) ? 'Update' : 'Create' }} Page
            </button>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="cms-form-container">
        <div class="cms-form-main">
            <div class="cms-form-group">
                <label class="cms-form-label">Page Title</label>
                <input type="text" name="title" class="cms-form-input title-input" 
                       value="{{ old('title', $page->title ?? '') }}" 
                       placeholder="Enter page title..." required
                       id="pageTitle">
                <div class="cms-slug-preview">
                    URL: /<span id="slugPreview">{{ old('slug', $page->slug ?? 'page-url') }}</span>
                </div>
            </div>
            
            <input type="hidden" name="slug" id="pageSlug" value="{{ old('slug', $page->slug ?? '') }}">
            
            <div class="cms-form-group">
                <label class="cms-form-label">Page Content</label>
                <div class="cms-content-editor">
                    <div class="cms-editor-toolbar">
                        <button type="button" class="cms-editor-btn" onclick="execCmd('bold')" title="Bold">
                            <i class="bi bi-type-bold"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('italic')" title="Italic">
                            <i class="bi bi-type-italic"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('underline')" title="Underline">
                            <i class="bi bi-type-underline"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('formatBlock', 'h2')" title="Heading">
                            <i class="bi bi-type-h2"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('formatBlock', 'h3')" title="Subheading">
                            <i class="bi bi-type-h3"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('insertUnorderedList')" title="Bullet List">
                            <i class="bi bi-list-ul"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('insertOrderedList')" title="Numbered List">
                            <i class="bi bi-list-ol"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('justifyLeft')" title="Align Left">
                            <i class="bi bi-text-left"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="execCmd('justifyCenter')" title="Align Center">
                            <i class="bi bi-text-center"></i>
                        </button>
                        <button type="button" class="cms-editor-btn" onclick="insertLink()" title="Insert Link">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>
                    <div class="cms-editor-content" contenteditable="true" id="contentEditor">
                        {!! old('content.body', $page->content['body'] ?? '<p>Start writing your content here...</p>') !!}
                    </div>
                </div>
                <input type="hidden" name="content[body]" id="contentBody">
            </div>
        </div>
        
        <div class="cms-form-sidebar">
            <div class="cms-form-card">
                <div class="cms-form-card-header">
                    <i class="bi bi-gear"></i> Publishing
                </div>
                <div class="cms-form-card-body">
                    <div class="cms-publish-toggle">
                        <div class="cms-publish-info">
                            <h6>Publish Status</h6>
                            <small>Make this page visible</small>
                        </div>
                        <label class="cms-toggle">
                            <input type="checkbox" name="is_published" value="1" 
                                   {{ old('is_published', $page->is_published ?? false) ? 'checked' : '' }}>
                            <span class="cms-toggle-slider"></span>
                        </label>
                    </div>
                    <div class="cms-btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Save
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="cms-form-card">
                <div class="cms-form-card-header">
                    <i class="bi bi-layout-text-window"></i> Template
                </div>
                <div class="cms-form-card-body">
                    <div class="cms-template-select">
                        <label class="cms-template-option {{ old('template', $page->template ?? 'default') == 'default' ? 'selected' : '' }}">
                            <input type="radio" name="template" value="default" 
                                   {{ old('template', $page->template ?? 'default') == 'default' ? 'checked' : '' }}>
                            <i class="bi bi-file-text"></i>
                            <span>Default</span>
                        </label>
                        <label class="cms-template-option {{ old('template', $page->template ?? '') == 'full-width' ? 'selected' : '' }}">
                            <input type="radio" name="template" value="full-width"
                                   {{ old('template', $page->template ?? '') == 'full-width' ? 'checked' : '' }}>
                            <i class="bi bi-arrows-fullscreen"></i>
                            <span>Full Width</span>
                        </label>
                        <label class="cms-template-option {{ old('template', $page->template ?? '') == 'sidebar' ? 'selected' : '' }}">
                            <input type="radio" name="template" value="sidebar"
                                   {{ old('template', $page->template ?? '') == 'sidebar' ? 'checked' : '' }}>
                            <i class="bi bi-layout-sidebar"></i>
                            <span>With Sidebar</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="cms-form-card">
                <div class="cms-form-card-header">
                    <i class="bi bi-search"></i> SEO Settings
                </div>
                <div class="cms-form-card-body">
                    <div class="cms-form-group mb-3">
                        <label class="cms-form-label">Meta Title <small>(optional)</small></label>
                        <input type="text" name="meta_title" class="cms-form-input" 
                               value="{{ old('meta_title', $page->meta_title ?? '') }}"
                               placeholder="SEO title...">
                    </div>
                    <div class="cms-form-group mb-0">
                        <label class="cms-form-label">Meta Description <small>(optional)</small></label>
                        <textarea name="meta_description" class="cms-form-input cms-form-textarea" 
                                  placeholder="SEO description..." rows="3">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const titleInput = document.getElementById('pageTitle');
const slugPreview = document.getElementById('slugPreview');
const slugInput = document.getElementById('pageSlug');
const contentEditor = document.getElementById('contentEditor');
const contentBody = document.getElementById('contentBody');

titleInput?.addEventListener('input', function() {
    const slug = this.value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    slugPreview.textContent = slug || 'page-url';
    slugInput.value = slug;
});

document.querySelector('form')?.addEventListener('submit', function() {
    if (contentEditor && contentBody) {
        contentBody.value = contentEditor.innerHTML;
    }
});

function execCmd(command, value = null) {
    document.execCommand(command, false, value);
    contentEditor.focus();
}

function insertLink() {
    const url = prompt('Enter URL:');
    if (url) {
        execCmd('createLink', url);
    }
}

document.querySelectorAll('.cms-template-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.cms-template-option').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
    });
});
</script>
@endpush
