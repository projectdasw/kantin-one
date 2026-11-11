@extends('layouts.customerorders')
@section('title', 'Keranjang Belanja')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-basket-shopping" style="color: var(--primary);"></i>
                </h3>
                <div class="d-flex flex-column align-items-start">
                    <h3 class="my-2" style="font-weight: 800; color: var(--text-main);">
                        Keranjang <span style="color: var(--primary);">Belanja</span>
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
<div class="customer-order-page">
    <div class="order-container">

        {{-- HEADER --}}
        <header class="order-header">
            <a href="{{ route('customer.tenants') }}" class="order-brand">
                <span class="brand-icon">
                    <i class="fa-solid fa-utensils"></i>
                </span>
                <span>Kantin<span class="text-primary">.ONE</span></span>
            </a>

            <span class="cart-header-label">
                <i class="fa-solid fa-basket-shopping me-2"></i>
                Keranjang Belanja
            </span>
        </header>

        {{-- HEADING --}}
        <section class="cart-heading">
            <a href="{{ route('customer.tenants') }}" class="back-link">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Kembali Belanja
            </a>

            <h1>Keranjang <span>Belanja</span></h1>
            <p>Periksa kembali pesananmu sebelum melanjutkan.</p>
        </section>

        <div class="cart-layout">

            {{-- CART ITEMS --}}
            <section class="cart-main">

                <div class="cart-section-heading">
                    <div>
                        <h4>Produk Pilihan</h4>
                        <p id="cartItemCount">0 produk</p>
                    </div>
                </div>

                <div id="cartTenantGroups"></div>

                {{-- EMPTY CART --}}
                <div class="cart-empty d-none" id="cartEmpty">
                    <div class="cart-empty-icon">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>

                    <h4>Keranjang Masih Kosong</h4>
                    <p>
                        Kamu belum menambahkan produk apa pun.
                        Yuk, temukan makanan favoritmu!
                    </p>

                    <a href="{{ route('customer.tenants') }}"
                       class="cart-shopping-btn">
                        <i class="fa-solid fa-store me-2"></i>
                        Mulai Belanja
                    </a>
                </div>

            </section>

            {{-- ORDER SUMMARY --}}
            <aside class="cart-summary" id="cartSummary">

                <h4>Ringkasan Pesanan</h4>

                <div class="summary-row">
                    <span>Total Produk</span>
                    <strong id="summaryQuantity">0</strong>
                </div>

                <div class="summary-row">
                    <span>Jumlah Tenant</span>
                    <strong id="summaryTenantCount">0</strong>
                </div>

                <hr>

                <div class="summary-total">
                    <span>Total Pembayaran</span>
                    <strong id="summaryTotal">Rp0</strong>
                </div>

                <button type="button"
                        class="checkout-btn"
                        id="checkoutButton">
                    Lanjut Checkout
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <div class="summary-information">
                    <i class="fa-solid fa-circle-info"></i>
                    Pembayaran dilakukan dalam satu transaksi
                    untuk seluruh tenant pilihanmu.
                </div>

            </aside>

        </div>

    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/pages/cart-order.js')
@endpush