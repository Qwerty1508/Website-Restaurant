@extends('layouts.guest')
@section('title', 'Dashboard')
@section('content')
<section class="section bg-cream">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            @php
                                $hour = (int) date('H', strtotime('+7 hours'));
                                if ($hour >= 0 && $hour < 11) {
                                    $greeting = __('messages.morning');
                                    $greetingKey = 'morning';
                                } elseif ($hour >= 11 && $hour < 15) {
                                    $greeting = __('messages.afternoon');
                                    $greetingKey = 'afternoon';
                                } elseif ($hour >= 15 && $hour < 18) {
                                    $greeting = __('messages.evening');
                                    $greetingKey = 'evening';
                                } else {
                                    $greeting = __('messages.night');
                                    $greetingKey = 'night';
                                }
                            @endphp
                            <h3 class="text-white mb-2">
                                <span data-i18n="{{ $greetingKey }}">{{ $greeting }}</span>, {{ Auth::user()->name ?? 'Customer' }}! 👋
                            </h3>
                            <p class="opacity-75 mb-0" data-i18n="dashboard_welcome_desc">
                                {{ __('messages.dashboard_welcome_desc') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ url('/customer/orders/create') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-bag-plus me-2"></i><span data-i18n="create_order_btn">{{ __('messages.create_order_btn') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card h-100 text-center p-4">
                    <img src="https://res.cloudinary.com/dh9ysyfit/image/upload/v1766509041/IMG_8022_2_x5rhdp.png" class="mb-3" alt="Orders" style="width: 60px; height: 60px; object-fit: contain;">
                    <h4 class="mb-1">{{ $totalOrders ?? 0 }}</h4>
                    <small class="text-muted" data-i18n="total_orders">{{ __('messages.total_orders') }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center p-4">
                    <img src="https://res.cloudinary.com/dh9ysyfit/image/upload/v1766509120/IMG_8021_l1abhj.png" class="mb-3" alt="Points" style="width: 60px; height: 60px; object-fit: contain;">
                    <h4 class="mb-1">{{ ($totalOrders ?? 0) * 50 }}</h4>
                    <small class="text-muted" data-i18n="reward_points">{{ __('messages.reward_points') }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center p-4">
                    <img src="https://res.cloudinary.com/dh9ysyfit/image/upload/v1766509326/IMG_8023_c7nvaa.png" class="mb-3" alt="Reservations" style="width: 60px; height: 60px; object-fit: contain;">
                    <h4 class="mb-1">{{ $totalReservations ?? 0 }}</h4>
                    <small class="text-muted" data-i18n="total_reservations">{{ __('messages.total_reservations') }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center p-4">
                    <img src="https://res.cloudinary.com/dh9ysyfit/image/upload/v1766509327/IMG_8024_tcrsza.png" class="mb-3" alt="Favorites" style="width: 60px; height: 60px; object-fit: contain;">
                    <h4 class="mb-1">0</h4>
                    <small class="text-muted" data-i18n="favorite_menu">{{ __('messages.favorite_menu') }}</small>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history text-primary me-2"></i><span data-i18n="recent_orders">{{ __('messages.recent_orders') }}</span>
                        </h5>
                        <a href="{{ url('/customer/orders') }}" class="btn btn-sm btn-outline-primary">
                            <span data-i18n="view_all">{{ __('messages.view_all') }}</span>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($orders as $order)
                            <div class="list-group-item p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @php $firstItem = $order->items->first(); @endphp
                                        @if($firstItem && $firstItem->image_url)
                                        <img src="{{ $firstItem->image_url }}" 
                                             alt="Order" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                        <div class="rounded-3 me-3 bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="bi bi-bag-check text-white fs-4"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1">#{{ $order->order_number }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ date('d M Y, H:i', strtotime($order->created_at)) }}
                                            </small>
                                            <small class="d-block text-muted">{{ $order->items->count() }} item</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        @if($order->status === 'completed')
                                        <span class="badge bg-success mb-1">{{ __('messages.status_completed') }}</span>
                                        @elseif($order->status === 'processing')
                                        <span class="badge bg-warning text-dark mb-1">{{ __('messages.status_processing') }}</span>
                                        @elseif($order->status === 'pending')
                                        <span class="badge bg-info mb-1">{{ __('messages.status_pending') }}</span>
                                        @else
                                        <span class="badge bg-danger mb-1">{{ __('messages.status_cancelled') }}</span>
                                        @endif
                                        <div><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="list-group-item p-5 text-center">
                                <i class="bi bi-bag-x fs-1 text-muted d-block mb-3"></i>
                                <h6 class="text-muted mb-2">Belum ada pesanan</h6>
                                <p class="text-muted small mb-3">Anda belum pernah melakukan pemesanan</p>
                                <a href="{{ url('/customer/orders/create') }}" class="btn btn-primary">
                                    <i class="bi bi-bag-plus me-2"></i>Buat Pesanan Pertama
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-event text-success me-2"></i><span data-i18n="upcoming_reservation">{{ __('messages.upcoming_reservation') }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="border rounded-3 p-3 bg-light">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ date('d M Y', strtotime('+3 days')) }}</strong>
                                <span class="badge bg-success" data-i18n="confirmed">{{ __('messages.confirmed') }}</span>
                            </div>
                            <p class="mb-2">
                                <i class="bi bi-clock me-1"></i>19:00 - 21:00
                            </p>
                            <p class="mb-2">
                                <i class="bi bi-people me-1"></i>4 <span data-i18n="x_people">{{ __('messages.x_people') }}</span>
                            </p>
                            <p class="mb-0 text-muted small">
                                <i class="bi bi-geo-alt me-1"></i>Meja 3 - Garden View
                            </p>
                        </div>
                        <a href="{{ url('/customer/reservations') }}" class="btn btn-outline-primary btn-sm w-100 mt-3">
                            <span data-i18n="view_all_reservations">{{ __('messages.view_all_reservations') }}</span>
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning text-warning me-2"></i><span data-i18n="quick_actions">{{ __('messages.quick_actions') }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ url('/menu') }}" class="btn btn-outline-primary text-start">
                                <i class="bi bi-book me-2"></i><span data-i18n="view_menu">{{ __('messages.view_menu') }}</span>
                            </a>
                            <a href="{{ url('/customer/orders/create') }}" class="btn btn-outline-success text-start">
                                <i class="bi bi-bag-plus me-2"></i><span data-i18n="create_new_order">{{ __('messages.create_new_order') }}</span>
                            </a>
                            <a href="{{ url('/reservation') }}" class="btn btn-outline-warning text-start">
                                <i class="bi bi-calendar-plus me-2"></i><span data-i18n="reserve_table_action">{{ __('messages.reserve_table_action') }}</span>
                            </a>
                            <a href="{{ url('/customer/profile') }}" class="btn btn-outline-secondary text-start">
                                <i class="bi bi-person me-2"></i><span data-i18n="edit_profile">{{ __('messages.edit_profile') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection