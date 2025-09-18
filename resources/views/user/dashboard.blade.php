@extends('layouts.app')

@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard Pengguna')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">Dashboard Saya</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Jumlah VM Saya</h6>
                    <h3>{{ $stats['my_vms'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Sewa Aktif</h6>
                    <h3>{{ $stats['active_rentals'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Belanja</h6>
                    <h3>Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Daftar VM yang Saya Sewa</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-secondary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama VM</th>
                        <th>Periode Sewa</th>
                        <th>Status Sewa</th>
                        <th>Total Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myRentals as $i => $rental)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $rental->vm->name ?? 'N/A' }}</strong>
                                @if(isset($rental->vm->description))
                                    <br><small class="text-muted">{{ $rental->vm->description }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <small>
                                    Mulai: {{ optional($rental->start_date)->format('Y-m-d') ?? '-' }}<br>
                                    Selesai: {{ optional($rental->end_date)->format('Y-m-d') ?? '-' }}
                                </small>
                            </td>
                            <td class="text-center">
                                @if($rental->status === 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($rental->status === 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($rental->status === 'completed')
                                    <span class="badge bg-secondary">Selesai</span>
                                @else
                                    <span class="badge bg-info">{{ ucfirst($rental->status) }}</span>
                                @endif
                            </td>
                            <td class="text-center">Rp {{ number_format($rental->total_cost ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($rental->status === 'pending')
                                        <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> Anda belum menyewa VM apapun.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // minimal client interactions if needed
});
</script>
@endpush
@extends('layouts.app')

@section('title', 'User Dashboard')
@section('page-title', 'Dashboard User')

@section('content')
<div class="container">
    <h2>Halo, {{ Auth::user()->name }}!</h2>
    <p>Total VM saya: {{ $stats['my_vms'] }}</p>
    <p>Sewa aktif: {{ $stats['active_rentals'] }}</p>
    <p>Total biaya: Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>

    <h4 class="mt-4">Sewa Saya</h4>
    <ul>
        @forelse ($myRentals as $rental)
            <li>{{ $rental->vm->name }} ({{ ucfirst($rental->status) }})</li>
        @empty
            <li>Belum ada sewa</li>
        @endforelse
    </ul>
</div>
@endsection
