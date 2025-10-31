@extends('layouts.app')

@section('title', 'Detail Permintaan Sewa')
@section('page-title', 'Detail Permintaan Sewa')

@section('content')
<div class="container-fluid">
    <!--<h2 class="mb-4">Detail Permintaan Sewa</h2>-->

    <div class="card">
        <div class="card-body">
            <p><strong>VM:</strong> {{ $rental->vm->name ?? '-' }}</p>
            <p>
                <strong>User:</strong>
                @php $theUser = $rental->user ?? auth()->user(); @endphp
                <span class="d-inline-flex align-items-center">
                    <span>{{ $theUser->name ?? '-' }}</span>
                </span>
            </p>
            <p><strong>Periode:</strong> {{ optional($rental->start_time)->format('d/m/Y') }} - {{ optional($rental->end_time)->format('d/m/Y') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($rental->status) }}</p>
            <p><strong>Tujuan:</strong> {{ $rental->purpose }}</p>
            <hr>
            @if($rental->vm && ($rental->status === 'active' || auth()->user()->isAdmin()) )
                <h6 class="mt-3">Access Credentials</h6>
                <p><strong>Username:</strong> {{ $rental->vm->access_username ?? '-' }}</p>
                <p><strong>Password:</strong> <code>{{ $rental->vm->access_password ?? '-' }}</code></p>
                <p class="small text-muted">Hanya user pemohon yang mendapatkan akses ini saat rental aktif atau admin dapat melihatnya kapan saja.</p>
            @endif
            <h6>Resources Requested</h6>
            <p><strong>CPU:</strong> {{ $rental->cpu ?? ($rental->vm->cpu ?? '-') }} vCPU</p>
            <p><strong>RAM:</strong> {{ $rental->ram ?? ($rental->vm->ram ?? '-') }} GB</p>
            <p><strong>Storage:</strong> {{ $rental->storage ?? ($rental->vm->storage ?? '-') }} GB</p>
            
            <p><strong>Periode:</strong> {{ optional($rental->start_time)->format('d/m/Y') }} - {{ optional($rental->end_time)->format('d/m/Y') }}</p>
        </div>
    </div>

</div>
@endsection
