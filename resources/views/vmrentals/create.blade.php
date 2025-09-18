@extends('layouts.app')

@section('title', 'Buat Permintaan Sewa')
@section('page-title', 'Buat Permintaan Sewa VM')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Buat Permintaan Sewa VM</h2>

    <form action="{{ route('vmrentals.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Pilih VM</label>
            <select name="vm_id" class="form-control">
                @foreach($vms as $vm)
                    <option value="{{ $vm->id }}">{{ $vm->name }} ({{ $vm->status }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Mulai</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Selesai</label>
            <input type="datetime-local" name="end_time" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tujuan</label>
            <textarea name="purpose" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Kirim Permintaan</button>
    </form>
</div>
@endsection
