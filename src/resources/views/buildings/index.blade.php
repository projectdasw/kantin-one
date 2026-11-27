@extends('layouts.dashboard')

@section('page-title', 'Master Gedung')
@section('page-description', 'Kelola data gedung yang tersedia di Kantin.ONE.')

@section('page-actions')
    <a href="{{ route('buildings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Gedung
    </a>
@endsection

@section('dashboard-content')

    {{-- Filter Gedung --}}
    <div id="buildingFilters" class="d-flex flex-wrap align-items-center gap-2">

        <select id="buildingStatus" class="form-select form-select-sm" style="width: 145px;">
            <option value="">Semua Status</option>
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>

        <button type="button" id="resetBuildingFilters" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-undo me-1"></i> Reset
        </button>

    </div>

    {{-- Tabel Gedung --}}
    <div class="table-responsive" id="buildingsTableContainer">
        {!! $dataTable->table([
            'class' => 'table table-hover align-middle mb-0',
        ]) !!}
    </div>

@endsection

@push('scripts')
    @vite('resources/js/pages/buildings/buildings.js')
    {!! $dataTable->scripts() !!}
@endpush
