@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Pengaturan: {{ $setting->key }}</h3>

    <form method="POST" action="{{ route('admin.settings.update', $setting) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Key</label>
            <input type="text" class="form-control" value="{{ $setting->key }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Value</label>
            <input type="text" name="value" class="form-control" value="{{ old('value', $setting->value) }}">
            @error('value') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" disabled>{{ $setting->description }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
