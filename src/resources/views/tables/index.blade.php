@extends('layouts.dashboard')

@section('title', 'Manajemen Meja')

@section('page-title')
    <i class="fas fa-table me-2"></i> Manajemen Meja
@endsection

@section('page-description')
    Kelola meja food court dan akses QR meja.
@endsection

@section('page-actions')
    <a href="{{ route('tables.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Meja
    </a>

    <a href="{{ route('tables.trash') }}" class="btn btn-outline-secondary">
        <i class="fas fa-trash me-1"></i> Recycle Bin
    </a>
@endsection

@section('dashboard-content')

    {{-- Filter Manajemen Meja --}}
    <div id="tableFilters" class="d-flex flex-wrap align-items-center gap-2">

        <select id="tableStatus" class="form-select form-select-sm" style="width: 145px;">
            <option value="">Semua Status</option>
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>

        <button type="button" id="resetTableFilters" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-undo me-1"></i> Reset
        </button>

    </div>

    {{-- Tabel Manajemen Meja --}}
    <div class="table-responsive" id="tablesTableContainer">
        {!! $dataTable->table([
            'class' => 'table table-hover align-middle mb-0',
        ]) !!}
    </div>

@endsection

@push('scripts')
    @vite('resources/js/pages/tables/tables.js')
    {!! $dataTable->scripts() !!}
@endpush