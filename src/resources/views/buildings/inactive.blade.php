
@extends('layouts.dashboard')

@section('page-title', 'Gedung/Lahan Nonaktif')
@section('page-description', 'Daftar gedung atau lahan yang berstatus nonaktif.')

@section('page-actions')
    <a href="{{ route('buildings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Master Gedung
    </a>
@endsection

@section('dashboard-content')

    {{-- Tabel Gedung Nonaktif --}}
    <div class="table-responsive" id="buildingsInactiveTableContainer">
        {!! $dataTable->table([
            'class' => 'table table-hover align-middle mb-0',
        ]) !!}
    </div>

@endsection

@push('scripts')
    @vite('resources/js/pages/buildings/buildings.js')
    {!! $dataTable->scripts() !!}
@endpush
