@extends('layouts.app')

@section('content')
@section('title', 'Tambah Rental')
@section('page-title', 'Tambah Rental')
<div class="container">
    


    <form action="{{ route('rentals.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>VM </label>
            <select name="vm_id" class="form-control" required>
                <option value="">-- Pilih VM --</option>
                @foreach($vms as $vm)
                    <option value="{{ $vm->id }}">{{ $vm->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Penanggung Jawab</label>
            <select name="admin_id" class="form-control" required>
                <option value="">-- Pilih Admin --</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
