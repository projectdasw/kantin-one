@extends('layouts.app')

@section('title', 'Login')

@section('content')
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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="username"
                        required
                        autofocus
                    >

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            class="form-check-input"
                            value="1"
                        >
                        <label for="remember" class="form-check-label">
                            Ingat saya
                        </label>
                    </div>

                    <a href="{{ route('password.request') }}" class="text-decoration-none small">
                        Lupa password?
                    </a>
                </div>

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