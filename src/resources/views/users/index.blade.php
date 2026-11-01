@extends('layouts.dashboard')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('page-description', 'Kelola pengguna yang memiliki akses ke sistem Kantin.ONE.')
@section('dashboard-content')
    @section('button-list')
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus me-1"></i>
                    Tambah Pengguna
                </a>
            </div>
        </div>
    @endsection
    @section('page-actions')
        {{-- Summary --}}
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total Pengguna</div>
                        <h3 class="fw-bold mb-0">{{ $users->total() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Pengguna Aktif</div>
                        <h3 class="fw-bold text-success mb-0">
                            {{ \App\Models\User::where('is_active', true)->count() }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Pengguna Nonaktif</div>
                        <h3 class="fw-bold text-danger mb-0">
                            {{ \App\Models\User::where('is_active', false)->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- <a href="{{ route('users.index', ['status' => 'inactive']) }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-user-slash me-1"></i>
            Akun Nonaktif
        </a>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus me-1"></i>
            Tambah Pengguna
        </a> -->
    @endsection

    <div class="container-fluid p-0">

        {{-- User Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
                <h5 class="fw-bold mb-0">Daftar Pengguna</h5>

                <div class="d-flex gap-2">
                    <a href="{{ route('users.trash') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-trash-alt me-1"></i>
                        Pengguna Terhapus
                    </a>
                </div>
            </div>

            <div class="card-body">

                {{-- Filter --}}
                <form method="POST"
                      action="{{ route('users.search') }}"
                      class="row g-2 mb-4"
                      id="userSearchForm">

                    @csrf

                    <div class="col-lg-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>

                            <input type="text"
                                   name="search"
                                   id="userSearchInput"
                                   class="form-control"
                                   placeholder="Cari nama, email, atau username..."
                                   value="{{ request('search') }}"
                                   autocomplete="off">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <select name="role" class="form-select">
                            <option value="">Semua Role</option>

                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected(request('role') === $role)>
                                    {{ ucwords(str_replace('_', ' ', $role)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" @selected(request('status') === '1')>
                                Aktif
                            </option>
                            <option value="0" @selected(request('status') === '0')>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-filter me-1"></i>
                            Filter
                        </button>

                        <button type="button"
                                class="btn btn-light"
                                id="userResetFilter">
                            <i class="fas fa-undo me-1"></i>
                            Reset
                        </button>
                    </div>
                </form>

                {{-- Table --}}
                <div id="usersTableContainer" aria-live="polite">
                    @include('users.partials.table')
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/users.js')
@endpush