@extends('layouts.dashboard')

@section('page-title', 'Master Lantai')
@section('page-description', 'Kelola data lantai berdasarkan gedung di Kantin.ONE.')

@section('page-actions')
    <a href="{{ route('floors.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Lantai
    </a>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-1">Daftar Lantai</h5>
        <small class="text-muted">
            Informasi seluruh lantai yang terdaftar pada setiap gedung.
        </small>
    </div>

    <div class="card-body">
        <form id="floorSearchForm"
              action="{{ route('floors.search') }}"
              method="POST">
            @csrf

            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search"></i>
                        </span>

                        <input type="text"
                               name="search"
                               id="floorSearchInput"
                               class="form-control"
                               placeholder="Cari kode, nama lantai, atau gedung..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="building_id"
                            id="floorBuildingFilter"
                            class="form-select">
                        <option value="">Semua Gedung</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"
                                {{ request('building_id') === $building->id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status"
                            id="floorStatusFilter"
                            class="form-select">
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

                    <button type="button"
                            id="floorResetFilter"
                            class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </form>

        <div id="floorsTableContainer">
            @include('floors.partials.table')
        </div>
    </div>
</div>

@endsection

@vite('resources/js/pages/floors/floors.js')