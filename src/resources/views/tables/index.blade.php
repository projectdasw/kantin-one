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

<div class="card border-0 shadow-sm">
    <div class="card-body">

        {{-- Search & Filter --}}
        <div class="row g-3 mb-4">

            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>

                    <input
                        type="text"
                        id="tableSearch"
                        class="form-control"
                        placeholder="Cari kode, nomor, nama, atau lokasi meja..."
                    >
                </div>
            </div>

            <div class="col-md-4">
                <select id="tableStatus" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

        </div>

        {{-- Table --}}
        <div id="tableContainer">
            @include('tables.partials.table')
        </div>

    </div>
</div>

@endsection