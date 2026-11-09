@extends('layouts.tenantdashboard')
@section('title', 'Verifikasi Penjualan')
@section('page-title', 'Verifikasi Penjualan')
@section('page-description', 'Periksa dan verifikasi total penjualan kantin.')
@section('tenant-dashboard-content')
    @section('buttonlist_products')
        <div class="btn-group" role="group" aria-label="Default button group">
            <a href="{{ route('dashboard.tenant') }}" class="btn btn-outline-success">
                <i class="fa-solid fa-arrow-left-long me-1"></i>
                <span>Kembali ke Pesanan</span>
            </a>
        </div>
    @endsection

    <div class="container p-2 bg-white border border-1 mb-4 rounded-4">
        <div class="row justify-content-around align-items-center p-3">
            <div class="col d-flex align-items-center">
                <span class="text-bg-success bg-gradient p-2 fs-4 rounded-3">
                    <i class="fa-solid fa-calendar-day"></i>
                </span>
                <div class="ms-3">
                    <h6 class="text-muted small">Periode Penjualan</h6>
                    <h5 class="fw-bold m-0">
                        [Tanggal hari ini]
                    </h5>
                </div>
            </div>
            <div class="col d-flex justify-content-end">
                <h5 class="m-0"><span class="badge bg-success">Harian</span></h5>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        <div class="col">
            <div class="card" style="border-color: #eeeeee;">
                <div class="card-header bg-primary-subtle border-0"></div>
                <div class="card-body d-flex flex-row align-items-start">
                    <span class="bg-primary-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                        <i class="fa-solid fa-boxes-stacked text-secondary fs-5"></i>
                    </span>
                    <div>
                        <span class="card-title text-muted m-0">Total Produk</span>
                        <h1 class="m-0">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="border-color: #eeeeee;">
                <div class="card-header bg-success-subtle border-0"></div>
                <div class="card-body d-flex flex-row align-items-start">
                    <span class="bg-success-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                        <i class="fa-solid fa-circle-check text-secondary fs-5"></i>
                    </span>
                    <div>
                        <span class="card-title text-muted m-0">Produk Tersedia</span>
                        <h1 class="m-0">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="border-color: #eeeeee;">
                <div class="card-header bg-danger-subtle border-0"></div>
                <div class="card-body d-flex flex-row align-items-start">
                    <span class="bg-danger-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                        <i class="fa-solid fa-circle-xmark text-secondary fs-5"></i>
                    </span>
                    <div>
                        <span class="card-title text-muted m-0">Produk Tidak Tersedia</span>
                        <h1 class="m-0" id="countProcessing">0</h1>
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
                    <h5 class="m-0" style="font-weight: 800;">Daftar Produk</h5>
                    <span class="text-muted small" style="font-size: 12px;">
                        Aktifkan atau nonaktifkan produk sesuai ketersediaannya
                    </span>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="search" class="form-control" placeholder="Cari produk" aria-label="Cari produk" aria-describedby="basic-addon1">
                    <select class="form-select" id="inputGroupSelect01">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <select class="form-select" id="inputGroupSelect01">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Produk</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Status Ketersediaan</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <div class="container d-flex flex-column justify-content-center align-items-center bg-secondary-subtle rounded-2 py-4">
            <div class="display-4 text-secondary mb-2">
                <i class="fa-solid fa-cubes-stacked"></i>
            </div>
            <h4 class="m-0">Belum ada produk untuk kantin ini</h4>
        </div>
    </div>
@endsection