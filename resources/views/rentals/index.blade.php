@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rental Management</h1>
    <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">Tambah Rental</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>VM / Server</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>Status</th>
                <th>Durasi (hari)</th>
                <th>Penanggung Jawab</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
                <tr>
                    <td>{{ $rental->id }}</td>
                    <td>{{ $rental->user->name }}</td>
                    <td>{{ $rental->vm->name }}</td>
                    <td>{{ $rental->start_date }}</td>
                    <td>{{ $rental->end_date }}</td>
                    <td>{{ $rental->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($rental->start_date)->diffInDays($rental->end_date) }}</td>
                    <td>{{ $rental->admin->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $rentals->links() }}
</div>
@endsection
