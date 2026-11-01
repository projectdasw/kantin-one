
@extends('layouts.dashboard')

@section('title', 'Reset Password')
@section('page-title', 'Reset Password')
@section('page-description', 'Atur ulang password akun pengguna.')

@section('dashboard-content')
<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Reset Password Pengguna</h5>
            </div>

            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-user me-2"></i>
                    <strong>{{ $user->name }}</strong>
                    <span class="text-muted">{{ $user->username }}</span>
                </div>

                <form action="{{ route('users.resetpassword.update') }}"
                      method="POST"
                      class="needs-validation"
                      novalidate>
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password Baru <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   minlength="8"
                                   autocomplete="new-password"
                                   required>

                            <button type="button"
                                    class="btn btn-outline-secondary toggle-password"
                                    data-target="password">
                                <i class="fas fa-eye"></i>
                            </button>

                            <div class="invalid-feedback">
                                Password wajib diisi minimal 8 karakter.
                            </div>
                        </div>

                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Password Baru
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   minlength="8"
                                   autocomplete="new-password"
                                   required>

                            <button type="button"
                                    class="btn btn-outline-secondary toggle-password"
                                    data-target="password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>

                            <div class="invalid-feedback">
                                Konfirmasi password wajib diisi dan harus sama.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.show') }}"
                           class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-1"></i>
                            Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@vite('resources/js/pages/users.js')
@endsection
