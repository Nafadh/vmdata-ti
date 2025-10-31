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

        <!-- Kategori (fixed options) -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            @php
                // Determine selected slug from VM. If slug is missing but name exists,
                // derive a simple slug from the name (lowercase, spaces -> hyphen).
                $currentCategory = optional($vm->category);
                $currentCategorySlug = $currentCategory->slug ?? null;
                if (!$currentCategorySlug && $currentCategory->name) {
                    $currentCategorySlug = strtolower(str_replace(' ', '-', $currentCategory->name));
                }
                $currentCategoryId = $vm->category_id;
            @endphp
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="basic" {{ old('category_id', $currentCategorySlug ?? $currentCategoryId) == 'basic' ? 'selected' : '' }}>Basic</option>
                <option value="standard" {{ old('category_id', $currentCategorySlug ?? $currentCategoryId) == 'standard' ? 'selected' : '' }}>Standard</option>
                <option value="premium" {{ old('category_id', $currentCategorySlug ?? $currentCategoryId) == 'premium' ? 'selected' : '' }}>Premium</option>
                <option value="elite" {{ old('category_id', $currentCategorySlug ?? $currentCategoryId) == 'elite' ? 'selected' : '' }}>Elite</option>
            </select>
        </div>
        
         <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="available" {{ old('status', $vm->status) == 'available' ? 'selected' : '' }}>Available</option>
                <option value="rented" {{ old('status', $vm->status) == 'rented' ? 'selected' : '' }}>Rented</option>
                <option value="maintenance" {{ old('status', $vm->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="offline" {{ old('status', $vm->status) == 'offline' ? 'selected' : '' }}>Offline</option>
            </select>
        </div>

        <!-- RAM (GB) -->
        <div class="mb-3">
            <label for="ram" class="form-label">RAM (GB)</label>
            <input type="number" class="form-control" id="ram" name="ram" min="1" value="{{ old('ram', $vm->ram) }}" required>
        </div>

        <!-- CPU (vCPU cores) -->
        <div class="mb-3">
            <label for="cpu" class="form-label">CPU (vCPU)</label>
            <input type="number" class="form-control" id="cpu" name="cpu" min="1" step="1" value="{{ old('cpu', $vm->cpu ?? 1) }}" required>
            <div class="form-text">Masukkan jumlah vCPU (misal: 1, 2, 4). Pastikan tidak melebihi kapasitas server.</div>
        </div>

       

        <!-- Server (required) -->
        <div class="mb-3">
            <label for="server_id" class="form-label">Server</label>
            <select class="form-select" id="server_id" name="server_id" required>
                @if(isset($servers))
                    @foreach($servers as $server)
                        <option value="{{ $server->id }}" {{ (old('server_id', $vm->server_id) == $server->id) ? 'selected' : '' }}>{{ $server->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <!-- Storage -->
        <div class="mb-3">
            <label for="storage" class="form-label">Storage (GB)</label>
            <input type="number" class="form-control" id="storage" name="storage" min="1" value="{{ old('storage', $vm->storage) }}" required>
        </div>


        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $vm->description) }}</textarea>
        </div>

        <!-- Access Credentials -->
        <div class="mb-3">
            <label for="access_username" class="form-label">Username (akses VM)</label>
            <input type="text" class="form-control" id="access_username" name="access_username" value="{{ old('access_username', $vm->access_username) }}" placeholder="opsional - username untuk login ke VM">
        </div>
        <div class="mb-3">
            <label for="access_password" class="form-label">Password (akses VM)</label>
            <input type="password" class="form-control" id="access_password" name="access_password" value="" placeholder="isi untuk mengganti password, biarkan kosong untuk mempertahankan yang ada">
            <div class="form-text">Password akan disimpan terenkripsi. Jika dibiarkan kosong, password saat ini tidak berubah.</div>
        </div>

       
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('vms.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
