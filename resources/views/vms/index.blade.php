@extends('layouts.app')

@section('title', 'VMDATA TI')
@section('page-title', 'Virtual Machine')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">Daftar Server & Virtual Machine</h2>

    @php
        // Ensure we only display up to 3 servers on this page
        $displayServers = $servers ?? collect();
        if (is_array($displayServers)) {
            $displayServers = collect($displayServers);
        }
        $displayServers = $displayServers->take(3);
    @endphp

    @forelse($displayServers as $serverIndex => $server)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Server {{ $serverIndex + 1 }}: {{ $server->name }}</strong>
            </div>
            <div class="card-body">

                <!-- Server Info -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Local Network</h6>
                        <div class="p-2 border rounded bg-light">
                            {{ $server->local_network }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">IP Address</h6>
                        <div class="p-2 border rounded bg-light">
                            {{ $server->ip_address ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Status</h6>
                        <div class="p-2 border rounded bg-light">
                            @if($server->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($server->status === 'maintenance')
                                <span class="badge bg-warning">Maintenance</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($server->description)
                    <div class="mb-3">
                        <h6 class="text-muted">Deskripsi</h6>
                        <div class="p-2 border rounded bg-light">
                            {{ $server->description }}
                        </div>
                    </div>
                @endif

                <!-- Daftar VM -->
                <h6 class="text-muted">Virtual Machines</h6>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Nama VM</th>
                                    <th>Kategori / Spec</th>
                                    <th>RAM (GB)</th>
                                    <th>CPU (vCPU)</th>
                                    <th>Storage (GB)</th>
                                    
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                    </thead>
                    <tbody>
                        @forelse($server->vms ?? [] as $index => $vm)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $vm->name ?? 'N/A' }}</strong>
                                    @if($vm->description)
                                        <br><small class="text-muted">{{ $vm->description }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $vm->category->name ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="small text-muted">
                                        {{ $vm->specification->name ?? '' }}
                                    </div>
                                </td>

                                <td class="text-center">{{ $vm->ram ?? ($vm->specification->ram ?? 'N/A') }}</td>
                                <td class="text-center">{{ $vm->cpu ?? ($vm->specification->cpu ?? 'N/A') }}</td>
                                <td class="text-center">{{ $vm->storage ?? ($vm->specification->storage ?? 'N/A') }}</td>
                                
                                <td class="text-center">{{ $vm->description ?? '-' }}</td>
                                <td class="text-center">
                                    @php $s = $vm->status ?? 'unknown'; @endphp
                                    @if(auth()->user() && auth()->user()->isAdmin())
                                        <button type="button" class="btn p-0 border-0 status-badge-btn" data-vm-id="{{ $vm->id }}" data-vm-status="{{ $s }}">
                                            @if($s === 'available')
                                                <span class="badge bg-success">Available</span>
                                            @elseif($s === 'rented')
                                                <span class="badge bg-warning text-dark">Rented</span>
                                            @elseif($s === 'maintenance')
                                                <span class="badge" style="background-color: #ff8c00; color: #fff;">Maintenance</span>
                                            @elseif($s === 'offline')
                                                <span class="badge bg-secondary">Offline</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($s) }}</span>
                                            @endif
                                        </button>
                                    @else
                                        @if($s === 'available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif($s === 'rented')
                                            <span class="badge bg-warning text-dark">Rented</span>
                                        @elseif($s === 'maintenance')
                                            <span class="badge" style="background-color: #ff8c00; color: #fff;">Maintenance</span>
                                        @elseif($s === 'offline')
                                            <span class="badge bg-secondary">Offline</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($s) }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('vms.show', $vm->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('vms.edit', $vm->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('vms.destroy', $vm->id) }}" method="POST" class="d-inline" data-confirm="Yakin ingin menghapus VM {{ $vm->name ?? 'ini' }}?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Belum ada Virtual Machine di server ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Add VM Button -->
                <div class="text-end mt-3">
                    <a href="{{ route('vms.create', ['server_id' => $server->id]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah VM
                    </a>
                </div>
            </div>
        </div>
    @empty
    <div class="alert alert-info d-flex align-items-center">
        <i class="fas fa-info-circle me-2"></i>
        <div>
            Belum ada server yang terdaftar. 
            {{-- Sementara disable link --}}
            <button class="btn btn-sm btn-primary ms-2" onclick="alert('Fitur tambah server akan segera tersedia')">
                <i class="fas fa-plus"></i> Tambah Server
            </button>
        </div>
    </div>
@endforelse

</div>

<!-- Loading indicator (optional) -->
<div id="loading" class="text-center mt-4" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Status change modal (admin) -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Ubah Status VM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>VM: <strong id="statusModalVmName"></strong></p>
                <div class="mb-2">Pilih status baru:</div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_available" value="available">
                    <label class="form-check-label" for="status_available">Available</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_rented" value="rented">
                    <label class="form-check-label" for="status_rented">Rented</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_maintenance" value="maintenance">
                    <label class="form-check-label" for="status_maintenance">Maintenance</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_offline" value="offline">
                    <label class="form-check-label" for="status_offline">Offline</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" id="confirmStatusChangeBtn" class="btn btn-primary">Ya</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ganti handler agar selalu menambahkan listener ke tombol submit form penghapusan
        document.querySelectorAll('form').forEach(function(form) {
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (!submitBtn) return;

            submitBtn.addEventListener('click', function(e) {
                // jika form memiliki data-confirm attribute gunakan itu, kalau tidak coba cari nama VM dari tabel
                const confirmText = form.getAttribute('data-confirm') ||
                    (function() {
                        const tr = this.closest('tr');
                        const nameCell = tr ? tr.querySelector('td:nth-child(2) strong, td:nth-child(2)') : null;
                        return `Yakin ingin menghapus ${nameCell ? nameCell.textContent.trim() : 'item ini'}? Tindakan ini tidak dapat dibatalkan.`;
                    }).call(this);

                if (!confirm(confirmText)) {
                    e.preventDefault();
                }
                // jika konfirmasi true, biarkan form submit normal
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusModalEl = document.getElementById('statusModal');
        if (!statusModalEl) return;
        const statusModal = new bootstrap.Modal(statusModalEl);
        let currentVmId = null;

        // fill VM name and current selection when admin clicks badge
        document.querySelectorAll('.status-badge-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                currentVmId = this.dataset.vmId;
                const current = this.dataset.vmStatus;
                // set vm name in modal
                const tr = this.closest('tr');
                const vmNameEl = document.getElementById('statusModalVmName');
                if (tr && vmNameEl) {
                    const nameCell = tr.querySelector('td:nth-child(2) strong, td:nth-child(2)');
                    vmNameEl.textContent = nameCell ? nameCell.textContent.trim() : ('VM ' + currentVmId);
                }

                // set radio checked
                statusModalEl.querySelectorAll('input[name="status"]').forEach(function(r) {
                    r.checked = (r.value === current);
                });

                statusModal.show();
            });
        });

        // confirm button sends AJAX request
        const confirmBtn = document.getElementById('confirmStatusChangeBtn');
        confirmBtn && confirmBtn.addEventListener('click', function() {
            if (!currentVmId) return;
            const selected = statusModalEl.querySelector('input[name="status"]:checked');
            if (!selected) {
                alert('Pilih status terlebih dahulu');
                return;
            }
            const chosen = selected.value;

            // send AJAX POST
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = '/vms/' + currentVmId + '/status';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: chosen })
            }).then(function(res) {
                return res.json();
            }).then(function(data) {
                if (data && data.success) {
                    // update badge in table
                    const btn = document.querySelector('.status-badge-btn[data-vm-id="' + currentVmId + '"]');
                    if (btn) {
                        let html = '';
                        if (chosen === 'available') html = '<span class="badge bg-success">Available</span>';
                        else if (chosen === 'rented') html = '<span class="badge bg-warning text-dark">Rented</span>';
                        else if (chosen === 'maintenance') html = '<span class="badge" style="background-color: #ff8c00; color: #fff;">Maintenance</span>';
                        else if (chosen === 'offline') html = '<span class="badge bg-secondary">Offline</span>';
                        btn.innerHTML = html;
                        btn.dataset.vmStatus = chosen;
                    }

                    statusModal.hide();

                    // show temporary alert
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success alert-dismissible fade show';
                    alert.role = 'alert';
                    alert.innerHTML = (data.message || 'Status berhasil diperbarui') + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                    const main = document.querySelector('main');
                    if (main) main.prepend(alert);
                } else {
                    alert((data && data.message) ? data.message : 'Gagal memperbarui status');
                }
            }).catch(function(err) {
                console.error(err);
                alert('Terjadi kesalahan saat menghubungi server.');
            });
        });
    });
</script>
@endpush