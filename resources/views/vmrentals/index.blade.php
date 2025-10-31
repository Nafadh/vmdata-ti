@extends('layouts.app')

@section('title', 'VMDATA TI')
@section('page-title', 'Daftar Permintaan Sewa VM')
@section('content')
<div class="container-fluid">
    
    <a href="{{ route('vmrentals.create') }}" class="btn btn-success mb-3">Buat Permintaan Sewa</a>

    {{-- Notifications are shown in the main layout to avoid duplicates --}}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>VM</th>
                <th>User</th>
                <th>Resources</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rentals as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->vm->name ?? '-' }}</td>
                    <td>{{ $r->user->name ?? auth()->user()->name }}</td>
                        <td>
                        CPU: {{ $r->cpu ?? ($r->vm->cpu ?? '-') }} vCPU<br>
                        RAM: {{ $r->ram ?? ($r->vm->ram ?? '-') }} GB<br>
                        Storage: {{ $r->storage ?? ($r->vm->storage ?? '-') }} GB
                    </td>
                    <td>{{ optional($r->start_time)->format('d/m/Y') }} - {{ optional($r->end_time)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($r->status) }}</td>
                    <td>
                        <a href="{{ route('vmrentals.show', $r->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        @if(auth()->id() === $r->user_id || auth()->user()->role === 'admin')
                            <a href="{{ route('vmrentals.edit', $r->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('vmrentals.destroy', $r->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada permintaan sewa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $rentals->links() ?? '' }}
</div>
@endsection
