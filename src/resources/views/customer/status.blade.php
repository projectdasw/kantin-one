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
        <div class="container p-0">
            <div class="row flex-wrap g-3">
                <div class="col">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header border-0 bg-success-subtle">
                            <span class="fw-bold text-success m-0" style="font-size: 12px;">
                                Kantin ini masih buka pemesanan
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row align-items-center mb-2">
                                <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                    <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                </span>
                                <h6 class="fw-bold m-0">Kantin 1</h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                        <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                            alt="image/png" style="width: 100px; height: 70px;">
                                        <div class="d-flex flex-column gap-1">
                                            <h6 class="fw-bold m-0">
                                                Produk 1
                                                <span class="badge rounded-pill text-bg-success ms-1">Tersedia</span>
                                            </h6>
                                            <span class="fw-bold small" style="word-spacing: 4px;">Rp999.999</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-center align-items-center gap-3 my-2">
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span class="fw-bold">0</span>
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                        <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                            alt="image/png" style="width: 100px; height: 70px;">
                                        <div class="d-flex flex-column gap-1">
                                            <h6 class="fw-bold m-0">
                                                Produk 2
                                                <span class="badge rounded-pill text-bg-danger ms-1">Tidak Tersedia</span>
                                            </h6>
                                            <span class="fw-bold small" style="word-spacing: 4px;">Rp999.999</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-center align-items-center gap-3 my-2">
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span class="fw-bold">0</span>
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>                           
                        </div>
                        <div class="card-footer border-0 bg-danger-subtle">
                            <span class="fw-bold text-danger" style="font-size: 12px;">
                                Segera lakukan pemesanan pada kantin ini sebelum dari pihak kantin
                                menutup secara tiba-tiba
                            </span>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-header border-0 bg-success-subtle">
                            <span class="fw-bold text-success m-0" style="font-size: 12px;">
                                Kantin ini masih buka pemesanan
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row align-items-center mb-2">
                                <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                    <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                </span>
                                <h6 class="fw-bold m-0">Kantin 1</h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                        <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                            alt="image/png" style="width: 100px; height: 70px;">
                                        <div class="d-flex flex-column gap-1">
                                            <h6 class="fw-bold m-0">
                                                Produk 1
                                                <span class="badge rounded-pill text-bg-success ms-1">Tersedia</span>
                                            </h6>
                                            <span class="fw-bold small" style="word-spacing: 4px;">Rp999.999</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-center align-items-center gap-3 my-2">
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span class="fw-bold">0</span>
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                        <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                            alt="image/png" style="width: 100px; height: 70px;">
                                        <div class="d-flex flex-column gap-1">
                                            <h6 class="fw-bold m-0">
                                                Produk 2
                                                <span class="badge rounded-pill text-bg-danger ms-1">Tidak Tersedia</span>
                                            </h6>
                                            <span class="fw-bold small" style="word-spacing: 4px;">Rp999.999</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-center align-items-center gap-3 my-2">
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span class="fw-bold">0</span>
                                            <button type="button" class="btn btn-sm btn-secondary bg-gradient">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>                           
                        </div>
                        <div class="card-footer border-0 bg-danger-subtle">
                            <span class="fw-bold text-danger" style="font-size: 12px;">
                                Segera lakukan pemesanan pada kantin ini sebelum dari pihak kantin
                                menutup secara tiba-tiba
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm px-2 sticky-top z-0" style="top: 100px;">
                        <div class="card-body">
                            <h6 class="fw-bold m-0">Ringkasan Pesanan</h6>
                            <hr class="mb-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold small m-0">Kantin 1</h6>
                                        <h6 class="fw-bold small m-0">Subtotal</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="text-muted small m-0">Produk 1</h6>
                                        <h6 class="text-muted small m-0">Rp. 999.999</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-muted small m-0">Produk 2</h6>
                                        <h6 class="text-muted small m-0">Rp. 999.999</h6>
                                    </div>
                                </li>
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold small m-0">Kantin 2</h6>
                                        <h6 class="fw-bold small m-0">Subtotal</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="text-muted small m-0">Produk 1</h6>
                                        <h6 class="text-muted small m-0">Rp. 999.999</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-muted small m-0">Produk 2</h6>
                                        <h6 class="text-muted small m-0">Rp. 999.999</h6>
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
                            <button type="button" class="btn btn-primary w-100">
                                <span class="float-start">Pesan</span>
                                <span class="float-end">
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="order-status-page">

    <header class="order-status-header">
        <a href="{{ route('customer.index') }}" class="status-brand">
            <span class="brand-icon">
                <i class="fa-solid fa-utensils"></i>
            </span>
            <span>Kantin<span class="brand-highlight">.ONE</span></span>
        </a>

        <span class="header-label">
            <i class="fa-solid fa-location-dot"></i>
            Lacak Pesanan
        </span>
    </header>

    <main class="order-status-container">

        <div class="status-page-heading">
            <div>
                <h1>Status Pesanan</h1>
                <p>Pantau perkembangan pesanan kamu dari setiap tenant.</p>
            </div>

            <button type="button" class="btn-refresh-status" id="refreshStatus">
                <i class="fa-solid fa-rotate"></i>
                Refresh
            </button>
        </div>

        <section class="main-order-card">
            <div class="main-order-top">
                <div>
                    <span class="main-order-label">Nomor Pesanan Utama</span>
                    <strong id="parentOrderNumber">-</strong>
                </div>

                <span class="main-order-badge" id="mainOrderStatus">
                    Menunggu Pembayaran
                </span>
            </div>

            <div class="main-order-information">
                <div>
                    <i class="fa-solid fa-wallet"></i>
                    <span>Metode Pembayaran</span>
                    <strong id="paymentMethod">-</strong>
                </div>

                <div>
                    <i class="fa-solid fa-utensils"></i>
                    <span>Jenis Layanan</span>
                    <strong id="serviceType">-</strong>
                </div>

                <div id="pickupScheduleContainer" hidden>
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Jadwal Pengambilan</span>
                    <strong id="pickupSchedule">-</strong>
                </div>

                <div>
                    <i class="fa-solid fa-store"></i>
                    <span>Jumlah Tenant</span>
                    <strong id="tenantCount">0 Tenant</strong>
                </div>
            </div>

            <div class="main-order-total">
                <span>Total Pesanan</span>
                <strong id="grandTotal">Rp0</strong>
            </div>
        </section>

        <section class="tenant-tracking-section">
            <div class="tracking-section-heading">
                <div>
                    <h2>Perkembangan Pesanan</h2>
                    <p>Setiap tenant memiliki proses pesanan masing-masing.</p>
                </div>
                <i class="fa-solid fa-list-check"></i>
            </div>

            <div id="tenantTrackingList" class="tenant-tracking-list"></div>
        </section>

        <div class="status-page-actions">
            <a href="{{ route('customer.index') }}" class="btn-status-home">
                <i class="fa-solid fa-house"></i>
                Kembali ke Beranda
            </a>
        </div>

    </main>
</div>

@vite('resources/js/pages/status-order.js')
@endsection