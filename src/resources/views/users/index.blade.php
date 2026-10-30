@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('page-title', 'Manajemen Pengguna')

@section('page-description', 'Kelola akun dan hak akses pengguna Kantin.ONE.')

@section('dashboard-content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Pengguna</h4>
            <p class="text-muted mb-0">
                Kelola akun dan hak akses pengguna Kantin.ONE.
            </p>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Pengguna
        </a>
    </div>

    {{-- Summary --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Total Pengguna</div>
                    <h3 class="fw-bold mb-0">
                        {{ $users->total() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Pengguna Aktif</div>
                    <h3 class="fw-bold text-success mb-0">
                        {{ \App\Models\User::where('is_active', true)->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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

    {{-- User Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">Daftar Pengguna</h5>
        </div>

        <div class="card-body px-4">

            {{-- Filter --}}
            <form
    method="GET"
    action="{{ route('users.index') }}"
    class="row g-2 mb-4"
    id="userSearchForm"
>

                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search"></i>
                        </span>
                        <input
    type="text"
    name="search"
    id="userSearchInput"
    class="form-control"
    placeholder="Cari nama, email, atau username..."
    value="{{ request('search') }}"
    autocomplete="off"
>
                    </div>
                </div>

                <div class="col-lg-3">
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}"
                                @selected(request('role') === $role)>
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
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        <i class="fas fa-rotate-left"></i>
                    </a>
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
<script>
   
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('userSearchForm');
    const searchInput = document.getElementById('userSearchInput');
    const tableContainer = document.getElementById('usersTableContainer');

    if (!searchForm || !searchInput || !tableContainer) return;

    let searchTimeout;
    let controller;

    async function loadUsers(url) {
        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        tableContainer.style.opacity = '0.5';

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: controller.signal
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data pengguna.');
            }

            const html = await response.text();

            tableContainer.innerHTML = html;

            window.history.replaceState({}, '', url);

        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error(error);
                Swal.fire('Gagal', 'Tidak dapat memuat data pengguna.', 'error');
            }
        } finally {
            tableContainer.style.opacity = '1';
        }
    }

    // Live search
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(() => {
            const url = new URL(searchForm.action, window.location.origin);
            const formData = new FormData(searchForm);

            formData.forEach((value, key) => {
                if (value !== '') {
                    url.searchParams.set(key, value);
                }
            });

            // Pencarian baru selalu dimulai dari halaman pertama
            url.searchParams.delete('page');

            loadUsers(url.toString());
        }, 350);
    });

    // Filter role dan status menggunakan AJAX juga
    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        clearTimeout(searchTimeout);

        const url = new URL(searchForm.action, window.location.origin);
        const formData = new FormData(searchForm);

        formData.forEach((value, key) => {
            if (value !== '') {
                url.searchParams.set(key, value);
            }
        });

        url.searchParams.delete('page');

        loadUsers(url.toString());
    });

    // Pagination tanpa reload
    tableContainer.addEventListener('click', function (event) {
        const link = event.target.closest('.pagination a');

        if (!link) return;

        event.preventDefault();
        loadUsers(link.href);
    });

    // SweetAlert untuk aktivasi dan deaktivasi
    document.addEventListener('submit', function (event) {
        const form = event.target.closest('.status-form');

        if (!form) return;

        event.preventDefault();

        const name = form.dataset.name;
        const isActive = form.dataset.active === '1';

        Swal.fire({
            title: isActive ? 'Nonaktifkan pengguna?' : 'Aktifkan pengguna?',
            text: `Apakah Anda yakin ingin ${
                isActive ? 'menonaktifkan' : 'mengaktifkan'
            } akun ${name}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

</script>
@endpush
