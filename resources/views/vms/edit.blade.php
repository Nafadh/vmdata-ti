@extends('layouts.app')

@section('title', 'Edit VM')

@section('content')
<div class="container mt-4">
    <h2>Edit VM</h2>
    <form action="{{ route('vms.update', $vm->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama VM -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama VM</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $vm->name) }}" required>
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $vm->category) }}" required>
        </div>

        <!-- RAM -->
        <div class="mb-3">
            <label for="ram" class="form-label">RAM (GB)</label>
            <input type="number" class="form-control" id="ram" name="ram" min="1" value="{{ old('ram', $vm->ram) }}" required>
        </div>

        <!-- Storage -->
        <div class="mb-3">
            <label for="storage" class="form-label">Storage (GB)</label>
            <input type="number" class="form-control" id="storage" name="storage" min="1" value="{{ old('storage', $vm->storage) }}" required>
        </div>

        <!-- Backup Disk -->
        <div class="mb-3">
            <label for="backup_disk" class="form-label">Backup Disk (GB)</label>
            <input type="number" class="form-control" id="backup_disk" name="backup_disk" min="0" value="{{ old('backup_disk', $vm->backup_disk) }}">
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $vm->description) }}</textarea>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="available" {{ old('status', $vm->status) == 'available' ? 'selected' : '' }}>Available</option>
                <option value="active" {{ old('status', $vm->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="rented" {{ old('status', $vm->status) == 'rented' ? 'selected' : '' }}>Rented</option>
                <option value="inactive" {{ old('status', $vm->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('vms.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
