@extends('layouts.tenantdashboard')
@section('title', 'Ketersediaan Produk')
@section('page-title', 'Ketersediaan Produk')
@section('page-description', 'Kelola status ketersediaan produk di kantin Anda')
@section('tenant-dashboard-content')
    @section('buttonlist_products')
        <a href="{{ route('dashboard.tenant') }}" class="btn btn-sm btn-secondary bg-gradient">
            <i class="fa-solid fa-arrow-left-long me-1"></i>
            <span>Kembali ke Pesanan</span>
        </a>
    @endsection

    <div class="container p-0 mb-3">
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <div class="col">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary-subtle border-0"></div>
                    <div class="card-body d-flex flex-row align-items-start">
                        <span class="bg-primary-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                            <i class="fa-solid fa-boxes-stacked text-secondary fs-5"></i>
                        </span>
                        <div>
                            <span class="small m-0">Total Produk</span>
                            <h3 class="m-0">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow">
                    <div class="card-header bg-success-subtle border-0"></div>
                    <div class="card-body d-flex flex-row align-items-start">
                        <span class="bg-success-subtle px-2 py-1 fs-4 rounded-3 me-3 border-0">
                            <i class="fa-solid fa-circle-check text-secondary fs-5"></i>
                        </span>
                        <div>
                            <span class="small m-0">Produk Tersedia</span>
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
                            <i class="fa-solid fa-circle-xmark text-secondary fs-5"></i>
                        </span>
                        <div>
                            <span class="small m-0">Produk Tidak Tersedia</span>
                            <h3 class="m-0">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-3 bg-white border-0 rounded-4 shadow">
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
            <div class="col-5 d-flex justify-content-end">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="search" class="form-control" placeholder="Cari produk" aria-label="Cari produk" aria-describedby="basic-addon1">
                    <select class="form-select" id="inputGroupSelect01">
                        <option selected>Semua Status</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-secondary active">Semua Kategori</button>
            </li>
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-warning text-dark">Makanan</button>
            </li>
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-danger">Minuman</button>
            </li>
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-info text-dark">Snack</button>
            </li>
        </ul>
        <hr>
        <table class="table table-sm table-hover">
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
            <div class="display-6 text-secondary mb-2">
                <i class="fa-solid fa-cubes-stacked"></i>
            </div>
            <h6 class="m-0">Belum ada produk untuk kantin ini</h6>
        </div>
    </div>
@endsection