@extends('layouts.app')

@section('title', 'Tambah VM')
@section('page-title', 'Tambah VM')

@section('content')
<div class="container mt-4">
    <!--<h2>Tambah VM Baru</h2>-->
    <form action="{{ route('vms.store') }}" method="POST">
        @csrf
        @if(isset($rental))
            <input type="hidden" name="rental_id" value="{{ $rental->id }}">
        @endif

        <!-- Nama VM -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama VM</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Kategori (fixed options) -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="basic" {{ old('category_id') == 'basic' ? 'selected' : '' }}>Basic</option>
                <option value="standard" {{ old('category_id') == 'standard' ? 'selected' : '' }}>Standard</option>
                <option value="premium" {{ old('category_id') == 'premium' ? 'selected' : '' }}>Premium</option>
                <option value="elite" {{ old('category_id') == 'elite' ? 'selected' : '' }}>Elite</option>
            </select>
        </div>

        <!-- RAM (GB) -->
        <div class="mb-3">
            <label for="ram" class="form-label">RAM (GB)</label>
            <input type="number" class="form-control" id="ram" name="ram" min="1" value="{{ old('ram', isset($rental) ? $rental->ram : '') }}" required>
        </div>

        <!-- CPU (vCPU cores) -->
        <div class="mb-3">
            <label for="cpu" class="form-label">CPU (vCPU)</label>
            <input type="number" class="form-control" id="cpu" name="cpu" min="1" step="1" value="{{ old('cpu', isset($rental) ? $rental->cpu : 1) }}" required>
            <div class="form-text">Masukkan jumlah vCPU (misal: 1, 2, 4). Pastikan tidak melebihi kapasitas server.</div>
        </div>

        <!-- Server (required) -->
        <div class="mb-3">
            <label for="server_id" class="form-label">Server</label>
                <select class="form-select" id="server_id" name="server_id" required>
                    @if(isset($servers))
                        @foreach($servers as $server)
                            <option value="{{ $server->id }}" {{ (old('server_id', isset($selectedServerId) ? $selectedServerId : null) == $server->id) ? 'selected' : '' }}>{{ $server->name }}</option>
                        @endforeach
                    @endif
                </select>
        </div>

      <!-- Storage -->
        <div class="mb-3">
            <label for="storage" class="form-label">Storage (GB)</label>
          <input type="number" class="form-control" id="storage" name="storage" min="1" value="{{ old('storage', isset($rental) ? $rental->storage : '') }}" required>
        </div>

      

      <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
          <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', isset($rental) ? $rental->purpose : '') }}</textarea>
        </div>

        <!-- Access Credentials -->
        <div class="mb-3">
            <label for="access_username" class="form-label">Username (akses VM)</label>
            <input type="text" class="form-control" id="access_username" name="access_username" value="{{ old('access_username') }}" placeholder="opsional - username untuk login ke VM">
        </div>
        <div class="mb-3">
            <label for="access_password" class="form-label">Password (akses VM)</label>
            <input type="password" class="form-control" id="access_password" name="access_password" value="" placeholder="opsional - password untuk login ke VM">
            <div class="form-text">Password akan disimpan terenkripsi. Biarkan kosong jika ingin generate terpisah.</div>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="offline" {{ old('status') == 'offline' ? 'selected' : '' }}>Offline</option>
                </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('vms.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

    <!-- no scripts required for spec-to-ram mapping anymore -->
