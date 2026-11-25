@extends('layouts.dashboard')
@section('title', 'Reset Password Pengguna')
@section('page-title', 'Reset Password Pengguna')
@section('page-description', 'Atur ulang password akun pengguna')

@section('dashboard-content')
    @section('page-actions')
        <a href="{{ route('users.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Kembali</span>
        </a>
    @endsection

    <div class="container p-0">
        <form action="{{ route('users.reset-password-user.update') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PATCH')

            <input type="hidden" name="user_id" id="reset_user_id">
            <div class="alert border-0 p-0" role="alert">
                <h5 class="alert-heading fw-semibold">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Informasi
                </h5>
                <p>Silakan pilih akun pengguna kemudian masukkan password baru untuk akun tersebut.</p>
                <hr>
                <div class="mb-4">
                    <label for="user_id" class="form-label">
                        Nama / Username Pengguna <span class="text-danger">*</span>
                    </label>
                    <select id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="" selected disabled>Pilih pengguna</option>
                        @foreach ($users as $item)
                            <option value="{{ $item->id }}"
                                @selected(old('user_id') == $item->id)>
                                {{ $item->name }} ({{ $item->username }})
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="userFeedback">
                        @error('user_id')
                            {{ $message }}
                        @else
                            Silakan pilih akun pengguna terlebih dahulu.
                        @enderror
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <label for="password" class="form-label">
                            Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                minlength="8" autocomplete="new-password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
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
                    <div class="col">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
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
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/users/crud.js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSelect = document.getElementById('user_id');
            const resetUserId = document.getElementById('reset_user_id');

            if (!userSelect || !resetUserId) return;

            // Sinkronisasi saat halaman pertama kali dibuka
            resetUserId.value = userSelect.value;

            // Sinkronisasi ketika akun diganti
            userSelect.addEventListener('change', function () {
                resetUserId.value = this.value;
            });
        });
    </script>
@endpush