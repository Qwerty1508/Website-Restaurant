@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Kelola Pesanan</h4>
            <p class="text-muted mb-0">Kelola semua pesanan pelanggan</p>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Pesanan</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <i class="bi bi-bag-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-dark opacity-75 mb-1">Menunggu</h6>
                            <h3 class="mb-0 text-dark">{{ $stats['pending'] }}</h3>
                        </div>
                        <i class="bi bi-clock fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 mb-1">Diproses</h6>
                            <h3 class="mb-0">{{ $stats['processing'] }}</h3>
                        </div>
                        <i class="bi bi-arrow-repeat fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 mb-1">Selesai</h6>
                            <h3 class="mb-0">{{ $stats['completed'] }}</h3>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            <form action="" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="No. Pesanan atau Nama Pelanggan" 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url('/admin/orders') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Tipe</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ url('/admin/orders/' . $order->id) }}" class="fw-semibold text-primary">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td>
                                <div>{{ $order->customer_name }}</div>
                                <small class="text-muted">{{ $order->customer_email }}</small>
                            </td>
                            <td>
                                @if($order->type === 'dine_in')
                                <span class="badge bg-info">Dine In</span>
                                @if($order->table_number)
                                <small class="d-block text-muted">Meja {{ $order->table_number }}</small>
                                @endif
                                @else
                                <span class="badge bg-secondary">Take Away</span>
                                @endif
                            </td>
                            <td>{{ $order->item_count }} item</td>
                            <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($order->status === 'completed')
                                <span class="badge bg-success">Selesai</span>
                                @elseif($order->status === 'processing')
                                <span class="badge bg-info">Diproses</span>
                                @elseif($order->status === 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                                @else
                                <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ date('d M Y', strtotime($order->created_at)) }}</small>
                                <small class="d-block text-muted">{{ date('H:i', strtotime($order->created_at)) }}</small>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" data-bs-toggle="dropdown">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/admin/orders/' . $order->id) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat Detail
                                            </a>
                                        </li>
                                        @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                        <li><hr class="dropdown-divider"></li>
                                        @if($order->status === 'pending')
                                        <li>
                                            <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="dropdown-item text-info">
                                                    <i class="bi bi-arrow-repeat me-2"></i>Proses Pesanan
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if($order->status === 'processing')
                                        <li>
                                            <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="bi bi-check-circle me-2"></i>Selesaikan
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li>
                                            <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item text-danger" 
                                                        onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                    <i class="bi bi-x-circle me-2"></i>Batalkan
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-0">Belum ada pesanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection