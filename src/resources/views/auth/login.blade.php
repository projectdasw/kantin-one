@extends('layouts.auth')
@section('title', 'Login')
@section('auth-heading', 'Welcome Back!')
@section('auth-description')
    Masuk menggunakan akun Anda untuk mengakses Kantin.ONE.
@endsection

@section('auth-content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="card border-0 shadow-sm rounded-4" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-1">Kantin.ONE</h2>
                <p class="text-muted mb-0">Silakan masuk ke akun Anda</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="login" class="form-label">Email atau Username</label>
                    <input type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror"
                        value="{{ old('login') }}" placeholder="Masukkan email atau username" autocomplete="off" required
                        autofocus>

                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group has-validation">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password" autocomplete="off" required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Tampilkan password"
                            aria-pressed="false">
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

                {{-- Remember Me --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1">
                        <label for="remember" class="form-check-label">
                            Ingat saya
                        </label>
                    </div>

                    <a href="{{ route('password.request') }}" class="text-decoration-none small">
                        Lupa password?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary w-100 py-2">
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
    </div>
</div>
@endsection

@push('scripts')