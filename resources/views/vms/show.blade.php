@extends('layouts.app')

@section('title', 'Detail Virtual Machine')
@section('page-title', 'Detail Virtual Machine')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm rounded">
        <div class="card-body">
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
                <tr><th>RAM</th><td>{{ $vm->ram }} MB</td></tr>
                <tr><th>Storage</th><td>{{ $vm->storage }} GB</td></tr>
                <tr><th>Backup Disk</th><td>{{ $vm->backup_disk ?? '-' }}</td></tr>
                <tr><th>Storage Local</th><td>{{ $vm->storage_local ?? '-' }}</td></tr>
                <tr><th>Penggunaan</th><td>{{ $vm->usage ?? '-' }}</td></tr>
                <tr><th>Penanggung Jawab</th><td>{{ $vm->owner ?? '-' }}</td></tr>
            </table>

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
