@extends('layouts.dashboard')

@section('title', 'Master Akun')
@section('page-title', 'Master Akun')
@section('page-description', 'Daftar seluruh akun Kantin.ONE')

@section('dashboard-content')
    @section('page-actions')
        {{-- Summary --}}
        <div class="row row-cols-1 row-cols-md-3 g-2">
            <div class="col">
                <div class="card text-bg-dark h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Total Akun</span>
                        <h2 class="fw-bold m-0 mt-1">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-bg-success h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Akun Aktif</span>
                        <h2 class="fw-bold m-0 mt-1">{{ $activeUsers }}</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-bg-danger h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Akun Nonaktif</span>
                        <h2 class="fw-bold m-0 mt-1">{{ $inactiveUsers }}</h2>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    {{-- Filter Master Akun --}}
    <div id="userFilters" class="d-flex flex-wrap align-items-center gap-2">

        <select id="userRoleFilter"
            class="form-select form-select-sm"
            style="width: 160px;">
            <option value="">Semua Peran</option>

            @foreach ($roles as $role)
                <option value="{{ $role }}">
                    {{ ucwords(str_replace('_', ' ', $role)) }}
                </option>
            @endforeach
        </select>

        <select id="userStatusFilter"
            class="form-select form-select-sm"
            style="width: 145px;">
            <option value="">Semua Status</option>
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>

        <button type="button" id="resetUserFilters"
            class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-rotate-left me-1"></i>
            Reset
        </button>

    </div>

    {{-- Tabel Akun --}}
    <div class="table-responsive" id="usersTableContainer">
        {!! $dataTable->table([
            'class' => 'table table-hover align-middle mb-0',
        ]) !!}
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush