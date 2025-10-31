@extends('layouts.app')

@section('title', 'VMDATA TI')
@section('page-title', 'Pengaturan')
@section('content')
<div class="container">

    {{-- Notifications shown in layout (single alert) --}}

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Description</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($settings as $s)
            <tr>
                <td>{{ $s->key }}</td>
                <td>{{ $s->value }}</td>
                <td>{{ $s->description }}</td>
                <td><a href="{{ route('admin.settings.edit', $s) }}" class="btn btn-sm btn-primary">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
