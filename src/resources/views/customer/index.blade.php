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
                                        <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                            <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
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
                                    <form action="{{ route('customer.service.store') }}" method="POST">
                                        @csrf

                                        <h5 class="fw-bold">Pilih Jenis Layanan</h5>
                                        <hr>

                                        <label for="service-dine-in"
                                            class="form-check d-flex justify-content-between align-items-center px-4 py-3 border rounded-4">
                                            <span class="d-flex flex-row align-items-center">
                                                <span class="bg-primary-subtle px-2 py-1 fs-5 rounded-3 me-3">
                                                    <i class="fa-solid fa-chair text-primary"></i>
                                                </span>

                                                <span>
                                                    <strong class="d-block small">Dine In</strong>
                                                    <small class="text-muted">
                                                        Nikmati makanan dan minuman langsung di area kantin.
                                                    </small>
                                                </span>
                                            </span>

                                            <input class="form-check-input fs-4"
                                                type="radio"
                                                name="service_type"
                                                id="service-dine-in"
                                                value="dine_in"
                                                required>
                                        </label>

                                        <label for="service-take-away"
                                            class="form-check d-flex justify-content-between align-items-center my-3 px-4 py-3 border rounded-4">
                                            <span class="d-flex flex-row align-items-center">
                                                <span class="bg-warning-subtle px-2 py-1 fs-5 rounded-3 me-3">
                                                    <i class="fa-solid fa-bag-shopping text-warning"></i>
                                                </span>

                                                <span>
                                                    <strong class="d-block small">Take Away</strong>
                                                    <small class="text-muted">
                                                        Pesan sekarang dan bawa pulang pesanan Anda.
                                                    </small>
                                                </span>
                                            </span>

                                            <input class="form-check-input fs-4"
                                                type="radio"
                                                name="service_type"
                                                id="service-take-away"
                                                value="take_away">
                                        </label>

                                        <label for="service-after-activity"
                                            class="form-check d-flex justify-content-between align-items-center px-4 py-3 border rounded-4">
                                            <span class="d-flex flex-row align-items-center">
                                                <span class="bg-success-subtle px-2 py-1 fs-5 rounded-3 me-3">
                                                    <i class="fa-solid fa-calendar-check text-success"></i>
                                                </span>

                                                <span>
                                                    <strong class="d-block small">Pesanan Terjadwal</strong>
                                                    <small class="text-muted">
                                                        Pesan sekarang dan tentukan waktu pengambilan.
                                                    </small>
                                                </span>
                                            </span>

                                            <input class="form-check-input fs-4"
                                                type="radio"
                                                name="service_type"
                                                id="service-after-activity"
                                                value="after_activity">
                                        </label>

                                        @error('service_type')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror

                                        <button type="submit"
                                            class="btn btn-primary bg-gradient w-100 mt-4 rounded-3 py-3">
                                            Lanjutkan
                                            <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                        </button>
                                    </form>
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
@endsection