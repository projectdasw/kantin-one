@extends('layouts.dashboard')
@section('page-title', 'Master Kantin')
@section('page-description', 'Kelola data kantin yang tersedia')

@section('page-actions')
    <a href="{{ route('canteens.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Kantin
    </a>
@endsection

@section('dashboard-content')
    <div class="container p-0">
        <form id="canteenSearchForm" action="{{ route('canteens.search') }}" method="POST">
            @csrf

            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" id="canteenSearchInput" class="form-control"
                            placeholder="Cari kode atau nama kantin..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" id="canteenStatusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <button type="button" id="canteenResetFilter" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </form>

        <div id="canteensTableContainer">
            @include('canteens.partials.table')
        </div>
    </div>
@endsection