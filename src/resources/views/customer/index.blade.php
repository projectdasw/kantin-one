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
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                        Lokasi Pemesanan
                                    </h5>

                                    @if ($selectedTable)
                                        <div class="alert alert-success mb-3">
                                            <div class="fw-bold mb-1">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Meja Berhasil Terhubung
                                            </div>

                                            <div>
                                                {{ $selectedTable->canteen->name }}
                                            </div>

                                            <div class="small text-muted">
                                                {{ $selectedTable->floor->building->name }}
                                                · {{ $selectedTable->floor->name }}
                                                · Meja {{ $selectedTable->table_number }}
                                            </div>
                                        </div>

                                        <form action="{{ route('customer.table.disconnect') }}" method="POST">
                                            @csrf

                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-unlink me-1"></i>
                                                Putuskan Koneksi Meja
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-muted small mb-3">
                                            Silakan pilih meja untuk menyimulasikan proses pemindaian QR Code.
                                        </p>

                                        <form action="{{ route('customer.table.simulate') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="table_id" class="form-label fw-semibold">
                                                    Pilih Meja
                                                </label>

                                                <select
                                                    name="table_id"
                                                    id="table_id"
                                                    class="form-select @error('table_id') is-invalid @enderror"
                                                    required
                                                >
                                                    <option value="">-- Pilih Meja --</option>

                                                    @foreach ($tables as $table)
                                                        <option
                                                            value="{{ $table->id }}"
                                                            {{ old('table_id') == $table->id ? 'selected' : '' }}
                                                        >
                                                            {{ $table->canteen->name }}
                                                            - {{ $table->floor->building->name }}
                                                            - {{ $table->floor->name }}
                                                            - Meja {{ $table->table_number }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('table_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-qrcode me-1"></i>
                                                Simulasikan Scan QR Meja
                                            </button>
                                        </form>
                                    @endif
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