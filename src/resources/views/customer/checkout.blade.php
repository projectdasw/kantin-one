@extends('layouts.customerorders')
@section('title', 'Checkout Pesanan')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-basket-shopping" style="color: var(--primary);"></i>
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
            <div class="row flex-wrap g-3">
                <div class="col-8">
                    <div class="card border-0 shadow-sm mb-3">
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
                                            <h6 class="fw-bold m-0">Produk 1</h6>
                                            <span class="fw-bold small" style="word-spacing: 4px;">1 x Rp999.999</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                        <img src="{{ asset('img-dummy/supermarket.png') }}" class="img-thumbnail object-fit-cover"
                                            alt="image/png" style="width: 100px; height: 70px;">
                                        <div class="d-flex flex-column gap-1">
                                            <h6 class="fw-bold m-0">Produk 2</h6>
                                            <span class="fw-bold small" style="word-spacing: 4px;">1 x Rp999.999</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>                           
                        </div>
                    </div>
                </div>
                <div class="col-4">
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
                <i class="fa-solid fa-lock me-2"></i>
                Checkout Aman
            </span>
        </header>

        {{-- HEADING --}}
        <section class="checkout-heading">
            <a href="{{ route('customer.cart') }}" class="back-link">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Kembali ke Keranjang
            </a>

            <h1>Checkout <span>Pesanan</span></h1>
            <p>Periksa detail pesanan dan pilih metode pembayaran.</p>
        </section>

        <form id="checkoutForm">

            <div class="checkout-layout">

                <div class="checkout-main">

                    {{-- SERVICE INFORMATION --}}
                    <section class="checkout-card">

                        <div class="checkout-card-heading">
                            <div class="checkout-step">01</div>
                            <div>
                                <h4>Informasi Pengambilan</h4>
                                <p>Periksa jenis layanan pesananmu.</p>
                            </div>
                        </div>

                        <div class="checkout-service-info">
                            <div class="checkout-service-icon">
                                <i class="fa-solid fa-chair" id="checkoutServiceIcon"></i>
                            </div>

                            <div>
                                <small>Jenis Layanan</small>
                                <h5 id="checkoutServiceName">Dine In</h5>
                                <p id="checkoutServiceDescription">
                                    Pesanan dinikmati di area kantin.
                                </p>
                            </div>
                        </div>

                        {{-- TABLE INFORMATION --}}
                        <div class="checkout-detail-row" id="tableInformation">
                            <span>
                                <i class="fa-solid fa-location-dot me-2"></i>
                                Lokasi Meja
                            </span>
                            <strong id="checkoutTable">Area Utama · Meja A-012</strong>
                        </div>

                        {{-- PICKUP SCHEDULE --}}
                        <div id="pickupInformation" class="d-none">

                            <div class="checkout-input-group">
                                <label for="checkoutPickupDate">
                                    Tanggal Pengambilan
                                </label>

                                <input type="date"
                                       class="form-control"
                                       id="checkoutPickupDate">
                            </div>

                            <div class="checkout-input-group">
                                <label for="checkoutPickupTime">
                                    Waktu Pengambilan
                                </label>

                                <input type="time"
                                       class="form-control"
                                       id="checkoutPickupTime">
                            </div>

                        </div>

                    </section>

                    {{-- ORDER SUMMARY --}}
                    <section class="checkout-card">

                        <div class="checkout-card-heading">
                            <div class="checkout-step">02</div>
                            <div>
                                <h4>Detail Pesanan</h4>
                                <p>Daftar produk dari tenant pilihanmu.</p>
                            </div>
                        </div>

                        <div id="checkoutOrderItems"></div>

                    </section>

                    {{-- ORDER NOTES --}}
                    <section class="checkout-card">

                        <div class="checkout-card-heading">
                            <div class="checkout-step">03</div>
                            <div>
                                <h4>Catatan Pesanan</h4>
                                <p>Tambahkan instruksi khusus jika diperlukan.</p>
                            </div>
                        </div>

                        <textarea
                            class="form-control checkout-notes"
                            id="orderNotes"
                            rows="3"
                            maxlength="500"
                            placeholder="Contoh: Tidak pedas, saus dipisah, dan sebagainya."
                        ></textarea>

                        <small class="notes-information">
                            Catatan ini berlaku untuk seluruh pesanan.
                        </small>

                    </section>

                    {{-- PAYMENT METHOD --}}
                    <section class="checkout-card">

                        <div class="checkout-card-heading">
                            <div class="checkout-step">04</div>
                            <div>
                                <h4>Metode Pembayaran</h4>
                                <p>Pilih satu metode pembayaran untuk seluruh pesanan.</p>
                            </div>
                        </div>

                        <div class="payment-methods">

                            <label class="payment-option">
                                <input type="radio"
                                       name="payment_method"
                                       value="qris"
                                       required>

                                <span class="payment-icon qris-icon">
                                    <i class="fa-solid fa-qrcode"></i>
                                </span>

                                <span class="payment-info">
                                    <strong>QRIS</strong>
                                    <small>Bayar menggunakan aplikasi pembayaran digital.</small>
                                </span>

                                <i class="fa-solid fa-circle-check payment-check"></i>
                            </label>

                            <label class="payment-option">
                                <input type="radio"
                                       name="payment_method"
                                       value="bank_transfer">

                                <span class="payment-icon transfer-icon">
                                    <i class="fa-solid fa-building-columns"></i>
                                </span>

                                <span class="payment-info">
                                    <strong>Transfer Bank</strong>
                                    <small>Transfer melalui rekening bank.</small>
                                </span>

                                <i class="fa-solid fa-circle-check payment-check"></i>
                            </label>

                            <label class="payment-option">
                                <input type="radio"
                                       name="payment_method"
                                       value="cash">

                                <span class="payment-icon cash-icon">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </span>

                                <span class="payment-info">
                                    <strong>Tunai</strong>
                                    <small>Bayar langsung sesuai prosedur kantin.</small>
                                </span>

                                <i class="fa-solid fa-circle-check payment-check"></i>
                            </label>

                        </div>

                    </section>

                </div>

                {{-- PAYMENT SUMMARY --}}
                <aside class="checkout-summary">

                    <h4>Ringkasan Pembayaran</h4>

                    <div class="summary-row">
                        <span>Total Tenant</span>
                        <strong id="checkoutTenantCount">0</strong>
                    </div>

                    <div class="summary-row">
                        <span>Total Produk</span>
                        <strong id="checkoutProductCount">0</strong>
                    </div>

                    <hr>

                    <div id="checkoutTenantSubtotals"></div>

                    <hr>

                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <strong id="checkoutGrandTotal">Rp0</strong>
                    </div>

                    <button type="submit"
                            class="checkout-btn"
                            id="placeOrderButton">
                        Buat Pesanan
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>

                    <div class="summary-information">
                        <i class="fa-solid fa-shield-halved"></i>
                        Pastikan seluruh informasi pesanan sudah benar.
                    </div>

                </aside>

            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/pages/checkout-order.js')
@endpush