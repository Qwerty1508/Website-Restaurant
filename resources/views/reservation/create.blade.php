@extends('layouts.guest')
@section('title', 'Reservasi Meja')
@section('content')
<section class="bg-gradient-primary text-white py-5">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3" data-i18n="reservation_title">{{ __('messages.reservation_title') }}</h1>
                <p class="lead opacity-75 mb-0" data-i18n="reservation_desc">
                    {{ __('messages.reservation_desc') }}
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white opacity-75" data-i18n="home">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page" data-i18n="reservation">{{ __('messages.reservation') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="section bg-cream">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card shadow-lg p-4 p-lg-5">
                    <h4 class="mb-4">
                        <i class="bi bi-calendar-plus text-gold me-2"></i>
                        <span data-i18n="form_title">{{ __('messages.form_title') }}</span>
                    </h4>
                    @guest
                    <div class="alert alert-warning d-flex align-items-center mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            <span data-i18n="login_required_reservation">{{ __('messages.login_required_reservation') }}</span> <a href="{{ url('/login') }}" class="alert-link" data-i18n="login">{{ __('messages.login') }}</a>
                        </div>
                    </div>
                    @endguest
                    <form method="POST" action="{{ url('/reservation') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label"><span data-i18n="reservation_name">{{ __('messages.reservation_name') }}</span> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                       value="{{ auth()->user()->name ?? old('name') }}" 
                                       placeholder="{{ __('messages.reservation_name_placeholder') }}" data-i18n="reservation_name_placeholder" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label"><span data-i18n="reservation_phone">{{ __('messages.reservation_phone') }}</span> <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" 
                                       value="{{ old('phone') }}" 
                                       placeholder="{{ __('messages.reservation_phone_placeholder') }}" data-i18n="reservation_phone_placeholder" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label"><span data-i18n="reservation_email">{{ __('messages.reservation_email') }}</span> <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                       value="{{ auth()->user()->email ?? old('email') }}" 
                                       placeholder="{{ __('messages.email_placeholder') }}" data-i18n="email_placeholder" required>
                                <small class="text-muted" data-i18n="reservation_email_helper">{{ __('messages.reservation_email_helper') }}</small>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label"><span data-i18n="reservation_date">{{ __('messages.reservation_date') }}</span> <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" 
                                       value="{{ old('date') }}" 
                                       min="{{ date('Y-m-d') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label"><span data-i18n="reservation_time">{{ __('messages.reservation_time') }}</span> <span class="text-danger">*</span></label>
                                <select class="form-select @error('time') is-invalid @enderror" id="time" name="time" required>
                                    <option value="" data-i18n="select_time">{{ __('messages.select_time') }}</option>
                                    <option value="10:00" {{ old('time') == '10:00' ? 'selected' : '' }}>10:00 - 11:00</option>
                                    <option value="11:00" {{ old('time') == '11:00' ? 'selected' : '' }}>11:00 - 12:00</option>
                                    <option value="12:00" {{ old('time') == '12:00' ? 'selected' : '' }}>12:00 - 13:00</option>
                                    <option value="13:00" {{ old('time') == '13:00' ? 'selected' : '' }}>13:00 - 14:00</option>
                                    <option value="14:00" {{ old('time') == '14:00' ? 'selected' : '' }}>14:00 - 15:00</option>
                                    <option value="17:00" {{ old('time') == '17:00' ? 'selected' : '' }}>17:00 - 18:00</option>
                                    <option value="18:00" {{ old('time') == '18:00' ? 'selected' : '' }}>18:00 - 19:00</option>
                                    <option value="19:00" {{ old('time') == '19:00' ? 'selected' : '' }}>19:00 - 20:00</option>
                                    <option value="20:00" {{ old('time') == '20:00' ? 'selected' : '' }}>20:00 - 21:00</option>
                                    <option value="21:00" {{ old('time') == '21:00' ? 'selected' : '' }}>21:00 - 22:00</option>
                                </select>
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="guests" class="form-label"><span data-i18n="reservation_guests">{{ __('messages.reservation_guests') }}</span> <span class="text-danger">*</span></label>
                                <select class="form-select @error('guests') is-invalid @enderror" id="guests" name="guests" required>
                                    <option value="" data-i18n="select_guests">{{ __('messages.select_guests') }}</option>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>{{ $i }} <span data-i18n="x_people">{{ __('messages.x_people') }}</span></option>
                                    @endfor
                                </select>
                                @error('guests')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="table" class="form-label" data-i18n="reservation_table">{{ __('messages.reservation_table') }}</label>
                                <select class="form-select" id="table" name="table_id">
                                    <option value="" data-i18n="auto_table">{{ __('messages.auto_table') }}</option>
                                    <option value="1" data-i18n="table_1_label">{{ __('messages.table_1_label') }}</option>
                                    <option value="2" data-i18n="table_2_label">{{ __('messages.table_2_label') }}</option>
                                    <option value="3" data-i18n="table_3_label">{{ __('messages.table_3_label') }}</option>
                                    <option value="4" data-i18n="table_4_label">{{ __('messages.table_4_label') }}</option>
                                    <option value="5" data-i18n="table_5_label">{{ __('messages.table_5_label') }}</option>
                                    <option value="6" data-i18n="table_6_label">{{ __('messages.table_6_label') }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="notes" class="form-label" data-i18n="special_request">{{ __('messages.special_request') }}</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="{{ __('messages.notes_placeholder') }}" data-i18n="notes_placeholder">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="payment_proof_file" class="form-label"><span data-i18n="payment_proof">{{ __('messages.payment_proof') }}</span> <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" 
                                       id="payment_proof_file" accept="image/*">
                                <input type="hidden" name="payment_proof" id="payment_proof_url" required>
                                <div class="mt-3 p-3 bg-light rounded">
                                    <label class="form-label fw-semibold mb-2">
                                        <i class="bi bi-sliders me-1"></i>Mode Upload:
                                    </label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="uploadMode" id="modeOriginal" value="original" checked>
                                            <label class="form-check-label" for="modeOriginal">
                                                <strong>🖼️ Original</strong>
                                                <small class="text-muted d-block">Resolusi & ukuran asli</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="uploadMode" id="modeCompressed" value="compressed">
                                            <label class="form-check-label" for="modeCompressed">
                                                <strong>⚡ Cepat</strong>
                                                <small class="text-muted d-block">Kompres 98% (5x lebih cepat)</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('payment_proof')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div id="uploadProgressContainer" class="mt-2"></div>
                                <div id="paymentPreviewContainer" class="mt-2" style="display: none;">
                                    <label class="form-label small" data-i18n="preview_label">{{ __('messages.preview_label') }}</label>
                                    <div class="border rounded p-2">
                                        <img id="paymentPreview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-4 d-flex">
                            <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                            <div>
                                <strong data-i18n="deposit_info_title">{{ __('messages.deposit_info_title') }}</strong>
                                <p class="mb-2 small">
                                    <span data-i18n="deposit_info_desc">{{ __('messages.deposit_info_desc') }}</span> 
                                    <strong class="text-primary">Rp 100.000</strong> ke:
                                </p>
                                <ul class="list-unstyled small mb-0">
                                    <li><strong>Bank BCA:</strong> 1234567890</li>
                                    <li><strong>A/N:</strong> PT Culinaire Indonesia</li>
                                </ul>
                            </div>
                        </div>
                        @auth
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
                            <i class="bi bi-calendar-check me-2"></i><span data-i18n="make_reservation_btn">{{ __('messages.make_reservation_btn') }}</span>
                        </button>
                        @else
                        <a href="{{ url('/login') }}" class="btn btn-primary btn-lg w-100 mt-4">
                            <i class="bi bi-box-arrow-in-right me-2"></i><span data-i18n="login_to_reserve_btn">{{ __('messages.login_to_reserve_btn') }}</span>
                        </a>
                        @endauth
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-4 overflow-hidden">
                    <img src="https://res.cloudinary.com/dh9ysyfit/image/fetch/w_600,h_300,c_fill,f_auto,q_auto/https://images.unsplash.com/photo-1517248135467-4c7edcad34c4" 
                         class="card-img-top" alt="Restaurant Interior" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5>
                            <i class="bi bi-geo-alt text-gold me-2"></i><span data-i18n="our_location">{{ __('messages.our_location') }}</span>
                        </h5>
                        <p class="text-muted mb-2">Jl. Kuliner No. 123, Jakarta Selatan</p>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-clock me-1"></i> <span data-i18n="opening_hours">{{ __('messages.opening_hours') }}</span>
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="bi bi-info-circle text-gold me-2"></i><span data-i18n="terms_title">{{ __('messages.terms_title') }}</span>
                        </h5>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span data-i18n="term_1">{{ __('messages.term_1') }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span data-i18n="term_2">{{ __('messages.term_2') }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span data-i18n="term_3">{{ __('messages.term_3') }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span data-i18n="term_4">{{ __('messages.term_4') }}</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span data-i18n="term_5">{{ __('messages.term_5') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('js/cloudinary-upload.js') }}"></script>
<script>
    (function() {
        const fileInput = document.getElementById('payment_proof_file');
        const urlInput = document.getElementById('payment_proof_url');
        const form = document.querySelector('form');
        const submitBtn = form.querySelector('button[type="submit"]');
        let isUploading = false;
        let uploadedUrl = null;
        // Initialize progress bar
        const progressBar = CloudinaryUploader.createProgressBar('uploadProgressContainer');
        fileInput.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) {
                document.getElementById('paymentPreviewContainer').style.display = 'none';
                urlInput.value = '';
                uploadedUrl = null;
                return;
            }
            // Validate file size (30MB max)
            if (file.size > 30 * 1024 * 1024) {
                alert('Ukuran file maksimal 30MB');
                fileInput.value = '';
                return;
            }
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('paymentPreview').src = e.target.result;
                document.getElementById('paymentPreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
            // Start upload to Cloudinary
            isUploading = true;
            submitBtn.disabled = true;
            progressBar.reset();
            progressBar.show();
            try {
                // Check compression mode
                const isCompressed = document.getElementById('modeCompressed').checked;
                const result = await CloudinaryUploader.upload(file, {
                    folder: 'reservations_payments',
                    onProgress: (percent, loaded, total) => {
                        progressBar.update(percent, loaded, total);
                    },
                    compress: isCompressed,
                    compressionOptions: {
                        maxWidth: 4096,  // 4K max
                        maxHeight: 4096,
                        quality: 0.98   // 98% quality
                    }
                });
                uploadedUrl = result.secure_url;
                urlInput.value = uploadedUrl;
                progressBar.success('Upload berhasil!');
                submitBtn.disabled = false;
                // Update preview with Cloudinary URL
                document.getElementById('paymentPreview').src = uploadedUrl;
            } catch (error) {
                console.error('Upload error:', error);
                progressBar.error(error.message || 'Upload gagal, coba lagi');
                fileInput.value = '';
                urlInput.value = '';
                uploadedUrl = null;
                submitBtn.disabled = false;
            } finally {
                isUploading = false;
            }
        });
        // Prevent form submission if still uploading
        form.addEventListener('submit', function(e) {
            if (isUploading) {
                e.preventDefault();
                alert('Mohon tunggu, gambar sedang diupload...');
                return false;
            }
            if (!uploadedUrl) {
                e.preventDefault();
                alert('Silakan upload bukti pembayaran terlebih dahulu');
                return false;
            }
        });
    })();
</script>
@endpush