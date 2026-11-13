@extends('layouts.customerorders')
@section('title', 'Checkout Pesanan')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-cash-register" style="color: var(--primary);"></i>
                </h3>
                <div class="d-flex flex-column align-items-start">
                    <h3 class="my-2" style="font-weight: 800; color: var(--text-main);">
                        Checkout <span style="color: var(--primary);">Pesanan</span>
                    </h3>
                    <span class="small" style="color: var(--text-muted);">
                        Periksa kembali pesananmu sebelum melanjutkan
                    </span>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-primary bg-gradient">
                <i class="fa-solid fa-arrow-left-long me-1"></i>
                <span>Kembali ke Daftar Kantin</span>
            </button>
        </div>
        <div class="container p-0">
            <div class="row g-3">
                <div class="col-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h6 class="bg-light px-2 py-1 rounded-3 m-0 me-2 border-0">
                                        <i class="fa-solid fa-basket-shopping" style="color: var(--primary);"></i>
                                    </h6>
                                    <h6 class="m-0" style="font-weight: 800; color: var(--text-main);">
                                        Detail <span style="color: var(--primary);">Pesanan</span>
                                    </h6>
                                </div>
                            </div>
                            <hr>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex flex-row align-items-center mb-2">
                                        <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                            <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                        </span>
                                        <h6 class="fw-bold m-0">Kantin 1</h6>
                                    </div>
                                    <hr>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 py-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                                        alt="image/png" style="width: 100px; height: 70px;">
                                                    <div class="d-flex flex-column gap-1">
                                                        <h6 class="fw-bold m-0">Produk 1</h6>
                                                        <span class="text-muted small" style="word-spacing: 2px;">1 x Rp999.999</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">Rp999.999</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                                        alt="image/png" style="width: 100px; height: 70px;">
                                                    <div class="d-flex flex-column gap-1">
                                                        <h6 class="fw-bold m-0">Produk 2</h6>
                                                        <span class="text-muted small" style="word-spacing: 2px;">1 x Rp999.999</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">Rp999.999</span>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h6 class="m-0" style="font-weight: 800; color: var(--text-main);">Catatan</h6>
                                                <hr class="mt-2">
                                                <textarea class="form-control" rows="3"></textarea>
                                                <div class="form-text">
                                                    Catatan ini berlaku untuk kantin ini
                                                </div>
                                            </div>
                                        </li>
                                    </ul>                           
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex flex-row align-items-center mb-2">
                                        <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                            <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                        </span>
                                        <h6 class="fw-bold m-0">Kantin 2</h6>
                                    </div>
                                    <hr>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 py-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                                        alt="image/png" style="width: 100px; height: 70px;">
                                                    <div class="d-flex flex-column gap-1">
                                                        <h6 class="fw-bold m-0">Produk 1</h6>
                                                        <span class="text-muted small" style="word-spacing: 2px;">1 x Rp999.999</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">Rp999.999</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-start align-items-center gap-3">
                                                    <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                                        alt="image/png" style="width: 100px; height: 70px;">
                                                    <div class="d-flex flex-column gap-1">
                                                        <h6 class="fw-bold m-0">Produk 2</h6>
                                                        <span class="text-muted small" style="word-spacing: 2px;">1 x Rp999.999</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">Rp999.999</span>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h6 class="m-0" style="font-weight: 800; color: var(--text-main);">Catatan</h6>
                                                <hr class="mt-2">
                                                <textarea class="form-control" rows="3"></textarea>
                                                <div class="form-text">
                                                    Catatan ini berlaku untuk kantin ini
                                                </div>
                                            </div>
                                        </li>
                                    </ul>                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="sticky-top z-0" style="top: 95px;">
                        <div class="card border-0 shadow-sm px-2 mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <h6 class="bg-light px-2 py-1 rounded-3 m-0 me-2 border-0">
                                            <i class="fa-solid fa-circle-info" style="color: var(--primary);"></i>
                                        </h6>
                                        <h6 class="m-0" style="font-weight: 800; color: var(--text-main);">
                                            Informasi <span style="color: var(--primary);">Pesanan</span>
                                        </h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex flex-row align-items-center bg-light p-2 border border-1 rounded-3 mb-2">
                                    <span class="bg-primary-subtle px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                        <i class="fa-solid fa-chair text-primary"></i>
                                    </span>
                                    <div>
                                        <h6 class="fw-bold m-0 small">Dine In</h6>
                                        <span style="color: var(--text-muted); font-size: 12px;">Pesanan dinikmati di area kantin.</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center bg-light p-2 border border-1 rounded-3 mb-3">
                                    <span class="bg-primary-subtle px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                        <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                    </span>
                                    <div>
                                        <h6 class="fw-bold m-0 small">Area Utama · Meja A-012</h6>
                                        <span style="color: var(--text-muted); font-size: 12px;">Lokasi Pemesanan & Meja</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="exampleFormControlInput1" class="form-label small">Nama Pemesan<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-solid fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan nama Anda"
                                            aria-label="Masukkan nama Anda" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 shadow-sm px-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <h6 class="bg-light px-2 py-1 rounded-3 m-0 me-2 border-0">
                                            <i class="fa-solid fa-file-invoice" style="color: var(--primary);"></i>
                                        </h6>
                                        <h6 class="m-0" style="font-weight: 800; color: var(--text-main);">
                                            Ringkasan <span style="color: var(--primary);">Pesanan</span>
                                        </h6>
                                    </div>
                                </div>
                                <hr class="mb-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold small m-0">Subtotal</h6>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold small m-0">Kantin 1</h6>
                                            <h6 class="fw-bold small m-0">Rp. 999.999</h6>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="fw-bold small m-0">Kantin 2</h6>
                                            <h6 class="fw-bold small m-0">Rp. 999.999</h6>
                                        </div>
                                    </li>
                                </ul>
                                <hr>
                                <div class="d-flex flex-column mb-4">
                                    <h6 class="fw-bold">Total Pembayaran</h6>
                                    <h4 class="fw-bold m-0" style="color: var(--primary);">Rp. 999.999</h4>
                                </div>
                                <div class="alert alert-warning m-0" role="alert" style="font-size: 12px;">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>Pembayaran dilakukan dalam satu transaksi untuk seluruh kantin pilihanmu</span>
                                </div>
                                <hr>
                                <a href="{{ route('customer.pay') }}" class="btn btn-success w-100">
                                    <span class="float-start">Bayar Pesanan</span>
                                    <span class="float-end">
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection