@extends('layouts.app')

@section('title', 'Tambah VM')

@section('content')
<div class="container mt-4">
    <h2>Tambah VM Baru</h2>
    <form action="{{ route('vms.store') }}" method="POST">
        @csrf

        <!-- Nama VM -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama VM</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>

        <!-- RAM -->
        <div class="mb-3">
            <label for="ram" class="form-label">RAM (GB)</label>
            <input type="number" class="form-control" id="ram" name="ram" min="1" required>
        </div>

        <!-- Storage -->
        <div class="mb-3">
            <label for="storage" class="form-label">Storage (GB)</label>
            <input type="number" class="form-control" id="storage" name="storage" min="1" required>
        </div>

        <!-- Backup Disk -->
        <div class="mb-3">
            <label for="backup_disk" class="form-label">Backup Disk (GB)</label>
            <input type="number" class="form-control" id="backup_disk" name="backup_disk" min="0">
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="available">Available</option>
                <option value="rented">Rented</option>
                <option value="maintenance">Maintenance</option>
                <option value="offline">Offline</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('vms.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
