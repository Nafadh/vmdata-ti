@extends('layouts.app')

@section('title', 'Buat Permintaan Sewa')

@section('page-title', 'Buat Permintaan Sewa VM')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('vmrentals.store') }}">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!--<div class="mb-3">
            <label class="form-label">Pilih VM</label>
            <select name="vm_id" class="form-control">
                <option value="">-- Pilih VM --</option>
                @foreach($vms as $vm)
                    <option value="{{ $vm->id }}" {{ old('vm_id') == $vm->id ? 'selected' : '' }}>{{ $vm->name }} ({{ $vm->status }})</option>
                @endforeach
            </select>
        </div>-->
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">CPU (vCPU)</label>
                <input type="number" name="cpu" min="1" class="form-control" value="{{ old('cpu', 1) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">RAM (GB)</label>
                <input type="number" name="ram" min="1" class="form-control" value="{{ old('ram') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Storage (GB)</label>
                <input type="number" name="storage" min="1" class="form-control" value="{{ old('storage') }}" required>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Mulai</label>
                <input type="date" name="start_time" class="form-control" required value="{{ old('start_time') ? \Carbon\Carbon::parse(old('start_time'))->format('Y-m-d') : '' }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Selesai</label>
                <input type="date" name="end_time" class="form-control" value="{{ old('end_time') ? \Carbon\Carbon::parse(old('end_time'))->format('Y-m-d') : '' }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Tujuan</label>
            <textarea name="purpose" class="form-control">{{ old('purpose') }}</textarea>
        </div>
        <button class="btn btn-primary">Kirim Permintaan</button>
    </form>
</div>
@endsection
