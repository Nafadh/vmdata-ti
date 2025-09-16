@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Rental</h1>

    <table class="table table-bordered">
        <tr>
            <th>ID Rental</th>
            <td>{{ $rental->id }}</td>
        </tr>
        <tr>
            <th>User</th>
            <td>{{ $rental->user->name }}</td>
        </tr>
        <tr>
            <th>VM / Server</th>
            <td>{{ $rental->vm->name }}</td>
        </tr>
        <tr>
            <th>Tanggal Mulai</th>
            <td>{{ $rental->start_date }}</td>
        </tr>
        <tr>
            <th>Tanggal Selesai</th>
            <td>{{ $rental->end_date }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $rental->status }}</td>
        </tr>
        <tr>
            <th>Durasi</th>
            <td>{{ \Carbon\Carbon::parse($rental->start_date)->diffInDays($rental->end_date) }} hari</td>
        </tr>
        <tr>
            <th>Penanggung Jawab</th>
            <td>{{ $rental->admin->name ?? '-' }}</td>
        </tr>
    </table>

    <a href="{{ route('rentals.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
