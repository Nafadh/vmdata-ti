@extends('layouts.app')

@section('title', 'Edit Virtual Machine')
@section('page-title', 'Edit Virtual Machine')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm rounded">
        <div class="card-body">
            <h4 class="mb-3">Form Edit Virtual Machine</h4>

            <form action="{{ route('vms.update', $vm->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama VM -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama VM</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $vm->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CPU -->
                <div class="mb-3">
                    <label for="cpu" class="form-label">CPU (Core)</label>
                    <input type="number" class="form-control @error('cpu') is-invalid @enderror"
                           id="cpu" name="cpu" value="{{ old('cpu', $vm->cpu) }}" required>
                    @error('cpu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- RAM -->
                <div class="mb-3">
                    <label for="ram" class="form-label">RAM (MB)</label>
                    <input type="number" class="form-control @error('ram') is-invalid @enderror"
                           id="ram" name="ram" value="{{ old('ram', $vm->ram) }}" required>
                    @error('ram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Storage -->
                <div class="mb-3">
                    <label for="storage" class="form-label">Storage (GB)</label>
                    <input type="number" class="form-control @error('storage') is-invalid @enderror"
                           id="storage" name="storage" value="{{ old('storage', $vm->storage) }}" required>
                    @error('storage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status"
                            class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="running" {{ old('status', $vm->status) == 'running' ? 'selected' : '' }}>Running</option>
                        <option value="stopped" {{ old('status', $vm->status) == 'stopped' ? 'selected' : '' }}>Stopped</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('vms.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
