@extends('layouts.app')

@section('title', 'VMDATA TI')
@section('page-title', 'Notifikasi Admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Notifikasi Terbaru</h5>
                @if(!$notifications->isEmpty())
                    <form action="{{ route('admin.notifications.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('Bersihkan semua notifikasi?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Bersihkan Semua</button>
                    </form>
                @endif
            </div>
            @if($notifications->isEmpty())
                <div class="text-muted">Belum ada notifikasi.</div>
            @else
                <ul class="list-group">
                    @foreach($notifications as $note)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div>{{ $note->data['message'] ?? 'Notifikasi' }}</div>
                                <small class="text-muted">{{ $note->created_at->format('Y-m-d') }}</small>
                            </div>
                            <div>
                                <a href="{{ $note->data['url'] ?? '#' }}" class="btn btn-sm btn-primary me-2">Lihat</a>
                                <form action="{{ route('admin.notifications.read', $note->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus notifikasi ini?');">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
