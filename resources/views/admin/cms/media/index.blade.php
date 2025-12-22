@extends('layouts.admin')
@section('title', 'Media Library')
@push('styles')
<style>
.cms-media-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.cms-media-header h1 {
    margin: 0;
    font-size: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.cms-media-header h1 i {
    color: var(--accent);
}
.cms-dropzone {
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.08) 0%, rgba(12, 42, 54, 0.03) 100%);
    border: 3px dashed rgba(200, 155, 58, 0.4);
    border-radius: 1.5rem;
    padding: 3rem;
    text-align: center;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.cms-dropzone::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.1) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.cms-dropzone:hover,
.cms-dropzone.dragover {
    border-color: var(--accent);
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.15) 0%, rgba(12, 42, 54, 0.05) 100%);
    transform: scale(1.01);
}
.cms-dropzone:hover::before,
.cms-dropzone.dragover::before {
    opacity: 1;
}
.cms-dropzone-content {
    position: relative;
    z-index: 1;
}
.cms-dropzone-icon {
    font-size: 4rem;
    color: var(--accent);
    margin-bottom: 1rem;
    display: block;
    animation: float 3s ease-in-out infinite;
}
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
.cms-dropzone h4 {
    margin-bottom: 0.5rem;
}
.cms-dropzone p {
    color: var(--text-muted);
    margin-bottom: 1rem;
}
.cms-dropzone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}
.cms-media-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.cms-view-toggle {
    display: flex;
    background: rgba(12, 42, 54, 0.05);
    border-radius: 0.5rem;
    padding: 0.25rem;
}
.cms-view-btn {
    padding: 0.5rem 1rem;
    border: none;
    background: transparent;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.2s;
    color: var(--text-muted);
}
.cms-view-btn.active {
    background: var(--accent);
    color: var(--text-on-accent);
}
.cms-media-container {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 1.5rem;
    padding: 1.5rem;
}
.cms-media-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1.25rem;
}
.cms-media-item {
    aspect-ratio: 1;
    border-radius: 1rem;
    overflow: hidden;
    position: relative;
    background: rgba(12, 42, 54, 0.03);
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}
.cms-media-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(12, 42, 54, 0.15);
    border-color: var(--accent);
}
.cms-media-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}
.cms-media-item:hover img {
    transform: scale(1.1);
}
.cms-media-file {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(12, 42, 54, 0.05) 0%, rgba(200, 155, 58, 0.05) 100%);
}
.cms-media-file i {
    font-size: 3rem;
    color: var(--accent);
    margin-bottom: 0.5rem;
}
.cms-media-file span {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
}
.cms-media-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(12, 42, 54, 0.9) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 1rem;
}
.cms-media-item:hover .cms-media-overlay {
    opacity: 1;
}
.cms-media-name {
    color: white;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.25rem;
}
.cms-media-size {
    color: rgba(255,255,255,0.7);
    font-size: 0.75rem;
}
.cms-media-actions {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    display: flex;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.cms-media-item:hover .cms-media-actions {
    opacity: 1;
}
.cms-media-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 0.5rem;
    border: none;
    background: rgba(255, 255, 255, 0.9);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    backdrop-filter: blur(4px);
}
.cms-media-action-btn:hover {
    background: var(--accent);
    color: var(--text-on-accent);
    transform: scale(1.1);
}
.cms-media-action-btn.delete:hover {
    background: var(--danger);
    color: white;
}
.cms-upload-progress {
    display: none;
    margin-top: 1rem;
}
.cms-upload-progress.active {
    display: block;
}
.cms-progress-bar {
    height: 8px;
    background: rgba(12, 42, 54, 0.1);
    border-radius: 4px;
    overflow: hidden;
}
.cms-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent) 0%, var(--accent-hover) 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
    width: 0%;
}
.cms-empty-media {
    text-align: center;
    padding: 4rem 2rem;
}
.cms-empty-media i {
    font-size: 5rem;
    color: var(--text-muted);
    opacity: 0.3;
    margin-bottom: 1.5rem;
}
.cms-pagination {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}
[data-theme="dark"] .cms-dropzone {
    background: linear-gradient(135deg, rgba(200, 155, 58, 0.08) 0%, rgba(22, 37, 43, 0.3) 100%);
    border-color: rgba(200, 155, 58, 0.3);
}
[data-theme="dark"] .cms-media-container {
    background: rgba(22, 37, 43, 0.9);
    border-color: rgba(255, 255, 255, 0.1);
}
[data-theme="dark"] .cms-media-item {
    background: rgba(255, 255, 255, 0.05);
}
[data-theme="dark"] .cms-view-toggle {
    background: rgba(255, 255, 255, 0.05);
}
@media (max-width: 768px) {
    .cms-media-gallery {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    .cms-dropzone {
        padding: 2rem 1rem;
    }
    .cms-dropzone-icon {
        font-size: 3rem;
    }
}
</style>
@endpush
@section('content')
<div class="cms-media-header">
    <h1><i class="bi bi-images"></i> Media Library</h1>
    <span class="badge bg-secondary fs-6">{{ $media->total() }} files</span>
</div>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
<form action="{{ url('/admin/developer/media') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
    @csrf
    <div class="cms-dropzone" id="dropzone">
        <div class="cms-dropzone-content">
            <i class="bi bi-cloud-arrow-up cms-dropzone-icon"></i>
            <h4>Drop files here to upload</h4>
            <p>or click to browse your computer</p>
            <span class="btn btn-primary btn-sm">
                <i class="bi bi-folder2-open me-2"></i>Browse Files
            </span>
        </div>
        <input type="file" name="file" id="fileInput" accept="image/*,video/*,.pdf,.doc,.docx">
    </div>
    <div class="cms-upload-progress" id="uploadProgress">
        <div class="cms-progress-bar">
            <div class="cms-progress-fill" id="progressFill"></div>
        </div>
        <small class="text-muted mt-1 d-block">Uploading...</small>
    </div>
</form>
<div class="cms-media-toolbar">
    <div class="cms-view-toggle">
        <button class="cms-view-btn active" data-view="grid">
            <i class="bi bi-grid-3x3-gap"></i>
        </button>
        <button class="cms-view-btn" data-view="list">
            <i class="bi bi-list"></i>
        </button>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select form-select-sm" style="width: auto;">
            <option value="">All folders</option>
            @foreach($folders as $folder)
            <option value="{{ $folder }}">{{ ucfirst($folder) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="cms-media-container">
    @if($media->count() > 0)
    <div class="cms-media-gallery" id="mediaGallery">
        @foreach($media as $item)
        <div class="cms-media-item" data-id="{{ $item->id }}">
            @if($item->type === 'image')
                <img src="{{ $item->url }}" alt="{{ $item->alt_text ?? $item->original_name }}" loading="lazy">
            @else
                <div class="cms-media-file">
                    <i class="bi bi-file-earmark-{{ $item->type === 'video' ? 'play' : 'text' }}"></i>
                    <span>{{ pathinfo($item->original_name, PATHINFO_EXTENSION) }}</span>
                </div>
            @endif
            <div class="cms-media-overlay">
                <div class="cms-media-name">{{ $item->original_name }}</div>
                <div class="cms-media-size">{{ $item->human_size }}</div>
            </div>
            <div class="cms-media-actions">
                <button class="cms-media-action-btn" onclick="copyUrl('{{ $item->url }}')" title="Copy URL">
                    <i class="bi bi-link-45deg"></i>
                </button>
                <button class="cms-media-action-btn delete" onclick="deleteMedia({{ $item->id }})" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="cms-pagination">
        {{ $media->links() }}
    </div>
    @else
    <div class="cms-empty-media">
        <i class="bi bi-cloud-arrow-up"></i>
        <h4>No media files yet</h4>
        <p class="text-muted">Upload your first file by dragging it above or clicking the upload area</p>
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
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const uploadForm = document.getElementById('uploadForm');
const uploadProgress = document.getElementById('uploadProgress');
const progressFill = document.getElementById('progressFill');
['dragenter', 'dragover'].forEach(event => {
    dropzone?.addEventListener(event, (e) => {
        e.preventDefault();
        dropzone.classList.add('dragover');
    });
});
['dragleave', 'drop'].forEach(event => {
    dropzone?.addEventListener(event, (e) => {
        e.preventDefault();
        dropzone.classList.remove('dragover');
    });
});
dropzone?.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length) {
        fileInput.files = files;
        uploadFile(files[0]);
    }
});
fileInput?.addEventListener('change', function() {
    if (this.files.length) {
        uploadFile(this.files[0]);
    }
});
function uploadFile(file) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    uploadProgress.classList.add('active');
    progressFill.style.width = '0%';
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/cms/media', true);
    xhr.upload.addEventListener('progress', (e) => {
        if (e.lengthComputable) {
            const percent = (e.loaded / e.total) * 100;
            progressFill.style.width = percent + '%';
        }
    });
    xhr.addEventListener('load', () => {
        if (xhr.status === 200) {
            location.reload();
        } else {
            alert('Upload failed. Please try again.');
            uploadProgress.classList.remove('active');
        }
    });
    xhr.send(formData);
}
function copyUrl(url) {
    navigator.clipboard.writeText(window.location.origin + url);
    alert('URL copied to clipboard!');
}
function deleteMedia(id) {
    if (confirm('Are you sure you want to delete this file?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/cms/media/${id}`;
        form.submit();
    }
}
document.querySelectorAll('.cms-view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.cms-view-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endpush