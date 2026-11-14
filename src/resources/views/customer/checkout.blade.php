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
            <form action="{{ route('customer.checkout.place-order') }}" method="POST">
                @csrf

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
                                @foreach ($cart as $tenantId => $tenantCart)
                                    @php
                                        $tenant = $tenants->get($tenantId);
                                        $tenantSubtotal = 0;
                                    @endphp

                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex flex-row align-items-center mb-2">
                                                <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                                    <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                                </span>

                                                <h6 class="fw-bold m-0">
                                                    {{ $tenantCart['tenant_name'] }}
                                                </h6>
                                            </div>

                                            <hr>

                                            @foreach ($tenantCart['items'] as $productId => $item)
                                                @php
                                                    $product = $tenant?->products->firstWhere('id', $productId);
                                                    $unitPrice = (float) ($product?->price ?? $item['unit_price']);
                                                    $quantity = (int) $item['quantity'];
                                                    $subtotal = $unitPrice * $quantity;

                                                    $tenantSubtotal += $subtotal;

                                                    $image = ! empty($item['image'])
                                                        ? asset('storage/' . $item['image'])
                                                        : asset('img-dummy/supermarket.png');
                                                @endphp

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                                        <img src="{{ $image }}"
                                                            class="img-thumbnail object-fit-cover"
                                                            alt="{{ $item['product_name'] }}"
                                                            style="width: 100px; height: 70px;">

                                                        <div class="d-flex flex-column gap-1">
                                                            <h6 class="fw-bold m-0">
                                                                {{ $item['product_name'] }}
                                                            </h6>

                                                            <span class="text-muted small">
                                                                {{ $quantity }} x Rp{{ number_format($unitPrice, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <span class="fw-bold">
                                                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            @endforeach

                                            <hr>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold small">Subtotal {{ $tenantCart['tenant_name'] }}</span>

                                                <span class="fw-bold">
                                                    Rp{{ number_format($tenantSubtotal, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <hr>

                                            <div>
                                                <label for="tenant-notes-{{ $tenantId }}" class="form-label small fw-bold">
                                                    Catatan untuk {{ $tenantCart['tenant_name'] }}
                                                </label>

                                                <textarea
                                                    name="tenant_notes[{{ $tenantId }}]"
                                                    id="tenant-notes-{{ $tenantId }}"
                                                    class="form-control form-control-sm"
                                                    rows="2"
                                                    maxlength="500"
                                                    placeholder="Contoh: Tidak menggunakan saus."
                                                >{{ old("tenant_notes.$tenantId", $checkoutDetails['tenant_notes'][$tenantId] ?? '') }}</textarea>

                                                @error("tenant_notes.$tenantId")
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Jenis Layanan</small>

                                        @switch($customerService['service_type'])
                                            @case('dine_in')
                                                <strong>
                                                    <i class="fa-solid fa-chair text-primary me-2"></i>
                                                    Dine In
                                                </strong>
                                                @break

                                            @case('take_away')
                                                <strong>
                                                    <i class="fa-solid fa-bag-shopping text-warning me-2"></i>
                                                    Take Away
                                                </strong>
                                                @break

                                            @case('after_activity')
                                                <strong>
                                                    <i class="fa-solid fa-calendar-check text-success me-2"></i>
                                                    Pesanan Terjadwal
                                                </strong>
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="d-flex flex-row align-items-center bg-light p-2 border rounded-3 mb-3">
                                        <span class="bg-primary-subtle px-2 py-1 fs-5 rounded-3 me-3">
                                            <i class="fa-solid fa-info-circle text-primary"></i>
                                        </span>

                                        <div>
                                            <h6 class="fw-bold m-0 small">
                                                Informasi Layanan
                                            </h6>

                                            <span class="text-muted" style="font-size: 12px;">
                                                @switch($customerService['service_type'])
                                                    @case('dine_in')
                                                        Pesanan dinikmati langsung di area kantin.
                                                        @break

                                                    @case('take_away')
                                                        Pesanan disiapkan untuk dibawa pulang.
                                                        @break

                                                    @case('after_activity')
                                                        Pesanan disiapkan sesuai jadwal pengambilan.
                                                        @break
                                                @endswitch
                                            </span>
                                        </div>
                                    </div>
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
                                    <div class="mb-3">
                                        <label for="customer-name" class="form-label small">
                                            Nama Pemesan <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            name="customer_name"
                                            id="customer-name"
                                            class="form-control form-control-sm"
                                            placeholder="Masukkan nama Anda"
                                            value="{{ old('customer_name', $checkoutDetails['customer_name'] ?? '') }}"
                                            maxlength="100"
                                            required
                                        >

                                        @error('customer_name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer-phone" class="form-label small">
                                            Nomor Telepon <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="tel"
                                            name="customer_phone"
                                            id="customer-phone"
                                            class="form-control form-control-sm"
                                            placeholder="Contoh: 081234567890"
                                            value="{{ old('customer_phone', $checkoutDetails['customer_phone'] ?? '') }}"
                                            maxlength="20"
                                            required
                                        >

                                        @error('customer_phone')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="order-notes" class="form-label small">
                                            Catatan Umum Pesanan
                                        </label>

                                        <textarea
                                            name="notes"
                                            id="order-notes"
                                            class="form-control form-control-sm"
                                            rows="3"
                                            maxlength="1000"
                                            placeholder="Tambahkan catatan untuk keseluruhan pesanan..."
                                        >{{ old('notes', $checkoutDetails['notes'] ?? '') }}</textarea>

                                        @error('notes')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
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
                                            <h6 class="fw-bold small mb-3">Subtotal</h6>

                                            @foreach ($cart as $tenantId => $tenantCart)
                                                @php
                                                    $tenant = $tenants->get($tenantId);
                                                    $tenantSubtotal = 0;

                                                    foreach ($tenantCart['items'] as $productId => $item) {
                                                        $product = $tenant?->products->firstWhere('id', $productId);

                                                        if ($tenant && $tenant->is_active && $product && $product->is_active) {
                                                            $tenantSubtotal += (float) $product->price * (int) $item['quantity'];
                                                        }
                                                    }
                                                @endphp

                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="fw-bold small m-0">
                                                        {{ $tenantCart['tenant_name'] }}
                                                    </h6>

                                                    <h6 class="fw-bold small m-0">
                                                        Rp{{ number_format($tenantSubtotal, 0, ',', '.') }}
                                                    </h6>
                                                </div>
                                            @endforeach
                                        </li>
                                    </ul>

                                    <hr>

                                    <div class="d-flex flex-column mb-4">
                                        <h6 class="fw-bold">Total Pembayaran</h6>

                                        <h4 class="fw-bold m-0" style="color: var(--primary);">
                                            Rp{{ number_format($grandTotal, 0, ',', '.') }}
                                        </h4>
                                    </div>
                                    <div class="alert alert-warning m-0" role="alert" style="font-size: 12px;">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>Pembayaran dilakukan dalam satu transaksi untuk seluruh kantin pilihanmu</span>
                                    </div>
                                    <hr>
                                    <a href="{{ route('customer.payment') }}" class="btn btn-success w-100">
                                        <span class="float-start">Bayar Pesanan</span>
                                        <span class="float-end">
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </span>
                                    </a>
                                    <button
                                        type="submit"
                                        class="btn btn-success w-100"
                                        @disabled($hasUnavailableItems)
                                    >
                                        <span class="float-start">Buat Pesanan</span>
                                        <span class="float-end">
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection