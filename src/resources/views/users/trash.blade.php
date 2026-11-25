@extends('layouts.dashboard')
@section('title', 'Akun Kadaluarsa')
@section('page-title', 'Akun Kadaluarsa')
@section('page-description', 'Kelola akun yang telah kadaluarsa.')
@section('dashboard-content')
    @section('page-actions')
        <a href="{{ route('users.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Kembali</span>
        </a>
    @endsection

    <div class="container-fluid p-0">
        {{-- Filter Akun Kadaluarsa --}}
        <div id="userTrashFilters" class="d-flex flex-wrap align-items-center gap-2">

            <select id="userTrashRoleFilter"
                class="form-select form-select-sm"
                style="width: 160px;">
                <option value="">Semua Peran</option>

                @foreach ($roles as $role)
                    <option value="{{ $role }}">
                        {{ ucwords(str_replace('_', ' ', $role)) }}
                    </option>
                @endforeach
            </select>

            <select id="userTrashStatusFilter"
                class="form-select form-select-sm"
                style="width: 145px;">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>

            <button type="button" id="resetUserTrashFilters"
                class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-rotate-left me-1"></i>
                Reset
            </button>

        </div>

        {{-- Tabel Akun Kadaluarsa --}}
        <div class="table-responsive" id="usersTrashTableContainer">
            {{ $dataTable->table([
                'class' => 'table table-hover align-middle mb-0 w-100',
            ]) }}
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/users/crud.js')
    @vite('resources/js/pages/users/trash.js')
    {{ $dataTable->scripts() }}
@endpush