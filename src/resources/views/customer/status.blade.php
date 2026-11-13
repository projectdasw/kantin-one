@extends('layouts.customerorders')
@section('title', 'Lacak Pesanan')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-circle text-success"></i>
                </h3>
                <div class="d-flex flex-column align-items-start">
                    <h3 class="my-2" style="font-weight: 800; color: var(--text-main);">
                        Lacak <span style="color: var(--primary);">Pesanan</span>
                    </h3>
                    <span class="small" style="color: var(--text-muted);">
                        Pantau perkembangan pesanan kamu dari setiap kantin.
                    </span>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mb-3 p-2">
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center align-items-center border border-1
                    p-3 gap-2 bg-success-subtle rounded-4">
                    <h6 class="text-muted m-0">Antrian Pesanan</h6>
                    <h5 class="m-0 mt-2 text-success fw-bold" style="word-spacing: 2px;">[Nomor Antrian Pesanan]</h5>
                    <h5 class="m-0 mb-2 text-success fw-bold">[Nama Pemesan]</h5>
                    <span class="text-muted small">
                        Tunjukan nomor Antrian Pesanan Anda kepada pegawai kantin saat mengambil pesanan
                    </span>
                </div>
                <hr class="mt-4 mb-3">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-receipt fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">No. Pesanan</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">[Nomor Pesanan Utama]</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-wallet fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">Metode Pembayaran</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">QRIS</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-utensils fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">Jenis Layanan</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">
                                    [Dine In / Take Away / Pesanan Terjadwal]
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-receipt fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">Jumlah Kantin yang dipesan</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">[Jumlah] Kantin</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-4 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Total Pesanan</span>
                    <h5 class="fw-bold text-success m-0">Rp999.999</h5>
                </div>
            </div>
        </div>
        <div class="container p-0">
            <div class="row row-cols-1 row-cols-md-2 g-3">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-row align-items-center">
                                    <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                        <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                    </span>
                                    <h6 class="fw-bold m-0">Kantin 1</h6>
                                </div>
                                <span class="text-muted text-end small">
                                    No. Pesanan
                                    <br>
                                    <strong class="fs-6 text-success">[Kode Pesanan]</strong>
                                </span>
                            </div>
                            <div class="container p-0 text-center">
                                [Progress Pesanan]
                            </div>
                            <hr class="my-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 pt-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">
                                            Produk 1 x 1 <span class="badge text-bg-warning ms-1">Sedang proses</span>
                                        </span> 
                                        <span class="fw-bold small">Rp999.999</span>
                                    </div>
                                </li>
                                <li class="list-group-item px-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">
                                            Produk 2 x 1 <span class="badge text-bg-success ms-1">Selesai</span>
                                        </span> 
                                        <span class="fw-bold small">Rp999.999</span>
                                    </div>
                                </li>
                            </ul>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold small">Subtotal Kantin</span> 
                                <span class="fw-bold small">Rp999.999</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-row align-items-center">
                                    <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                        <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                    </span>
                                    <h6 class="fw-bold m-0">Kantin 2</h6>
                                </div>
                                <span class="text-muted text-end small">
                                    No. Pesanan
                                    <br>
                                    <strong class="fs-6 text-success">[Kode Pesanan]</strong>
                                </span>
                            </div>
                            <div class="container p-0 text-center">
                                [Progress Pesanan]
                            </div>
                            <hr class="my-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 pt-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">
                                            Produk 1 x 1 <span class="badge text-bg-warning ms-1">Sedang proses</span>
                                        </span> 
                                        <span class="fw-bold small">Rp999.999</span>
                                    </div>
                                </li>
                                <li class="list-group-item px-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">
                                            Produk 2 x 1 <span class="badge text-bg-success ms-1">Selesai</span>
                                        </span> 
                                        <span class="fw-bold small">Rp999.999</span>
                                    </div>
                                </li>
                            </ul>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold small">Subtotal Kantin</span> 
                                <span class="fw-bold small">Rp999.999</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection