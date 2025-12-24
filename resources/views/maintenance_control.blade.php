@extends('layouts.guest')

@section('title', 'Maintenance Control')

@section('content')
<section class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #0B0E10 0%, #1a1f25 100%); padding-top: 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: rgba(200,155,58,0.15); border: 2px solid rgba(200,155,58,0.3); border-radius: 50%;">
                        <i class="bi bi-shield-lock-fill" style="font-size: 2.5rem; color: #D4AF37;"></i>
                    </div>
                    <h1 class="text-white fw-bold mb-2">Maintenance Control</h1>
                    <p class="text-white-50">Secret admin panel - Only for <strong class="text-warning">{{ auth()->user()->email }}</strong></p>
                </div>

                <!-- Control Panel -->
                <div class="row g-4">
                    <!-- Toggle Section -->
                    <div class="col-md-5">
                        <div class="card border-0 h-100" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(200,155,58,0.2) !important;">
                            <div class="card-body p-4">
                                <h5 class="text-white mb-4"><i class="bi bi-gear-fill me-2 text-warning"></i>Control Panel</h5>
                                
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: rgba(25,135,84,0.2); border: 1px solid rgba(25,135,84,0.3); color: #75b798;">
                                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <div class="p-4 rounded-3 mb-4" style="background: rgba(0,0,0,0.3);">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h6 class="text-white mb-1">Maintenance Mode</h6>
                                            <small class="text-white-50">Toggle to enable/disable</small>
                                        </div>
                                        <span class="badge {{ $isMaintenanceMode ? 'bg-danger' : 'bg-success' }} px-3 py-2">
                                            {{ $isMaintenanceMode ? 'ACTIVE' : 'INACTIVE' }}
                                        </span>
                                    </div>
                                    
                                    <form action="{{ url('/maintenance/toggle') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-lg w-100 {{ $isMaintenanceMode ? 'btn-danger' : 'btn-success' }}" id="toggleBtn">
                                            @if($isMaintenanceMode)
                                                <i class="bi bi-toggle-on me-2"></i> Turn OFF Maintenance
                                            @else
                                                <i class="bi bi-toggle-off me-2"></i> Turn ON Maintenance
                                            @endif
                                        </button>
                                    </form>
                                </div>

                                <div class="p-3 rounded-3" style="background: rgba(200,155,58,0.1); border: 1px solid rgba(200,155,58,0.3);">
                                    <small class="text-white-50">
                                        <i class="bi bi-info-circle text-warning me-2"></i>
                                        When ON, all pages except <code>/project</code> will show maintenance page.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Preview Section -->
                    <div class="col-md-7">
                        <div class="card border-0 h-100" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(200,155,58,0.2) !important;">
                            <div class="card-body p-4">
                                <h5 class="text-white mb-4">
                                    <i class="bi bi-eye-fill me-2 text-warning"></i>Live Preview
                                    <span class="badge {{ $isMaintenanceMode ? 'bg-danger' : 'bg-success' }} ms-2">{{ $isMaintenanceMode ? 'Maintenance' : 'Normal' }}</span>
                                </h5>
                                
                                <!-- Preview Container -->
                                <div class="preview-container rounded-3 overflow-hidden" style="border: 2px solid rgba(200,155,58,0.2); height: 400px;">
                                    @if($isMaintenanceMode)
                                    <!-- Maintenance Preview -->
                                    <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: linear-gradient(135deg, #0B0E10 0%, #1a1f25 100%);">
                                        <div class="mb-3" style="width: 80px; height: 80px; background: rgba(200,155,58,0.1); border: 2px solid rgba(200,155,58,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-wrench-adjustable" style="font-size: 2rem; color: #D4AF37;"></i>
                                        </div>
                                        <h3 style="font-family: 'Playfair Display', serif; color: #D4AF37;">Under Maintenance</h3>
                                        <p class="text-white-50 small mb-3">Kami sedang melakukan peningkatan sistem untuk memberikan pengalaman yang lebih baik.</p>
                                        <div style="width: 100px; height: 3px; background: linear-gradient(90deg, transparent, #D4AF37, transparent);"></div>
                                        <div class="mt-3 px-3 py-2 rounded" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(200,155,58,0.2);">
                                            <small class="text-white-50"><i class="bi bi-envelope me-1"></i> info@culinaire.id</small>
                                        </div>
                                    </div>
                                    @else
                                    <!-- Normal Preview -->
                                    <div class="h-100 position-relative" style="background: linear-gradient(to right, rgba(12, 42, 54, 0.92) 0%, rgba(12, 42, 54, 0.7) 50%, rgba(12, 42, 54, 0.22) 100%), url('https://res.cloudinary.com/dh9ysyfit/image/upload/v1766046687/IMG_7856_esb0xz.jpg'); background-size: cover; background-position: center;">
                                        <div class="p-4 h-100 d-flex flex-column justify-content-center">
                                            <span class="badge mb-2 px-2 py-1" style="background: rgba(200,155,58,0.3); color: #D4AF37; width: fit-content; font-size: 0.65rem;">
                                                <i class="bi bi-star-fill me-1"></i> EST. 2009 • INDONESIA
                                            </span>
                                            <h3 class="text-white fw-bold mb-2" style="font-family: 'Playfair Display', serif; font-size: 1.5rem;">Taste the Luxury</h3>
                                            <p class="text-white-50 small mb-3" style="font-size: 0.75rem;">Experience the finest fusion of Indonesian heritage and modern gastronomy.</p>
                                            <div class="d-flex gap-2">
                                                <span class="btn btn-sm px-3" style="background: rgba(200,155,58,0.3); color: #D4AF37; font-size: 0.7rem; border: 1px solid rgba(200,155,58,0.4);">
                                                    Explore Menu
                                                </span>
                                                <span class="btn btn-sm px-3" style="background: rgba(255,255,255,0.1); color: white; font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.2);">
                                                    Reservation
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="mt-3 text-center">
                                    <small class="text-white-50">
                                        <i class="bi bi-arrow-repeat me-1"></i> Preview updates after toggle
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="mt-4 text-center">
                    <small class="text-white-50">
                        <i class="bi bi-shield-check me-1"></i> 
                        This page is only accessible by the super admin account
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
