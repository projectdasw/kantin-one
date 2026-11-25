@extends('layouts.dashboard')
@section('title', 'Reset Password')
@section('page-title', 'Reset Password')
@section('page-description', 'Atur ulang password akun')
@section('dashboard-content')
    @section('page-actions')
        <a href="{{ route('users.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Kembali</span>
        </a>
    @endsection

    <form action="{{ route('users.resetpassword.update') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PATCH')

        {{-- Information --}}
        <div class="alert border-0 p-0" role="alert">
            <h5 class="alert-heading fw-semibold">
                <i class="fas fa-info-circle text-primary mt-1"></i>
                <span>Informasi</span>
            </h5>
            <p>
                Password Akun <strong>{{ $user->name }}</strong> akan di reset.
                Pastikan password baru yang diatur sesuai dengan kebijakan keamanan.
            </p>
            <hr>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div>
                        <label for="password" class="form-label">
                            Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                minlength="8" autocomplete="new-password" required>

                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="password">
                                <i class="fas fa-eye"></i>
                            </button>

                            <div class="invalid-feedback" id="passwordFeedback">
                                @error('password')
                                    {{ $message }}
                                @else
                                    Mohon isi password baru minimal 8 karakter.
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Password Baru
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <input type="password" name="password_confirmation"
                                id="password_confirmation" class="form-control"
                                minlength="8" autocomplete="new-password" required>

                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>

                            <div class="invalid-feedback" id="passwordConfirmationFeedback">
                                Mohon isi konfirmasi password.
                            </div>
                        </div>
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
            <button type="submit" class="btn btn-success">
                <i class="fas fa-key"></i>
                <span>Reset Password</span>
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    @vite('resources/js/pages/users/crud.js')
@endpush