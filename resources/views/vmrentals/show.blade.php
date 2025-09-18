@extends('layouts.app')

@section('title', 'Detail Permintaan Sewa')
@section('page-title', 'Detail Permintaan Sewa')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Detail Permintaan Sewa</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>VM:</strong> {{ $rental->vm->name ?? '-' }}</p>
            <p><strong>User:</strong> {{ $rental->user->name ?? auth()->user()->name }}</p>
            <p><strong>Periode:</strong> {{ optional($rental->start_time)->format('Y-m-d H:i') }} - {{ optional($rental->end_time)->format('Y-m-d H:i') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($rental->status) }}</p>
            <p><strong>Total Biaya:</strong> Rp {{ number_format($rental->total_cost ?? 0,0,',','.') }}</p>
            <p><strong>Tujuan:</strong> {{ $rental->purpose }}</p>
        </div>
    </div>

</div>
@endsection
