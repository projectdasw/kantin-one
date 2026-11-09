@extends('layouts.tenantdashboard')
@section('title', 'Transasksi Penjualan')
@section('page-title', 'Transaksi Penjualan')
@section('page-description', 'Kelola transaksi total penjualan kantin.')
@section('tenant-dashboard-content')
    @section('buttonlist_sales')
        <a href="{{ route('dashboard.tenant') }}" class="btn btn-sm btn-secondary bg-gradient">
            <i class="fa-solid fa-arrow-left-long me-1"></i>
            <span>Kembali ke Pesanan</span>
        </a>
    @endsection

    <div class="container p-0 mb-3">
        <div class="card border-0 shadow w-75 mx-auto">
            <div class="card-header bg-success bg-gradient border-0"></div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center gap-2">
                <h3 class="text-success m-0">Saldo Penjualan</h3>
                <h1 class="fw-bold text-secondary">Rp. 0</h1>
                <h6 class="m-0">Periode Penjualan: [Tanggal hari ini]</h6>
            </div>
        </div>
    </div>
    <div class="container p-0 mb-3">
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <div class="col">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary-subtle border-0"></div>
                    <div class="card-body d-flex flex-row align-items-start">
                        <span class="bg-primary-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                            <i class="fa-solid fa-receipt text-secondary fs-5"></i>
                        </span>
                        <div>
                            <span class="small m-0">Transaksi Selesai</span>
                            <h3 class="m-0">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow">
                    <div class="card-header bg-warning-subtle border-0"></div>
                    <div class="card-body d-flex flex-row align-items-start">
                        <span class="bg-warning-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                            <i class="fa-solid fa-clock text-secondary fs-5"></i>
                        </span>
                        <div>
                            <span class="small m-0">Pesanan Belum Selesai</span>
                            <h3 class="m-0">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow">
                    <div class="card-header bg-danger-subtle border-0"></div>
                    <div class="card-body d-flex flex-row align-items-start">
                        <span class="bg-danger-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                            <i class="fa-solid fa-chart-line text-secondary fs-5"></i>
                        </span>
                        <div>
                            <span class="small m-0">Rata-rata Transaksi</span>
                            <h3 class="m-0">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-3 bg-white border-0 shadow rounded-4 mb-3">
        <div class="row justify-content-around align-items-center p-3 mb-2">
            <div class="col d-flex align-items-center">
                <span class="text-bg-success bg-gradient p-2 fs-4 rounded-3">
                    <i class="fa-solid fa-chart-area"></i>
                </span>
                <div class="ms-3">
                    <h5 class="m-0" style="font-weight: 800;">Daftar Transaksi</h5>
                    <span class="text-muted small" style="font-size: 12px;">
                        Periksa seluruh transaksi penjualan kantin Anda
                    </span>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-end">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="search" class="form-control" placeholder="Cari kode pesanan atau nama pelanggan"
                        aria-label="Cari kode pesanan atau nama pelanggan" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-secondary active">Semua Transaksi</button>
            </li>
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-success">Selesai</button>
            </li>
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-success">Belum Selesai</button>
            </li>
        </ul>
        <hr>
        <table class="table table-sm table-hover">
            <thead>
                <tr class="small">
                    <th scope="col">No. Pesanan</th>
                    <th scope="col">Waktu</th>
                    <th scope="col">Jumlah Pesanan</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <div class="container d-flex flex-column justify-content-center align-items-center
            bg-secondary-subtle rounded-2 py-3">
            <h6 class="m-0">Tidak ada transaksi yang ditemukan</h6>
        </div>
    </div>
    <div class="container p-3 bg-white border-0 shadow rounded-4">
        <div class="row justify-content-around align-items-center px-3 pt-3 pb-0">
            <div class="col d-flex align-items-center">
                <span class="text-bg-danger bg-gradient p-2 fs-4 rounded-3">
                    <i class="fa-solid fa-house-circle-exclamation"></i>
                </span>
                <div class="ms-3">
                    <h5 class="m-0" style="font-weight: 800;">Verifikasi Penjualan</h5>
                    <span class="text-muted small" style="font-size: 12px;">
                        Pastikan seluruh transaksi dan total penjualan telah diperiksa sebelum melakukan closing
                    </span>
                </div>
            </div>
        </div>
        <hr>
        <div class="container p-0 mb-3">
            <div class="row row-cols-1 row-cols-md-2 g-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-success-subtle border-0"></div>
                        <div class="card-body d-flex flex-row align-items-start">
                            <span class="bg-success-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </span>
                            <div>
                                <span class="small m-0">Total Transaksi Selesai</span>
                                <h3 class="fw-bold text-success m-0">0 Transaksi</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-success-subtle border-0"></div>
                        <div class="card-body d-flex flex-row align-items-start">
                            <span class="bg-success-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                                <i class="fa-solid fa-receipt text-secondary fs-5"></i>
                            </span>
                            <div>
                                <span class="small m-0">Total Penjualan Terverifikasi</span>
                                <h3 class="fw-bold text-success m-0">Rp. 0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-warning text-center" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>Silakan periksa kembali total penjualan sebelum melakukan closing.</span>
        </div>
        <div class="form-check form-switch d-flex justify-content-center mb-3">
            <input class="form-check-input me-2" type="checkbox" role="switch" id="switchCheckDefault">
            <label class="form-check-label" for="switchCheckDefault">
                Saya telah memeriksa dan memastikan bahwa total penjualan kantin sudah sesuai
            </label>
        </div>
        <button type="button" class="btn btn-success bg-gradient w-100">
            <i class="fa-solid fa-shop-lock me-1"></i>
            <span>Verifikasi & Tutup Penjualan</span>
        </button>
    </div>
@endsection