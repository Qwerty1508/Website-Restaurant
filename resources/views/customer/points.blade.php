@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Points Header Card -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="border-radius: 20px; background: linear-gradient(135deg, #0C2A36 0%, #1a4f63 100%);">
                <div class="card-body p-5 text-center text-white position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.1) 0%, transparent 70%); pointer-events: none;"></div>
                    
                    <h2 class="mb-4 fw-light text-uppercase tracking-wider" style="letter-spacing: 2px;">Your Reward Points</h2>
                    
                    <div class="mb-4">
                        <img src="https://res.cloudinary.com/dh9ysyfit/image/upload/v1766509120/IMG_8021_l1abhj.png" 
                             alt="Points API" 
                             class="animate-float" 
                             style="width: 150px; height: 150px; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));">
                    </div>
                    
                    <div class="display-3 fw-bold mb-2 text-warning" style="text-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                        {{ number_format($points) }}
                    </div>
                    <p class="lead opacity-75">Points Available</p>
                    
                    <div class="mt-4 pt-3 border-top border-light border-opacity-25 d-inline-block px-5">
                        <small class="text-white-50">Earn 1 Point for every Rp 10.000 spent</small>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- How to Earn -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="fw-bold text-dark mb-0">How to Earn</h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary">
                                    <i class="bi bi-cart-check fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Order Food</h6>
                                    <small class="text-muted">Get points automatically for every order you make.</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success">
                                    <i class="bi bi-star fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Special Events</h6>
                                    <small class="text-muted">Look out for double points days and special promotions.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rewards Catalog (Preview) -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0">Rewards Catalog</h5>
                            <span class="badge bg-light text-dark">Coming Soon</span>
                        </div>
                        <div class="card-body px-4 pb-4 text-center d-flex flex-column justify-content-center">
                            <i class="bi bi-gift fs-1 text-muted mb-3 opacity-50"></i>
                            <p class="text-muted">Exciting rewards including dining vouchers and exclusive items are coming your way!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="card border-0 shadow-sm mt-4" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">Points History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small text-muted border-0">Date</th>
                                    <th class="py-3 text-uppercase small text-muted border-0">Activity</th>
                                    <th class="py-3 text-uppercase small text-muted border-0 text-end pe-4">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="fw-medium">{{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item['date'])->format('H:i') }}</small>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light p-2 rounded me-3 text-primary">
                                                <i class="bi bi-bag-check"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-medium">Order #{{ substr($item['id'], 0, 8) }}</span>
                                                <small class="text-muted">Spent: Rp {{ number_format($item['amount'], 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end pe-4">
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            +{{ $item['points_earned'] }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-clock-history fs-1 mb-3 d-block opacity-25"></i>
                                        No point history available yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0% { transform: translateY(0px) rotateY(0deg); }
        50% { transform: translateY(-10px) rotateY(5deg); }
        100% { transform: translateY(0px) rotateY(0deg); }
    }
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    .text-warning {
        color: #FFD700 !important;
    }
</style>
@endsection
