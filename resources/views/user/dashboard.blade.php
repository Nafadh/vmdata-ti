@extends('app')

@section('title', 'VMDATA TI')
@section('page-title', 'Dashboard Pengguna')

@section('content')
<div class="container-fluid">

    {{-- Notifications handled by layout to keep a single alert area --}}



    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Jumlah VM Saya</h6>
                    <h3>{{ $stats['my_vms'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Sewa Aktif</h6>
                    <h3>{{ $stats['active_rentals'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <!--<div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Belanja</h6>
                    <h3>Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>-->
    </div>

    @include('user.partials.my_rentals')

</div>
@endsection