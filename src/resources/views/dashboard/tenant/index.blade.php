@extends('layouts.tenantdashboard')
@section('title', 'Dashboard Kantin')
@section('page-title', 'Dashboard Kantin')
@section('page-description', 'Kelola dan pantau pesanan pelanggan')
@section('tenant-dashboard-content')
    @section('buttonlist_dashboard')
        <div class="btn-group" role="group" aria-label="Default button group">
            <a href="{{ route('tenant.sales') }}" class="btn btn-outline-info text-dark">
                <i class="fa-solid fa-chart-column me-1"></i>
                <span>Verifikasi Penjualan</span>
            </a>
            <a href="{{ route('tenant.products') }}" class="btn btn-outline-info text-dark">
                <i class="fa-solid fa-mortar-pestle me-1"></i>
                <span>Ketersediaan Produk</span>
            </a>
            <button type="button" class="btn btn-outline-success" id="refreshOrders">
                <i class="fa-solid fa-rotate me-1"></i>
                <span>Refresh</span>
            </button>
        </div>
    @endsection
    
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
        <div class="col">
            <div class="card" style="border-color: #eeeeee;">
                <div class="card-header bg-warning-subtle border-0"></div>
                <div class="card-body d-flex flex-row align-items-start">
                    <span class="bg-warning-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                        <i class="fa-solid fa-clock text-secondary fs-5"></i>
                    </span>
                    <div>
                        <span class="card-title text-muted m-0">Menunggu Konfirmasi</span>
                        <h1 class="m-0" id="countWaiting">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="border-color: #eeeeee;">
                <div class="card-header bg-danger-subtle border-0"></div>
                <div class="card-body d-flex flex-row align-items-start">
                    <span class="bg-danger-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                        <i class="fa-solid fa-fire-burner text-secondary fs-5"></i>
                    </span>
                    <div>
                        <span class="card-title text-muted m-0">Sedang diproses</span>
                        <h1 class="m-0" id="countProcessing">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="border-color: #eeeeee;">
                <div class="card-header bg-info-subtle border-0"></div>
                <div class="card-body d-flex flex-row align-items-start">
                    <span class="bg-info-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                        <i class="fa-solid fa-bell text-secondary fs-5"></i>
                    </span>
                    <div>
                        <span class="card-title text-muted m-0">Siap diambil</span>
                        <h1 class="m-0" id="countReady">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="border-color: #eeeeee;">
                <div class="card-header bg-success-subtle border-0"></div>
                <div class="card-body d-flex flex-row align-items-start">
                    <span class="bg-success-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                        <i class="fa-solid fa-check text-secondary fs-5"></i>
                    </span>
                    <div>
                        <span class="card-title text-muted m-0">Pesanan Selesai</span>
                        <h1 class="m-0" id="countCompleted">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-3 border border-1 rounded-4">
        <div class="row justify-content-around align-items-center p-3 mb-2">
            <div class="col d-flex align-items-start">
                <span class="text-bg-primary bg-gradient p-2 fs-4 rounded-3">
                    <i class="fa-solid fa-bowl-rice"></i>
                </span>
                <div class="ms-3">
                    <h5 class="m-0" style="font-weight: 800;">Daftar Pesanan</h5>
                    <span class="text-muted small" style="font-size: 12px;">
                        Kelola daftar pesanan - [Nama Tenant].
                    </span>
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="search" class="form-control" placeholder="Cari kode pesanan" aria-label="Cari kode pesanan" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <ul class="nav nav-pills" id="orderFilters">
            <li class="nav-item me-2">
                <button class="btn btn-sm btn-outline-secondary active" data-filter="all">
                    Semua Pesanan
                </button>
            </li>
            <li class="nav-item me-2">
                <button class="btn btn-sm btn-outline-warning text-dark" data-filter="waiting_confirmation">
                    Menunggu Konfirmasi
                </button>
            </li>
            <li class="nav-item me-2">
                <button class="btn btn-sm btn-outline-danger" data-filter="preparing">
                    Sedang Diproses
                </button>
            </li>
            <li class="nav-item me-2">
                <button class="btn btn-sm btn-outline-info text-dark" data-filter="ready">
                    Siap Diambil
                </button>
            </li>
            <li class="nav-item me-2">
                <button class="btn btn-sm btn-outline-success" data-filter="completed">
                    Selesai
                </button>
            </li>
        </ul>
        <hr>
        <div class="container d-flex flex-column justify-content-center align-items-center bg-secondary-subtle rounded-2 py-4">
            <div class="display-4 text-secondary mb-2">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h4 class="m-0">Belum ada pesanan masuk</h4>
        </div>
    </div>
    @vite('resources/js/pages/tenant-orders.js')
@endsection