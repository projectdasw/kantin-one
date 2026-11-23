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
                        <h2 class="fw-bold m-0 mt-1">{{ $users->total() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-success h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Akun Aktif</span>
                        <h2 class="fw-bold m-0 mt-1">
                            {{ \App\Models\User::where('is_active', true)->count() }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-danger h-100 border-0" style="width: 8rem;">
                    <div class="card-body text-center">
                        <span class="small">Akun Nonaktif</span>
                        <h2 class="fw-bold m-0 mt-1">
                            {{ \App\Models\User::where('is_active', false)->count() }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <div class="container p-0">
        {{-- User Table --}}
        {{-- Filter --}}
        <form method="POST" action="{{ route('users.search') }}" class="row g-2 mb-2" id="userSearchForm">
            @csrf
            <div class="col-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="search" name="search" id="userSearchInput" class="form-control"
                        placeholder="Cari nama, email, atau username..." value="{{ request('search') }}"
                        autocomplete="off">
                </div>
            </div>
            <div class="col-2">
                <select name="role" class="form-select form-select-sm">
                    <option value="" selected disabled>Peran Akun</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(request('role') === $role)>
                            {{ ucwords(str_replace('_', ' ', $role)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <select name="status" class="float-end form-select form-select-sm">
                    <option value="" selected disabled>Status Akun</option>
                    <option value="1" @selected(request('status') === '1')>
                        Aktif
                    </option>
                    <option value="0" @selected(request('status') === '0')>
                        Nonaktif
                    </option>
                </select>
            </div>
            <div class="col-2">
                <button type="button" class="float-end btn btn-sm btn-secondary" id="userResetFilter">
                    <i class="fas fa-undo me-1"></i>
                    <span>Reset Filter</span>
                </button>
            </div>
        </form>

        {{-- Table --}}
        <div id="usersTableContainer" aria-live="polite">
            @include('users.partials.table')
        </div>
    </div>
@endsection