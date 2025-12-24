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

                                @if($isMaintenanceMode && $maintenanceStartTime)
                                <!-- Duration Counter -->
                                <div class="p-3 rounded-3 mb-4" style="background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.3);">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-clock-history text-danger me-2"></i>
                                        <small class="text-white-50">Maintenance Duration</small>
                                    </div>
                                    <div id="durationCounter" class="d-flex gap-2 justify-content-center">
                                        <div class="text-center px-2">
                                            <div class="fs-4 fw-bold text-danger" id="days">00</div>
                                            <small class="text-white-50">Days</small>
                                        </div>
                                        <div class="text-danger fs-4">:</div>
                                        <div class="text-center px-2">
                                            <div class="fs-4 fw-bold text-danger" id="hours">00</div>
                                            <small class="text-white-50">Hours</small>
                                        </div>
                                        <div class="text-danger fs-4">:</div>
                                        <div class="text-center px-2">
                                            <div class="fs-4 fw-bold text-danger" id="minutes">00</div>
                                            <small class="text-white-50">Mins</small>
                                        </div>
                                        <div class="text-danger fs-4">:</div>
                                        <div class="text-center px-2">
                                            <div class="fs-4 fw-bold text-danger" id="seconds">00</div>
                                            <small class="text-white-50">Secs</small>
                                        </div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <small class="text-white-50">Started: {{ \Carbon\Carbon::parse($maintenanceStartTime)->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</small>
                                    </div>
                                </div>
                                <script>
                                    const startTime = new Date('{{ $maintenanceStartTime }}');
                                    function updateDuration() {
                                        const now = new Date();
                                        const diff = Math.floor((now - startTime) / 1000);
                                        const days = Math.floor(diff / 86400);
                                        const hours = Math.floor((diff % 86400) / 3600);
                                        const minutes = Math.floor((diff % 3600) / 60);
                                        const seconds = diff % 60;
                                        document.getElementById('days').textContent = String(days).padStart(2, '0');
                                        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                                        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                                        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
                                    }
                                    updateDuration();
                                    setInterval(updateDuration, 1000);
                                </script>
                                @endif

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
                                
                                <!-- Real Live Preview with Iframe -->
                                <div class="preview-container rounded-3 overflow-hidden position-relative" style="border: 2px solid rgba(200,155,58,0.2); height: 400px; background: #0B0E10;">
                                    <!-- Browser Chrome Bar -->
                                    <div class="d-flex align-items-center px-3 py-2" style="background: rgba(0,0,0,0.5); border-bottom: 1px solid rgba(200,155,58,0.2);">
                                        <div class="d-flex gap-1 me-3">
                                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ff5f57;"></span>
                                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #febc2e;"></span>
                                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #28c840;"></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="px-3 py-1 rounded" style="background: rgba(255,255,255,0.1); font-size: 0.7rem; color: rgba(255,255,255,0.5);">
                                                <i class="bi bi-lock-fill me-1"></i> {{ $isMaintenanceMode ? url('/') . ' (maintenance view)' : url('/') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Iframe Preview - Shows actual page -->
                                    <iframe 
                                        src="{{ $isMaintenanceMode ? url('/maintenance/preview') : url('/') }}" 
                                        style="width: 166.67%; height: 166.67%; border: none; transform: scale(0.6); transform-origin: top left;"
                                        loading="lazy"
                                    ></iframe>
                                </div>

                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <small class="text-white-50">
                                        <i class="bi bi-arrow-repeat me-1"></i> Preview updates after toggle
                                    </small>
                                    <a href="{{ $isMaintenanceMode ? url('/maintenance/preview') : url('/') }}" target="_blank" class="btn btn-sm" style="background: rgba(200,155,58,0.15); color: #D4AF37; border: 1px solid rgba(200,155,58,0.2);">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Open in New Tab
                                    </a>
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
