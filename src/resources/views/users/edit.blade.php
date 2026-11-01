
@extends('layouts.dashboard')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')
@section('page-description', 'Perbarui informasi dan hak akses pengguna.')

@section('dashboard-content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Form Edit Pengguna</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('users.update') }}"
                      method="POST"
                      class="needs-validation"
                      novalidate>

                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Nama --}}
                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   maxlength="255"
                                   required>

                            <div class="invalid-feedback">
                                Nama lengkap wajib diisi.
                            </div>

                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="col-md-6">
                            <label for="username" class="form-label">
                                Username <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="username"
                                   id="username"
                                   class="form-control @error('username') is-invalid @enderror"
                                   value="{{ old('username', $user->username) }}"
                                   pattern="[a-z0-9_-]+"
                                   maxlength="50"
                                   required>

                            <div class="invalid-feedback">
                                Username wajib diisi dan hanya boleh menggunakan huruf kecil, angka, underscore, atau tanda hubung.
                            </div>

                            @error('username')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Email <span class="text-muted">(Opsional)</span>
                            </label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   maxlength="255">

                            <div class="invalid-feedback">
                                Masukkan alamat email dengan format yang valid.
                            </div>

                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="col-md-6">
                            <label for="role" class="form-label">
                                Role Pengguna <span class="text-danger">*</span>
                            </label>

                            <select name="role"
                                    id="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required>

                                <option value="">Pilih Role</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role }}"
                                        {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $role)) }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                                Silakan pilih role pengguna.
                            </div>

                            @error('role')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label">
                                Password Baru <span class="text-muted">(Opsional)</span>
                            </label>

                            <div class="input-group">
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       minlength="8"
                                       autocomplete="new-password">

                                <button type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="password"
                                        aria-label="Tampilkan password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <div class="form-text">
                                Kosongkan jika tidak ingin mengubah password.
                                Minimal 8 karakter jika diisi.
                            </div>

                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password Baru
                            </label>

                            <div class="input-group">
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control"
                                       minlength="8"
                                       autocomplete="new-password">

                                <button type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="password_confirmation"
                                        aria-label="Tampilkan password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <div class="form-text">
                                Isi jika Anda memasukkan password baru.
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.show') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/pages/users.js')
@endpush
