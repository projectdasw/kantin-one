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
            <div class="row g-4">
                <div class="col-8">
                    <div class="card border-0 rounded-4 shadow-sm position-relative">
                        <!-- <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge d-flex justify-content-center align-items-center text-success
                                bg-white border border-1">
                                <span class="small">Tersedia</span>
                            </span>
                        </div> -->
                        <div class="card-header border-0 bg-success-subtle">
                            <span class="fw-bold text-success m-0" style="font-size: 12px;">
                                Kantin ini masih buka pemesanan
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row align-items-center">
                                <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                    <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                </span>
                                <h6 class="fw-bold m-0">Kantin 1</h6>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top w-25" alt="image/png">
                            <h6 class="card-title fw-bold mb-2">Produk 1</h6>
                            <p class="card-text text-muted small m-0">
                                Aneka makanan khas nusantara dengan cita rasa rumahan.
                            </p>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold">Rp. 999.999</h6>
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <span class="fw-bold">0</span>
                                    <button type="button" class="btn btn-sm btn-success bg-gradient">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>                                
                        </div>
                        <div class="card-footer border-0 bg-danger-subtle">
                            <span class="fw-bold text-danger" style="font-size: 12px;">
                                Segera lakukan pemesanan pada kantin ini sebelum dari pihak kantin
                                menutup secara tiba-tiba
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
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