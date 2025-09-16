@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Rental</h1>

    <form action="{{ route('rentals.update', $rental->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required disabled>
                <option value="{{ $rental->user->id }}">{{ $rental->user->name }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label>VM / Server</label>
            <select name="vm_id" class="form-control" required disabled>
                <option value="{{ $rental->vm->id }}">{{ $rental->vm->name }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ $rental->start_date }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="{{ $rental->end_date }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Aktif" {{ $rental->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Selesai" {{ $rental->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Pending" {{ $rental->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Penanggung Jawab</label>
            <select name="admin_id" class="form-control" required>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $rental->admin_id == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
