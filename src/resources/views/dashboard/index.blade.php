@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan aktivitas dan informasi Kantin.ONE.')
@section('dashboard-content')
    <div class="row g-4">

        {{-- Total Tenant --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Total Tenant</small>
                        <h3 class="fw-bold mt-2 mb-0">24</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                        <i class="fa-solid fa-store fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Produk --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Total Produk</small>
                        <h3 class="fw-bold mt-2 mb-0">156</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-box fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Transaksi --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Total Transaksi</small>
                        <h3 class="fw-bold mt-2 mb-0">320</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-receipt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pengguna --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Total Pengguna</small>
                        <h3 class="fw-bold mt-2 mb-0">45</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info">
                        <i class="fa-solid fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Konten tambahan --}}
    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">Aktivitas Kantin</h6>
                <p class="text-muted small mb-0">
                    Area visualisasi aktivitas akan ditempatkan di sini.
                </p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">Informasi Sistem</h6>
                <p class="text-muted small">
                    Selamat datang di Kantin.ONE.
                </p>
            </div>
        </div>
    </div>
@endsection
