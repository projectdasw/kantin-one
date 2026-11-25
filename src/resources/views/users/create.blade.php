@extends('layouts.dashboard')
@section('title', 'Tambah Akun')
@section('page-title', 'Tambah Akun')
@section('page-description', 'Tambahkan akun baru Kantin.ONE.')
@section('dashboard-content')
    @section('page-actions')
        <a href="{{ route('users.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Kembali</span>
        </a>
    @endsection
    
    <div class="container-fluid p-0">
        <form action="{{ route('users.store') }}" method="POST"
            class="needs-validation" novalidate>
            @csrf

            {{-- Information --}}
            <div class="alert alert-light border" role="alert">
                <h5 class="alert-heading fw-semibold">
                    <i class="fas fa-info-circle text-primary mt-1"></i>
                    <span>Informasi</span>
                </h5>
                <p>
                    Akun baru akan dibuat dengan status Aktif. Pastikan role yang
                    dipilih sesuai dengan tanggung jawab pengguna.
                </p>
                <hr>
                <p class="mb-0">
                    <p class="mb-1">
                        Berikut adalah beberapa hal yang perlu diperhatikan saat membuat akun baru:
                    </p>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item p-0 border-0">
                            Username harus unik dan tidak boleh sama dengan username pengguna lain.
                        </li>
                        <li class="list-group-item p-0 border-0">
                            Password gunakan huruf kecil, angka, underscore, atau tanda hubung.
                            Huruf besar tidak diperbolehkan.
                        </li>
                        <li class="list-group-item p-0 border-0">
                            Role pengguna harus dipilih sesuai dengan tanggung jawabnya.
                        </li>
                    </ol>
                </p>
            </div>

            {{-- Form --}}
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="form-label fw-semibold">
                            Nama Akun <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Masukkan nama Anda" autocomplete="off" required>
                        <div class="invalid-feedback" id="nameFeedback">
                            @error('name')
                                {{ $message }}
                            @else
                                Mohon isi nama akun.
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    {{-- Username --}}
                    <div>
                        <label for="username" class="form-label fw-semibold">
                            Username <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}" placeholder="Contoh: username123" maxlength="50" pattern="[a-z0-9_\-]+"
                            autocomplete="off" required>
                        <div class="invalid-feedback" id="usernameFeedback">
                            @error('username')
                                {{ $message }}
                            @else
                                Mohon isi username.
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    {{-- Email --}}
                    <div>
                        <label for="email" class="form-label fw-semibold">
                            Email (opsional)
                        </label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="off">
                        <div class="invalid-feedback" id="emailFeedback">
                            @error('email')
                                {{ $message }}
                            @else
                                Format email tidak valid.
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    {{-- Password --}}
                    <div>
                        <label for="password" class="form-label fw-semibold">
                            Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter" minlength="8" autocomplete="new-password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password"
                                aria-label="Tampilkan password">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="invalid-feedback" id="passwordFeedback">
                                Mohon isi password.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    {{-- Password Confirmation --}}
                    <div>
                        <label for="password_confirmation" class="form-label fw-semibold">
                            Konfirmasi Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Ulangi password" minlength="8"
                                autocomplete="new-password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                data-target="password_confirmation" aria-label="Tampilkan konfirmasi password">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="invalid-feedback" id="passwordConfirmationFeedback">
                                Mohon isi konfirmasi password.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    {{-- Role --}}
                    <div>
                        <label for="role" class="form-label fw-semibold">
                            Peran <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">Pilih Peran</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}"
                                    @selected(old('role') === $role)>
                                    {{ match ($role) {
                                        'super_admin' => 'Super Admin',
                                        'administrator' => 'Administrator',
                                        'canteen_manager' => 'Kepala Pengelolaan Tenant',
                                        'tenant' => 'Kepala Tenant',
                                        'tenant_employee' => 'Pegawai Tenant',
                                        default => $role,
                                    } }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="roleFeedback">
                            @error('role')
                                {{ $message }}
                            @else
                                Mohon pilih peran sesuai tanggung jawab.
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    {{-- Penempatan Tenant --}}
                    <div class="d-none" id="tenantField">
                        <label for="tenant_id" class="form-label fw-semibold">
                            Tenant <span class="text-danger">*</span>
                        </label>
                        <select name="tenant_id" id="tenant_id" class="form-select @error('tenant_id') is-invalid @enderror">
                            <option value="">Pilih Tenant</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->id }}"
                                    @selected(old('tenant_id') == $tenant->id)>
                                    {{ $tenant->code }} - {{ $tenant->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="tenantFeedback">
                            @error('tenant_id')
                                {{ $message }}
                            @else
                                Silakan pilih tenant.
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end align-items-center gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-danger">
                    <i class="fa-regular fa-circle-xmark"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Buat Akun</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/users/crud.js')
@endpush
