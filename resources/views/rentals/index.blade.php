@extends('layouts.app')

@section('title', 'VMDATA TI')
@section('page-title', 'Rentals')
@section('content')
<div class="container">
    <h2 class ="mb-4" >Rental Management </h2>

    {{-- Notifications handled centrally in layout to avoid duplicates --}}

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
                                {{-- ...existing code... --}}
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
                            <th>VM</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Status</th>
                            <th>Durasi (hari)</th>
                            <th>Penanggung Jawab</th>
                            <th width="200px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Pending VM rental requests (visible to admin) --}}
                        @if(!empty($pendingVmrentals) && $pendingVmrentals->count())
                            @foreach($pendingVmrentals as $pv)
                                <tr class="table-warning">
                                    <td>{{ $pv->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                                @php $theUser = $pv->user ?? null; @endphp
                                                <img src="{{ $theUser && $theUser->avatar ? asset('storage/'.$theUser->avatar) : asset('images/default-avatar.png') }}" alt="avatar" width="32" height="32" class="rounded-circle me-2" />
                                                {{ $theUser->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info">{{ $pv->vm->name ?? '-' }}</span></td>
                                    <td>{{ optional($pv->start_time)->format('d/m/Y') }}</td>
                                    <td>{{ optional($pv->end_time)->format('d/m/Y') }}</td>
                                    <td>
                                        @if(auth()->user() && auth()->user()->isAdmin())
                                            <button type="button" class="btn p-0 border-0 status-badge-btn-rental" data-model="vmrental" data-rental-id="{{ $pv->id }}" data-rental-status="{{ $pv->status }}">
                                                <span class="badge bg-warning">{{ ucfirst($pv->status) }}</span>
                                            </button>
                                        @else
                                            <span class="badge bg-warning">{{ ucfirst($pv->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pv->start_time && $pv->end_time)
                                            {{ \Carbon\Carbon::parse($pv->start_time)->diffInDays(\Carbon\Carbon::parse($pv->end_time)) }} hari
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>-</td>
                                    <td>
                                        <a href="{{ route('vmrentals.show', $pv->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
                                        <form action="{{ route('admin.vmrentals.respond', $pv->id) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button class="btn btn-sm btn-success">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.vmrentals.respond', $pv->id) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button class="btn btn-sm btn-danger">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        {{-- Approved / processed VM rentals that were from pending (show them so user appears in admin list) --}}
                        @if(!empty($pendingVmrentals) && $pendingVmrentals->count())
                            @php
                                $processedVmrentals = $pendingVmrentals->filter(function($item) {
                                    return isset($item->status) && strtolower($item->status) !== 'pending';
                                });
                            @endphp

                            @foreach($processedVmrentals as $pv)
                                <tr>
                                    <td>{{ $pv->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php $theUser = $pv->user ?? null; @endphp
                                            <img src="{{ $theUser && $theUser->avatar ? asset('storage/'.$theUser->avatar) : asset('images/default-avatar.png') }}" alt="avatar" width="32" height="32" class="rounded-circle me-2" />
                                            {{ $theUser->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info">{{ $pv->vm->name ?? '-' }}</span></td>
                                    <td>
                                        @if($pv->start_time)
                                            @if(strtolower($pv->status) === 'active')
                                                {{ \Carbon\Carbon::parse($pv->start_time)->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($pv->start_time)->format('d/m/Y') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($pv->end_time)
                                            @if(strtolower($pv->status) === 'active')
                                                {{ \Carbon\Carbon::parse($pv->end_time)->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($pv->end_time)->format('d/m/Y') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $st = strtolower($pv->status);
                                            $cls = $st === 'active' ? 'success' : ($st === 'cancelled' ? 'secondary' : 'warning');
                                        @endphp
                                        @if(auth()->user() && auth()->user()->isAdmin())
                                            <button type="button" class="btn p-0 border-0 status-badge-btn-rental" data-model="vmrental" data-rental-id="{{ $pv->id }}" data-rental-status="{{ $pv->status }}">
                                                <span class="badge bg-{{ $cls }}">{{ ucfirst($pv->status) }}</span>
                                            </button>
                                        @else
                                            <span class="badge bg-{{ $cls }}">{{ ucfirst($pv->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pv->start_time && $pv->end_time)
                                            {{ \Carbon\Carbon::parse($pv->start_time)->diffInDays(\Carbon\Carbon::parse($pv->end_time)) }} hari
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $pv->admin->name ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('vmrentals.show', $pv->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('vmrentals.edit', $pv->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDeleteVM({{ $pv->id }})"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                {{-- Hidden delete form for vm rental --}}
                                <form id="delete-vm-form-{{ $pv->id }}" action="{{ route('vmrentals.destroy', $pv->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        @endif

                        {{-- Regular rentals list --}}
                        {{-- Show processed VM rentals (these come from vmrentals table and represent VM-specific rentals) --}}
                        @if(!empty($vmrentals) && $vmrentals->count())
                            @foreach($vmrentals as $pv)
                                <tr>
                                    <td>{{ $pv->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php $theUser = $pv->user ?? null; @endphp
                                            <img src="{{ $theUser && $theUser->avatar ? asset('storage/'.$theUser->avatar) : asset('images/default-avatar.png') }}" alt="avatar" width="32" height="32" class="rounded-circle me-2" />
                                            {{ $theUser->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info">{{ $pv->vm->name ?? '-' }}</span></td>
                                    <td>
                                        @if($pv->start_time)
                                            @if(strtolower($pv->status) === 'active')
                                                {{ \Carbon\Carbon::parse($pv->start_time)->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($pv->start_time)->format('d/m/Y') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($pv->end_time)
                                            @if(strtolower($pv->status) === 'active')
                                                {{ \Carbon\Carbon::parse($pv->end_time)->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($pv->end_time)->format('d/m/Y') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $st = strtolower($pv->status);
                                            $cls = $st === 'active' ? 'success' : ($st === 'cancelled' ? 'secondary' : 'warning');
                                        @endphp
                                        @if(auth()->user() && auth()->user()->isAdmin())
                                            <button type="button" class="btn p-0 border-0 status-badge-btn-rental" data-model="vmrental" data-rental-id="{{ $pv->id }}" data-rental-status="{{ $pv->status }}">
                                                <span class="badge bg-{{ $cls }}">{{ ucfirst($pv->status) }}</span>
                                            </button>
                                        @else
                                            <span class="badge bg-{{ $cls }}">{{ ucfirst($pv->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pv->start_time && $pv->end_time)
                                            {{ \Carbon\Carbon::parse($pv->start_time)->diffInDays(\Carbon\Carbon::parse($pv->end_time)) }} hari
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $pv->admin->name ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('vmrentals.show', $pv->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('vmrentals.edit', $pv->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDeleteVM({{ $pv->id }})"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                {{-- Hidden delete form for vm rental (used by admin delete) --}}
                                <form id="delete-vm-form-{{ $pv->id }}" action="{{ route('vmrentals.destroy', $pv->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        @endif

                        @if(!empty($rentals) && $rentals->count())
                            @foreach($rentals as $rental)
                            <tr>
                                <td>{{ $rental->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php $theUser = $rental->user ?? null; @endphp
                                        <img src="{{ $theUser && $theUser->avatar ? asset('storage/'.$theUser->avatar) : asset('images/default-avatar.png') }}" alt="avatar" width="32" height="32" class="rounded-circle me-2" />
                                        {{ $theUser->name ?? '-' }}
                                    </div>
                                </td>
                                <td><span class="badge bg-info">{{ $rental->vm->name ?? '-' }}</span></td>
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
                            @endforeach
                        @endif

                        {{-- Show empty message only if there are no rows in any rental-related collections --}}
                        @php
                            $totalRows = 0;
                            $totalRows += (!empty($pendingVmrentals) ? $pendingVmrentals->count() : 0);
                            $totalRows += (!empty($vmrentals) ? $vmrentals->count() : 0);
                            $totalRows += (!empty($rentals) ? $rentals->count() : 0);
                        @endphp

                        @if($totalRows === 0)
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>Belum ada data rental</h5>
                                        <p>Klik tombol "Tambah Rental" untuk menambah data baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
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

        <!-- Rental status modal (admin) -->
        <div class="modal fade" id="rentalStatusModal" tabindex="-1" aria-labelledby="rentalStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rentalStatusModalLabel">Ubah Status Rental</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>VM / User: <strong id="rentalStatusModalName"></strong></p>
                        <p>Apa anda yakin ingin mengubah status ini?</p>
                        <div class="mb-2">Pilih status baru:</div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rental_status" id="r_status_active" value="active">
                            <label class="form-check-label" for="r_status_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rental_status" id="r_status_expired" value="expired">
                            <label class="form-check-label" for="r_status_expired">Expired</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rental_status" id="r_status_pending" value="pending">
                            <label class="form-check-label" for="r_status_pending">Pending</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rental_status" id="r_status_cancelled" value="cancelled">
                            <label class="form-check-label" for="r_status_cancelled">Cancelled</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="button" id="confirmRentalStatusChangeBtn" class="btn btn-primary">Ya</button>
                    </div>
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
<script>
function confirmDeleteVM(vmrentalId) {
    Swal.fire({
        title: 'Yakin ingin menghapus permintaan sewa VM ini?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-vm-form-' + vmrentalId).submit();
        }
    });
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('rentalStatusModal');
    if (!modalEl) return;
    const modal = new bootstrap.Modal(modalEl);
    let currentRentalId = null;

    document.querySelectorAll('.status-badge-btn-rental').forEach(function(btn) {
        btn.addEventListener('click', function() {
            currentRentalId = this.dataset.rentalId;
            const current = this.dataset.rentalStatus;
            const model = this.dataset.model || 'rental';
            modalEl.dataset.model = model;
            const tr = this.closest('tr');
            const nameEl = document.getElementById('rentalStatusModalName');
            if (tr && nameEl) {
                const vmCell = tr.querySelector('td:nth-child(3) .badge, td:nth-child(3)');
                nameEl.textContent = vmCell ? vmCell.textContent.trim() : ('Rental ' + currentRentalId);
            }

            modalEl.querySelectorAll('input[name="rental_status"]').forEach(function(r) { r.checked = (r.value === current); });
            modal.show();
        });
    });

    const confirmBtn = document.getElementById('confirmRentalStatusChangeBtn');
    confirmBtn && confirmBtn.addEventListener('click', function() {
        if (!currentRentalId) return;
        const selected = modalEl.querySelector('input[name="rental_status"]:checked');
        if (!selected) { alert('Pilih status terlebih dahulu'); return; }
        const chosen = selected.value;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const model = modalEl.dataset.model || 'rental';
    const url = (model === 'vmrental' ? '/vmrentals/' + currentRentalId + '/status' : '/rentals/' + currentRentalId + '/status');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: chosen })
        }).then(res => res.json()).then(data => {
            if (data && data.success) {
                const btn = document.querySelector('.status-badge-btn-rental[data-rental-id="' + currentRentalId + '"]');
                if (btn) {
                    // pick a class for badge: active -> success, cancelled -> secondary, expired -> warning, inactive -> secondary, pending -> warning
                    let cls = 'bg-warning';
                    if (chosen === 'active') cls = 'bg-success';
                    else if (chosen === 'cancelled' || chosen === 'inactive') cls = 'bg-secondary';
                    else if (chosen === 'expired' || chosen === 'pending') cls = 'bg-warning';

                    btn.innerHTML = '<span class="badge ' + cls + '">' + (chosen.charAt(0).toUpperCase() + chosen.slice(1)) + '</span>';
                    btn.dataset.rentalStatus = chosen;
                }
                modal.hide();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message || 'Status diperbarui' });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: (data && data.message) ? data.message : 'Gagal memperbarui status' });
            }
        }).catch(err => {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat menghubungi server.' });
        });
    });
});
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