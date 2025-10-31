@extends('layouts.app')

@section('title', 'Detail Virtual Machine')
@section('page-title', 'Detail Virtual Machine')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm rounded">
        <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        @if(session('blocking_rental_ids'))
                            <div class="mt-2">
                                <strong>Blocking rentals:</strong>
                                @foreach(session('blocking_rental_ids') as $rid)
                                    <a href="{{ route('rentals.show', $rid) }}" class="badge bg-danger text-white">#{{ $rid }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            <h4 class="mb-3">Informasi Virtual Machine</h4>

            <table class="table table-striped">
                <tr><th>Nama VM</th><td>{{ $vm->name }}</td></tr>
                <tr><th>Status</th>
                    <td>
                        @if($vm->status === 'running')
                            <span class="badge bg-success">Running</span>
                        @else
                            <span class="badge bg-secondary">Stopped</span>
                        @endif
                    </td>
                </tr>
                <tr><th>CPU</th><td>{{ $vm->cpu }} Core</td></tr>
                <tr><th>RAM</th><td>{{ $vm->ram }} GB</td></tr>
                <tr><th>Storage</th><td>{{ $vm->storage }} GB</td></tr>
                <tr><th>Penggunaan</th><td>{{ $vm->usage ?? '-' }}</td></tr>
                <tr><th>Penanggung Jawab</th><td>{{ $vm->owner ?? '-' }}</td></tr>
            </table>

            @php
                // Determine whether current user can see credentials:
                $canViewCreds = auth()->check() && (
                    auth()->user()->isAdmin() || // admin can always see
                    // or current user is the last renter assigned to this VM and the rental is active
                    optional($vm->rentals()->where('status','active')->latest()->first())->user_id === auth()->id()
                );
            @endphp

            @if($canViewCreds && ($vm->access_username || $vm->access_password))
                <div class="card mt-3">
                    <div class="card-header">Access Credentials</div>
                    <div class="card-body">
                        <p><strong>Username:</strong> {{ $vm->access_username ?? '-' }}</p>
                        <p><strong>Password:</strong> <code>{{ $vm->access_password ?? '-' }}</code></p>
                        <p class="small text-muted">Password tersimpan terenkripsi di database; hanya akun pemilik permintaan atau admin yang dapat melihatnya.</p>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('vms.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                <a href="{{ route('vms.edit', $vm->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                <form action="{{ route('vms.destroy', $vm->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Yakin ingin menghapus VM ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
