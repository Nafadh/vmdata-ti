@extends('layouts.app')

@section('title', 'Dashboard - Datacenter TI')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card stats-card text-center">
            <div class="card-body">
                <i class="fas fa-server fa-2x text-primary mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_vms'] }}</h3>
                <p class="card-text">Total VM</p>
            </div>
        </div>
    </div>
    <!--<div class="col-md-2">
        <div class="card stats-card text-center">
            <div class="card-body">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3 class="mb-0">{{ $stats['available_vms'] }}</h3>
                <p class="card-text">Tersedia</p>
            </div>
        </div>
    </div> -->
    <div class="col-md-2">
        <div class="card stats-card text-center">
            <div class="card-body">
                <i class="fas fa-calendar-check fa-2x text-warning mb-2"></i>
                <h3 class="mb-0">{{ $stats['active_rentals'] }}</h3>
                <p class="card-text">Renter</p>
            </div>
        </div>
    </div>
   <!-- <div class="col-md-3">
        <div class="card stats-card text-center">
            <div class="card-body">
                <i class="fas fa-dollar-sign fa-2x text-info mb-2"></i>
                <h3 class="mb-0">${{ number_format($stats['total_revenue'], 2) }}</h3>
                <p class="card-text">Total Revenue</p>
            </div>
        </div>
    </div>-->
    <div class="col-md-2">
        <div class="card stats-card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-secondary mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                <p class="card-text">Pengguna</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent VMs -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5><i class="fas fa-server me-2"></i>Server</h5>
                <a href="{{ route('vms.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($recentVMs as $vm)
                    <div class="d-flex align-items-center mb-3 vm-card p-2 border rounded">
                        <div class="me-3">
                            <i class="fas fa-server fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $vm->name }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-tag me-1"></i>{{ optional($vm->category)->name ?? 'Uncategorized' }}
                                <span class="ms-2">
                                    <i class="fas fa-microchip me-1"></i>{{ optional($vm->specification)->name ?? 'No Specification' }}
                                </span>
                            </small>
                            <div class="mt-1">
                                <span class="badge bg-{{ $vm->status == 'available' ? 'success' : 'warning' }}">
                                    {{ ucfirst($vm->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $vm->os }}</small><br>
                            <small class="text-muted">{{ $vm->ip_address ?? 'No IP' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-server fa-3x mb-3"></i>
                        <p>No VMs available</p>
                        <a href="{{ route('vms.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create First VM
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Active Rentals -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5><i class="fas fa-calendar-check me-2"></i>Active Rentals</h5>
                <a href="{{ route('rentals.index') }}" class="btn btn-sm btn-outline-success">View All</a>
            </div>
            <div class="card-body">
                @forelse($activeRentals as $rental)
                    <div class="d-flex align-items-center mb-3 p-2 border rounded">
                        <div class="me-3">
                            <i class="fas fa-user-clock fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $rental->vm->name }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>{{ optional($rental->user)->organization ?? optional($rental->user)->name ?? 'Unknown' }}
                            </small>
                            <div class="mt-1">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    @php
                                        $start = optional($rental->start_time);
                                        $end = optional($rental->end_time);
                                    @endphp
                                    {{ $start && method_exists($start, 'format') ? $start->format('M j, H:i') : (is_string($start) ? $start : '-') }} -
                                    {{ $end && method_exists($end, 'format') ? $end->format('M j, H:i') : (is_string($end) ? $end : '-') }}
                                </small>
                            </div>
                        </div>
                        <div class="text-end">
                            <!--<span class="fw-bold text-success">{{ isset($rental->total_cost) ? ('$' . $rental->total_cost) : '-' }}</span><br> -->
                            <span class="badge bg-success">{{ ucfirst($rental->status ?? 'active') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p>No active rentals</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- VM Status Chart (placeholder) -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-pie me-2"></i>VM Status Overview</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="p-3">
                            <i class="fas fa-circle text-success fa-lg"></i>
                            <h4 class="text-success mt-2">{{ $stats['available_vms'] }}</h4>
                            <p class="text-muted">Tersedia</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <i class="fas fa-circle text-warning fa-lg"></i>
                            <h4 class="text-warning mt-2">{{ $stats['active_rentals'] }}</h4>
                            <p class="text-muted">Rented</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <i class="fas fa-circle text-danger fa-lg"></i>
                            <h4 class="text-danger mt-2">0</h4>
                            <p class="text-muted">Maintenance</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <i class="fas fa-circle text-secondary fa-lg"></i>
                            <h4 class="text-secondary mt-2">0</h4>
                            <p class="text-muted">Offline</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
