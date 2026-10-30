@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-vh-100 bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                Kantin.ONE
            </a>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-white">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="mb-4">
            <h3 class="fw-bold">Dashboard</h3>
            <p class="text-muted mb-0">
                Selamat datang di sistem manajemen Kantin.ONE.
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h5 class="fw-semibold">Selamat datang, {{ auth()->user()->name }}!</h5>
                <p class="text-muted mb-0">
                    Anda berhasil masuk ke sistem Kantin.ONE.
                </p>
            </div>
        </div>
    </main>

</div>
@endsection