@extends('layouts.app')

@section('title', 'Virtual Machine')
@section('page-title', 'Virtual Machine')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">Daftar Server & Virtual Machine</h2>

    @forelse($servers as $serverIndex => $server)
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
                            <th>Spesifikasi</th>
                            <th>Status</th>
                            <th>Backup Disk</th>
                            <th>Storage Local</th>
                            <th>Penggunaan</th>
                            <th>Penanggung Jawab</th>
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
                                    <small>
                                        <strong>CPU:</strong> {{ $vm->specification->cpu ?? 'N/A' }} Core<br>
                                        <strong>RAM:</strong> {{ $vm->specification->ram ?? 'N/A' }} GB<br>
                                        <strong>Storage:</strong> {{ $vm->specification->storage ?? 'N/A' }} GB
                                    </small>
                                </td>

                                <td class="text-center">
                                    @if(isset($vm->status))
                                        @if($vm->status === 'running')
                                            <span class="badge bg-success">Running</span>
                                        @elseif($vm->status === 'stopped')
                                            <span class="badge bg-secondary">Stopped</span>
                                        @elseif($vm->status === 'maintenance')
                                            <span class="badge bg-warning">Maintenance</span>
                                        @else
                                            <span class="badge bg-info">{{ ucfirst($vm->status) }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $vm->specification->backup_disk ?? '-' }}</td>
                                <td class="text-center">{{ $vm->specification->storage_local ?? '-' }}</td>
                                <td class="text-center">{{ $vm->specification->usage ?? '-' }}</td>
                                <td class="text-center">{{ $vm->specification->responsible ?? '-' }}</td>
                                <td class="text-center">
                                    @if(isset($vm->id))
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('vms.show', $vm->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('vms.edit', $vm->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('vms.destroy', $vm->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Yakin ingin menghapus VM {{ $vm->name ?? 'ini' }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
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

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any JavaScript functionality here
    
    // Example: Confirm delete with custom message
    document.querySelectorAll('form[method="POST"]').forEach(form => {
        const button = form.querySelector('button[type="submit"]');
        if (button && button.onclick) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const vmName = this.closest('tr')?.querySelector('td:nth-child(2) strong')?.textContent || 'VM ini';
                if (confirm(`Yakin ingin menghapus ${vmName}? Tindakan ini tidak dapat dibatalkan.`)) {
                    form.submit();
                }
            });
        }
    });
});
</script>
@endpush