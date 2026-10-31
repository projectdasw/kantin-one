@extends('layouts.dashboard')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('page-description', 'Tambahkan akun pengguna baru Kantin.ONE.')
@section('dashboard-content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Tambah Pengguna</h4>
                <p class="text-muted mb-0">
                    Lengkapi informasi untuk membuat akun pengguna baru.
                </p>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        {{-- Form --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Informasi Pengguna</h5>
                <p class="text-muted small mb-0 mt-1">
                    Masukkan informasi akun pengguna.
                </p>
            </div>

            <div class="card-body px-4 pb-4">
                <form action="{{ route('users.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                            <div class="invalid-feedback">
                                Mohon isi nama lengkap.
                            </div>
                            <!-- @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror -->
                        </div>

                        {{-- Username --}}
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">
                                Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}" placeholder="Contoh: username123" maxlength="50" pattern="[a-z0-9_-]+" autocomplete="off" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Gunakan huruf kecil, angka, underscore, atau tanda hubung. Huruf besar tidak diperbolehkan.
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="nama@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="col-md-6">
                            <label for="role" class="form-label fw-semibold">
                                Role Pengguna <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" @selected(old('role') === $role)>
                                        {{ ucwords(str_replace('_', ' ', $role)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter" minlength="8" autocomplete="new-password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" aria-label="Tampilkan password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password"
                                    minlength="8" autocomplete="new-password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation" aria-label="Tampilkan konfirmasi password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Konfirmasi password harus sama dengan password.
                            </div>
                        </div>

                    </div>

                    {{-- Information --}}
                    <div class="alert alert-light border mt-4 mb-0">
                        <div class="d-flex gap-2">
                            <i class="fas fa-info-circle text-primary mt-1"></i>
                            <div>
                                <div class="fw-semibold">Informasi Akun</div>
                                <small class="text-muted">
                                    Akun baru akan dibuat dengan status Aktif.
                                    Pastikan role yang dipilih sesuai dengan tanggung jawab pengguna.
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/users.js')
@endpush
