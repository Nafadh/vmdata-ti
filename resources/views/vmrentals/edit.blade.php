@extends('layouts.app')

@section('title', 'Edit Permintaan Sewa')
@section('page-title', 'Edit Permintaan Sewa VM')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Permintaan Sewa</h2>

    <form action="{{ route('vmrentals.update', $rental->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Pilih VM</label>
            <select name="vm_id" class="form-control">
                @foreach($vms as $vm)
                    <option value="{{ $vm->id }}" {{ $rental->vm_id == $vm->id ? 'selected' : '' }}>{{ $vm->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Mulai</label>
            <input type="datetime-local" name="start_time" value="{{ optional($rental->start_time)->format('Y-m-d\TH:i') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Selesai</label>
            <input type="datetime-local" name="end_time" value="{{ optional($rental->end_time)->format('Y-m-d\TH:i') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tujuan</label>
            <textarea name="purpose" class="form-control">{{ $rental->purpose }}</textarea>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
