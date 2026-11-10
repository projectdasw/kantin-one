@extends('layouts.customerorders')
@section('title', 'Pilih Kantin')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container text-center mb-3">
            <h1 class="display-5" style="font-weight: 800; color: var(--text-main);">
                Pilih <span style="color: var(--primary);">Kantin</span>
            </h1>
            <span class="small" style="color: var(--text-muted);">
                Temukan makanan dan minuman favoritmu dari berbagai kantin.
            </span>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 g-3">
                <div class="col">
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row align-items-center">
                                <span class="bg-primary-subtle px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                    <i class="fa-solid fa-chair text-primary"></i>
                                </span>
                                <div>
                                    <span class="m-0" style="color: var(--text-muted); font-size: 12px;">Jenis Layanan</span>
                                    <h6 class="fw-bold small">Dine in</h6>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary px-3 rounded-3">
                                <span>Ubah</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row align-items-center">
                                <span class="bg-light px-2 py-1 fs-4 rounded-3 me-3 border-0">
                                    <i class="fa-solid fa-location-dot fs-5" style="color: var(--primary);"></i>
                                </span>
                                <div>
                                    <span class="m-0" style="color: var(--text-muted); font-size: 12px;">Lokasi Pemesanan</span>
                                    <h6 class="fw-bold small">Area Utama · Meja A-012</h6>
                                </div>
                            </div>
                            <h6 class="fw-bold m-0" style="font-size: 12px;">
                                <span class="text-success">
                                    <i class="fa-solid fa-globe me-1"></i>
                                    <span>Terhubung</span>
                                </span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3 mx-auto shadow-sm">
                <span class="input-group-text bg-white border-0" id="basic-addon1">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="search" class="form-control border-0" placeholder="Cari nama kantin"
                    aria-label="Cari nama kantin" aria-describedby="basic-addon1">
            </div>
            <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
                <button type="button" class="btn btn-sm text-white rounded-5 px-3 py-2"
                    style="background-color: var(--primary);">Semua</button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <span>Tersedia</span>
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <span>Tidak Tersedia</span>
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <i class="fa-solid fa-bowl-food me-1"></i>
                    <span>Makanan</span>
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <i class="fa-solid fa-mug-hot me-1"></i>
                    <span>Minuman</span>
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <i class="fa-solid fa-cookie-bite me-1"></i>
                    <span>Snacks</span>
                </button>
            </div>
            <div class="container p-0">
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                    <span class="small">Buka</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Kantin 1</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-primary float-end">
                                    <span>Lihat Menu</span>
                                    <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                    <span class="small">Buka</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Kantin 2</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-primary float-end">
                                    <span>Lihat Menu</span>
                                    <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                    <span class="small">Buka</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Kantin 3</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-primary float-end">
                                    <span>Lihat Menu</span>
                                    <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                    <span class="small">Buka</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Kantin 4</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-primary float-end">
                                    <span>Lihat Menu</span>
                                    <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                </a>
                            </div>
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
            <a href="{{ route('customer.index') }}" class="order-brand">
                <span class="brand-icon">
                    <i class="fa-solid fa-utensils"></i>
                </span>
                <span>Kantin<span class="text-primary">.ONE</span></span>
            </a>

            <button class="cart-button" type="button">
                <i class="fa-solid fa-basket-shopping"></i>
                <span>Keranjang</span>
                <span class="cart-count">0</span>
            </button>
        </header>

        {{-- PAGE HEADING --}}
        <section class="tenant-heading">
            <span class="welcome-label">KANTIN.ONE ORDERING</span>
            <h1>Pilih <span>Tenant</span></h1>
            <p>
                Temukan makanan dan minuman favoritmu
                dari berbagai tenant kantin.
            </p>
        </section>

        {{-- SERVICE INFORMATION --}}
        <div class="selected-service">
            <div class="selected-service-icon">
                <i class="fa-solid fa-chair" id="serviceIcon"></i>
            </div>

            <div>
                <small>Jenis Layanan</small>
                <h6 id="serviceName">Dine In</h6>
            </div>

            <a href="{{ route('customer.index') }}">
                Ubah
            </a>
        </div>

        {{-- SEARCH --}}
        <div class="tenant-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
                type="search"
                id="tenantSearch"
                placeholder="Cari nama tenant..."
            >
        </div>

        {{-- CATEGORY --}}
        <div class="tenant-categories">
            <button class="category-btn active" data-category="all">
                Semua
            </button>

            <button class="category-btn" data-category="makanan">
                <i class="fa-solid fa-bowl-food me-1"></i>
                Makanan
            </button>

            <button class="category-btn" data-category="minuman">
                <i class="fa-solid fa-mug-hot me-1"></i>
                Minuman
            </button>

            <button class="category-btn" data-category="snack">
                <i class="fa-solid fa-cookie-bite me-1"></i>
                Snack
            </button>
        </div>

        {{-- TENANT LIST --}}
        <section class="tenant-list-section">

            <div class="tenant-list-heading">
                <div>
                    <h4>Tenant Kantin</h4>
                    <p id="tenantCount">4 tenant tersedia</p>
                </div>

                <span>
                    <i class="fa-solid fa-store me-1"></i>
                    Daftar Tenant
                </span>
            </div>

            <div class="tenant-grid" id="tenantGrid">

                {{-- TENANT 1 --}}
                <article class="tenant-card"
                    data-name="warung nusantara"
                    data-category="makanan">

                    <div class="tenant-image">
                        <img src="{{ asset('img-dummy/supermarket.png') }}"
                             alt="Warung Nusantara">

                        <span class="tenant-open">
                            <i class="fa-solid fa-circle"></i>
                            Buka
                        </span>
                    </div>

                    <div class="tenant-card-body">
                        <span class="tenant-category">Makanan</span>

                        <h5>Warung Nusantara</h5>

                        <p>
                            Aneka makanan khas nusantara
                            dengan cita rasa rumahan.
                        </p>

                        <div class="tenant-card-footer">
                            <span>
                                <i class="fa-solid fa-clock"></i>
                                10–15 menit
                            </span>

                            <a href="{{ route('customer.products', 'warung-nusantara') }}"
                                class="tenant-menu-btn">
                                    Lihat Menu
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                        </div>
                    </div>
                </article>

                {{-- TENANT 2 --}}
                <article class="tenant-card"
                    data-name="kopi sudut"
                    data-category="minuman">

                    <div class="tenant-image">
                        <img src="{{ asset('img-dummy/supermarket.png') }}"
                             alt="Kopi Sudut">

                        <span class="tenant-open">
                            <i class="fa-solid fa-circle"></i>
                            Buka
                        </span>
                    </div>

                    <div class="tenant-card-body">
                        <span class="tenant-category">Minuman</span>

                        <h5>Kopi Sudut</h5>

                        <p>
                            Pilihan kopi, teh, dan minuman
                            segar untuk menemani aktivitas.
                        </p>

                        <div class="tenant-card-footer">
                            <span>
                                <i class="fa-solid fa-clock"></i>
                                5–10 menit
                            </span>

                            <a href="{{ route('customer.products', 'kopi-sudut') }}"
                                class="tenant-menu-btn">
                                    Lihat Menu
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                        </div>
                    </div>
                </article>

                {{-- TENANT 3 --}}
                <article class="tenant-card"
                    data-name="snack corner"
                    data-category="snack">

                    <div class="tenant-image">
                        <img src="{{ asset('img-dummy/supermarket.png') }}"
                             alt="Snack Corner">

                        <span class="tenant-open">
                            <i class="fa-solid fa-circle"></i>
                            Buka
                        </span>
                    </div>

                    <div class="tenant-card-body">
                        <span class="tenant-category">Snack</span>

                        <h5>Snack Corner</h5>

                        <p>
                            Berbagai camilan dan makanan
                            ringan untuk menemani harimu.
                        </p>

                        <div class="tenant-card-footer">
                            <span>
                                <i class="fa-solid fa-clock"></i>
                                5–10 menit
                            </span>

                            <a href="{{ route('customer.products', 'snack-order') }}"
                                class="tenant-menu-btn">
                                    Lihat Menu
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                        </div>
                    </div>
                </article>

                {{-- TENANT 4 --}}
                <article class="tenant-card"
                    data-name="dapur express"
                    data-category="makanan">

                    <div class="tenant-image">
                        <img src="{{ asset('img-dummy/supermarket.png') }}"
                             alt="Dapur Express">

                        <span class="tenant-closed">
                            <i class="fa-solid fa-circle"></i>
                            Tutup
                        </span>
                    </div>

                    <div class="tenant-card-body">
                        <span class="tenant-category">Makanan</span>

                        <h5>Dapur Express</h5>

                        <p>
                            Sajian makanan praktis untuk
                            kebutuhan sehari-hari.
                        </p>

                        <div class="tenant-card-footer">
                            <span>
                                <i class="fa-solid fa-clock"></i>
                                -
                            </span>

                            <a href="{{ route('customer.products', 'dapur-express') }}"
                                class="tenant-menu-btn">
                                    Lihat Menu
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                        </div>
                    </div>
                </article>

            </div>

            {{-- EMPTY STATE --}}
            <div class="tenant-empty d-none" id="tenantEmpty">
                <i class="fa-solid fa-store-slash"></i>
                <h5>Tenant tidak ditemukan</h5>
                <p>Coba gunakan kata pencarian lainnya.</p>
            </div>

        </section>

    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/pages/tenants-order.js')
@endpush