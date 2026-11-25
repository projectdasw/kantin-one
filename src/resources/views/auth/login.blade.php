@extends('layouts.auth')
@section('title', 'Login')
@section('auth-content')
    <div class="container p-0">
        <div class="card border-0 shadow-lg w-75 mx-auto">
            <div class="card-header border-0" style="background-color: var(--auth-primary);"></div>
            <div class="card-body p-5">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-3"> {{-- Email --}}
                        <label for="login" class="form-label">Email atau Username</label>
                        <input type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}"
                            placeholder="Masukkan email atau username" autocomplete="off" requiredautofocus>
                        @error('login')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3"> {{-- Password --}}
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group has-validation">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password" autocomplete="off" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false">
                                <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                            </button>
                            <div class="invalid-feedback">
                                @error('password')
                                    {{ $message }}
                                @else
                                    Password wajib diisi.
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4"> {{-- Remember Me --}}
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1">
                            <label for="remember" class="form-check-label">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-decoration-none small">Lupa password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2"> {{-- Submit --}}
                        <i class="fa-solid fa-right-to-bracket me-2"></i>
                        Login
                    </button>
                </form>
                <div class="text-center mt-4">
                    <small class="text-muted">
                        &copy; {{ date('Y') }} Kantin.ONE
                    </small>
                </div>
            </div>
            <div class="card-footer border-0" style="background-color: var(--auth-secondary);"></div>
        </div>
    </div>
@endsection

@vite('resources/js/pages/auth/login.js')