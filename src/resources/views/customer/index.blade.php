@extends('layouts.customerorders')
@section('title', 'Pemesanan')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container">
            <div class="card border-0 bg-transparent">
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        <div class="col">
                            <strong class="small" style="font-weight: 800; letter-spacing: 3px; color: var(--primary);">SELAMAT DATANG</strong>
                            <h1 class="display-5 my-3" style="font-weight: 800; color: var(--text-main);">
                                Mau makan apa<br>
                                <span style="color: var(--primary);">hari ini?</span>
                            </h1>
                            <span class="small" style="color: var(--text-muted);">Nikmati kemudahan memesan makanan dan minuman dari berbagai kantin</span>
                            <div class="container p-0 mt-4">
                                <div class="row row-cols-1 row-cols-md-3 g-3 mb-3">
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img" alt="image/png">
                                            <div class="card-img-overlay">
                                                <h5 class="card-title"></h5>
                                                <p class="card-text"></p>
                                                <p class="card-text"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img" alt="image/png">
                                            <div class="card-img-overlay">
                                                <h5 class="card-title"></h5>
                                                <p class="card-text"></p>
                                                <p class="card-text"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img" alt="image/png">
                                            <div class="card-img-overlay">
                                                <h5 class="card-title"></h5>
                                                <p class="card-text"></p>
                                                <p class="card-text"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-row align-items-center">
                                        <span class="bg-light px-2 py-1 fs-4 rounded-3 me-3 border-0">
                                            <i class="fa-solid fa-location-dot fs-5" style="color: var(--primary);"></i>
                                        </span>
                                        <div>
                                            <span class="m-0" style="color: var(--text-muted); font-size: 12px;">Lokasi Pemesanan</span>
                                            <h6 class="fw-bold m-0 small">Area Utama · Meja A-012</h6>
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
                        <div class="col">
                            <div class="card border-0 shadow-sm mt-4 rounded-4">
                                <div class="card-body px-5 py-4">
                                    <h5 class="fw-bold">Pilih Jenis Layanan</h5>
                                    <hr>
                                    <div class="form-check d-flex justify-content-between align-items-center px-4 py-3 border border-1 rounded-4">
                                        <label class="form-check-label d-flex flex-row align-items-center" for="radioDefault1">
                                            <span class="bg-primary-subtle px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                                <i class="fa-solid fa-chair text-primary"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-bold m-0 small">Dine In</h6>
                                                <span class="m-0" style="color: var(--text-muted); font-size: 12px;">
                                                    Nikmati makanan dan minuman langsung di area kantin
                                                </span>
                                            </div>
                                        </label>
                                        <input class="form-check-input fs-4" type="radio" name="radioDefault" id="radioDefault1">
                                    </div>
                                    <div class="form-check d-flex justify-content-between align-items-center my-3 px-4 py-3 border border-1 rounded-4">
                                        <label class="form-check-label d-flex flex-row align-items-center" for="radioDefault1">
                                            <span class="bg-warning-subtle px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                                <i class="fa-solid fa-bag-shopping text-warning"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-bold m-0 small">Take Away</h6>
                                                <span class="m-0" style="color: var(--text-muted); font-size: 12px;">
                                                    Pesan sekarang dan bawa pulang pesanan Anda.
                                                </span>
                                            </div>
                                        </label>
                                        <input class="form-check-input fs-4" type="radio" name="radioDefault" id="radioDefault1">
                                    </div>
                                    <div class="form-check d-flex justify-content-between align-items-center px-4 py-3 border border-1 rounded-4">
                                        <label class="form-check-label d-flex flex-row align-items-center" for="radioDefault1">
                                            <span class="bg-success-subtle px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                                <i class="fa-solid fa-calendar-check text-success"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-bold m-0 small">Pesanan Terjadwal</h6>
                                                <span class="m-0" style="color: var(--text-muted); font-size: 12px;">
                                                    Pesan sekarang dan tentukan waktu pengambilan pesanan
                                                </span>
                                            </div>
                                        </label>
                                        <input class="form-check-input fs-4" type="radio" name="radioDefault" id="radioDefault1">
                                    </div>
                                    <a href="{{ route('customer.tenants') }}" class="btn btn-primary bg-gradient w-100 mt-4 rounded-3 py-3">
                                        <span>Lanjutkan</span>
                                        <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                    </a>
                                    <div class="text-muted text-center small mt-3">
                                        <i class="fa-solid fa-shield-halved me-1"></i>
                                        <span>Pemesanan mudah, aman, dan praktis.</span>
                                    </div>
                                </div>
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
            <a href="#" class="order-brand">
                <span class="brand-icon">
                    <i class="fa-solid fa-utensils"></i>
                </span>
                <span>Kantin<span class="text-primary">.ONE</span></span>
            </a>

            <span class="order-badge">
                <i class="fa-solid fa-circle-check"></i>
                Pemesanan Online
            </span>
        </header>

        {{-- WELCOME --}}
        <section class="order-welcome">
            <span class="welcome-label">SELAMAT DATANG</span>

            <h1>
                Mau makan apa<br>
                <span>hari ini?</span>
            </h1>

            <p>
                Nikmati kemudahan memesan makanan dan minuman
                dari berbagai tenant kantin.
            </p>
        </section>

        {{-- TABLE INFORMATION --}}
        <div class="table-information">
            <div class="table-icon">
                <i class="fa-solid fa-location-dot"></i>
            </div>

            <div>
                <small>Lokasi Pemesanan</small>
                <h6>Area Utama · Meja A-012</h6>
            </div>

            <span class="table-status">
                <i class="fa-solid fa-circle"></i>
                Terhubung
            </span>
        </div>

        {{-- SERVICE SELECTION --}}
        <section class="service-section">

            <div class="section-heading">
                <div>
                    <h4>Pilih Jenis Layanan</h4>
                    <p>Bagaimana Anda ingin menikmati pesanan?</p>
                </div>
            </div>

            <div class="service-list">

                {{-- DINE IN --}}
                <label class="service-card">
                    <input
                        type="radio"
                        name="service_type"
                        value="dine_in"
                    >

                    <div class="service-icon dine-in">
                        <i class="fa-solid fa-chair"></i>
                    </div>

                    <div class="service-information">
                        <h5>Dine In</h5>
                        <p>
                            Nikmati makanan dan minuman
                            langsung di area kantin.
                        </p>
                    </div>

                    <div class="service-check">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </label>

                {{-- TAKE AWAY --}}
                <label class="service-card">
                    <input
                        type="radio"
                        name="service_type"
                        value="take_away"
                    >

                    <div class="service-icon take-away">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>

                    <div class="service-information">
                        <h5>Take Away</h5>
                        <p>
                            Pesan sekarang dan bawa
                            pulang pesanan Anda.
                        </p>
                    </div>

                    <div class="service-check">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </label>

                {{-- AFTER EVENT --}}
                <label class="service-card">
                    <input
                        type="radio"
                        name="service_type"
                        value="after_event"
                    >

                    <div class="service-icon after-event">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>

                    <div class="service-information">
                        <h5>Diambil Setelah Kegiatan</h5>
                        <p>
                            Pesan sekarang dan tentukan
                            waktu pengambilan nanti.
                        </p>
                    </div>

                    <div class="service-check">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </label>

            </div>

            {{-- SCHEDULE --}}
            <div class="schedule-section d-none" id="scheduleSection">

                <h6>
                    <i class="fa-regular fa-clock me-2"></i>
                    Jadwal Pengambilan
                </h6>

                <div class="row g-3">

                    <div class="col-6">
                        <label for="pickupDate" class="form-label">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="pickupDate"
                        >
                    </div>

                    <div class="col-6">
                        <label for="pickupTime" class="form-label">
                            Jam
                        </label>

                        <input
                            type="time"
                            class="form-control"
                            id="pickupTime"
                        >
                    </div>

                </div>
            </div>

            {{-- CONTINUE --}}
            <button
                type="button"
                class="btn btn-continue"
                id="continueOrder"
                disabled
            >
                Lanjutkan
                <i class="fa-solid fa-arrow-right"></i>
            </button>

            <div class="order-footer">
                <i class="fa-solid fa-shield-halved"></i>
                Pemesanan mudah, aman, dan praktis.
            </div>

        </section>

    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/pages/customer-order.js')
@endpush