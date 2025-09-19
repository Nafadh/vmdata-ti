@extends('layouts.app')

@section('title', 'Rentals')
@section('page-title', 'Rentals')
@section('content')
<div class="container">
    <h2 class ="mb-4" >Rental Management </h2>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search and Filter --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('rentals.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari user atau VM..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-refresh"></i> Reset
                            </a>
                            <a href="{{ route('rentals.create') }}" class="btn btn-primary ms-auto">
                                <i class="fas fa-plus"></i> Tambah Rental
                            </a>
                        </div>
                    </div>
                </div>                    
            </div>
        </form>
    </div>
</div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>VM / Server</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Status</th>
                            <th>Durasi (hari)</th>
                            <th>Penanggung Jawab</th>
                            <th width="200px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                            <tr>
                                <td>{{ $rental->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                            {{ substr($rental->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        {{ $rental->user->name ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $rental->vm->name ?? '-' }}</span>
                                </td>
                                <td>
                                    @if($rental->start_date)
                                        {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($rental->end_date)
                                        {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @php
                                        switch($rental->status) {
                                            case 'active':
                                                $statusClass = 'success';
                                                break;
                                            case 'inactive':
                                                $statusClass = 'secondary';
                                                break;
                                            case 'expired':
                                                $statusClass = 'danger';
                                                break;
                                            default:
                                                $statusClass = 'warning';
                                            break;
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($rental->start_date && $rental->end_date)
                                        @php
                                            $startDate = \Carbon\Carbon::parse($rental->start_date);
                                            $endDate = \Carbon\Carbon::parse($rental->end_date);
                                            $diffInDays = $startDate->diffInDays($endDate);
                                        @endphp
                                        <span class="badge bg-light text-dark">
                                            {{ $diffInDays }} hari
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $rental->admin->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('rentals.show', $rental->id) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('rentals.edit', $rental->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm" 
                                                title="Hapus"
                                                onclick="confirmDelete({{ $rental->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    {{-- Hidden delete form --}}
                                    <form id="delete-form-{{ $rental->id }}" 
                                          action="{{ route('rentals.destroy', $rental->id) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf 
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>Belum ada data rental</h5>
                                        <p>Klik tombol "Tambah Rental" untuk menambah data baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($rentals->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $rentals->firstItem() }} - {{ $rentals->lastItem() }} 
                        dari {{ $rentals->total() }} data
                    </div>
                    <div>
                        {{ $rentals->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(rentalId) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + rentalId).submit();
        }
    });
}
</script>
@endpush

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
    font-weight: 600;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075);
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush
@endsection