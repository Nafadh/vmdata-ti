@extends('layouts.app')

@section('title', 'VMDATA TI')
@section('page-title', 'Reports')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5>Pilih laporan</h5>
            <ul>
                <li><a href="{{ route('admin.reports.rental') }}">Laporan Penyewaan VM</a></li>
                <li><a href="{{ route('admin.reports.vm') }}">Laporan VM</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
