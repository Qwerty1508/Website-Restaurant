@extends('layouts.guest')

@section('title', __('messages.my_reservations'))

@section('content')
<section class="bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3" data-i18n="my_reservations">{{ __('messages.my_reservations') }}</h1>
                <p class="lead opacity-75 mb-0" data-i18n="my_reservations_desc">{{ __('messages.my_reservations_desc') }}</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ url('/reservation') }}" class="btn btn-secondary">
                    <i class="bi bi-plus-lg me-2"></i><span data-i18n="new_reservation_btn">{{ __('messages.new_reservation_btn') }}</span>
                </a>
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
        
        <div class="d-flex gap-3 mb-4 flex-wrap">
            <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-clock me-1"></i> <span data-i18n="status_pending">{{ __('messages.status_pending') }}</span></span>
            <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle me-1"></i> <span data-i18n="status_accepted">{{ __('messages.status_accepted') }}</span></span>
            <span class="badge bg-danger px-3 py-2"><i class="bi bi-x-circle me-1"></i> <span data-i18n="status_rejected">{{ __('messages.status_rejected') }}</span></span>
        </div>
        
        @if($reservations->count() > 0)
            <div class="row g-4">
                @foreach($reservations as $reservation)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold">#{{ $reservation->id }}</span>
                            @if($reservation->status === 'pending')
                                <span class="badge bg-warning text-dark" data-i18n="status_pending">{{ __('messages.status_pending') }}</span>
                            @elseif($reservation->status === 'accepted')
                                <span class="badge bg-success" data-i18n="status_accepted">{{ __('messages.status_accepted') }}</span>
                            @else
                                <span class="badge bg-danger" data-i18n="status_rejected">{{ __('messages.status_rejected') }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-calendar-event text-gold me-2"></i>
                                {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                            </h5>
                            <ul class="list-unstyled text-muted small mb-3">
                                <li class="mb-1">
                                    <i class="bi bi-clock me-2"></i>{{ $reservation->time }}
                                </li>
                                <li class="mb-1">
                                    <i class="bi bi-people me-2"></i>{{ $reservation->guests }} <span data-i18n="people">{{ __('messages.people') }}</span>
                                </li>
                                @if($reservation->table_id)
                                <li class="mb-1">
                                    <i class="bi bi-grid-3x3 me-2"></i><span data-i18n="table">{{ __('messages.table') }}</span> {{ $reservation->table_id }}
                                </li>
                                @endif
                            </ul>
                            
                            @if($reservation->admin_notes)
                            <div class="alert alert-{{ $reservation->status === 'accepted' ? 'success' : ($reservation->status === 'rejected' ? 'danger' : 'info') }} small py-2">
                                <strong>{{ __('messages.admin_notes') }}:</strong><br>
                                {{ $reservation->admin_notes }}
                            </div>
                            @endif
                            
                            <p class="text-muted small mb-0">
                                <i class="bi bi-clock-history me-1"></i>
                                <span data-i18n="created_at">{{ __('messages.created_at') }}</span>: {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ url('/customer/reservations/' . $reservation->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-eye me-1"></i><span data-i18n="view_details">{{ __('messages.view_details') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
                    <h5 data-i18n="no_reservations">{{ __('messages.no_reservations') }}</h5>
                    <p class="text-muted" data-i18n="no_reservations_desc">{{ __('messages.no_reservations_desc') }}</p>
                    <a href="{{ url('/reservation') }}" class="btn btn-primary">
                        <i class="bi bi-calendar-plus me-2"></i><span data-i18n="create_reservation_btn">{{ __('messages.create_reservation_btn') }}</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
