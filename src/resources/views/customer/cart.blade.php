@extends('layouts.customerorders')

@section('title', 'Keranjang Belanja')

@section('customer-content')
    @php
        $grandTotal = 0;
        $hasUnavailableItems = false;
    @endphp

    <div class="container p-0 mb-3" id="customer-cart-content" data-customer-cart>
        {{-- Header --}}
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

            <a href="{{ route('customer.tenants') }}" class="btn btn-sm btn-primary bg-gradient">
                <i class="fa-solid fa-arrow-left-long me-1"></i>
                <span>Kembali ke Daftar Kantin</span>
            </a>
        </div>

        <div class="container p-0">
            <div class="row flex-wrap g-3">
                {{-- Daftar Keranjang --}}
                <div class="col-lg-8">
                    @forelse ($cart as $tenantId => $tenantCart)
                        @php
                            $tenant = $tenants->get($tenantId);
                            $tenantActive = $tenant && $tenant->is_active;
                            $tenantSubtotal = 0;
                        @endphp

                        <div class="card border-0 shadow-sm mb-3"
                            data-cart-tenant="{{ $tenantId }}">

                            <div class="card-header border-0 {{ $tenantActive ? 'bg-success-subtle' : 'bg-danger-subtle' }}">
                                <span class="fw-bold {{ $tenantActive ? 'text-success' : 'text-danger' }} m-0"
                                    style="font-size: 12px;">
                                    {{ $tenantActive ? 'Kantin ini masih buka pemesanan' : 'Kantin ini tidak tersedia' }}
                                </span>
                            </div>

                            <div class="card-body">
                                <div class="d-flex flex-row align-items-center mb-2">
                                    <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                        <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                    </span>

                                    <h6 class="fw-bold m-0">
                                        {{ $tenantCart['tenant_name'] }}
                                    </h6>
                                </div>

                                <ul class="list-group list-group-flush">
                                    @foreach ($tenantCart['items'] as $productId => $item)
                                        @php
                                            $product = $tenant?->products->firstWhere('id', $productId);
                                            $productActive = $product && $product->is_active && $tenantActive;

                                            $quantity = (int) $item['quantity'];
                                            $unitPrice = (float) $item['unit_price'];
                                            $itemSubtotal = $unitPrice * $quantity;

                                            $tenantSubtotal += $itemSubtotal;

                                            if (! $productActive) {
                                                $hasUnavailableItems = true;
                                            }

                                            $image = ! empty($item['image'])
                                                ? asset('storage/' . $item['image'])
                                                : asset('img-dummy/supermarket.png');
                                        @endphp

                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2 px-0"
                                            data-cart-item="{{ $productId }}">

                                            <div class="d-flex justify-content-start align-items-center gap-3">
                                                <img src="{{ $image }}"
                                                    class="img-thumbnail object-fit-cover"
                                                    alt="{{ $item['product_name'] }}"
                                                    style="width: 100px; height: 70px;">

                                                <div class="d-flex flex-column gap-1">
                                                    <h6 class="fw-bold m-0">
                                                        {{ $item['product_name'] }}

                                                        <span class="badge rounded-pill {{ $productActive ? 'text-bg-success' : 'text-bg-danger' }} ms-1">
                                                            {{ $productActive ? 'Tersedia' : 'Tidak Tersedia' }}
                                                        </span>
                                                    </h6>

                                                    <span class="fw-bold small" style="word-spacing: 4px;">
                                                        Rp{{ number_format($unitPrice, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                @if ($product)
                                                    <form action="{{ route('customer.cart.decrease', $productId) }}"
                                                        method="POST" data-cart-action>
                                                        @csrf

                                                        <button type="submit"
                                                            class="btn btn-sm btn-secondary bg-gradient"
                                                            data-cart-decrease
                                                            {{ $quantity <= 1 ? 'disabled' : '' }}>
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                    </form>

                                                    <span class="fw-bold" data-cart-quantity>
                                                        {{ $quantity }}
                                                    </span>

                                                    <form action="{{ route('customer.cart.increase', $productId) }}"
                                                        method="POST" data-cart-action>
                                                        @csrf

                                                        <button type="submit"
                                                            class="btn btn-sm btn-secondary bg-gradient"
                                                            data-cart-increase
                                                            {{ ! $productActive ? 'disabled' : '' }}>
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="fw-bold" data-cart-quantity>
                                                        {{ $quantity }}
                                                    </span>
                                                @endif
                                                <form action="{{ route('customer.cart.remove', $productId) }}"
                                                    method="POST" data-cart-action>
                                                    @csrf

                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger bg-gradient"
                                                        title="Hapus produk">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>

                                                <span class="fw-bold small ms-2"
                                                    data-cart-item-subtotal>
                                                    Rp{{ number_format($itemSubtotal, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="card-footer border-0 {{ $tenantActive ? 'bg-light' : 'bg-danger-subtle' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold small">
                                        Subtotal {{ $tenantCart['tenant_name'] }}
                                    </span>

                                    <span class="fw-bold" data-tenant-subtotal>
                                        Rp{{ number_format($tenantSubtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                @php
                                    $grandTotal += $tenantSubtotal;
                                @endphp

                                @unless ($tenantActive)
                                    <span class="fw-bold text-danger d-block mt-2" style="font-size: 12px;">
                                        Kantin sedang tidak menerima pesanan.
                                    </span>
                                @endunless
                            </div>
                        </div>
                    @empty
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="fa-solid fa-basket-shopping fa-3x text-muted mb-3"></i>
                                <h5 class="fw-bold">Keranjang masih kosong</h5>
                                <p class="text-muted small">
                                    Silakan pilih produk dari kantin yang tersedia.
                                </p>

                                <a href="{{ route('customer.tenants') }}" class="btn btn-primary">
                                    Mulai Belanja
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Ringkasan Pesanan --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm px-2 sticky-top z-0"
                        style="top: 100px;">

                        <div class="card-body">
                            <h6 class="fw-bold m-0">Ringkasan Pesanan</h6>
                            <hr class="mb-2">

                            <ul class="list-group list-group-flush">
                                @foreach ($cart as $tenantId => $tenantCart)
                                    @php
                                        $tenantSubtotal = 0;
                                    @endphp

                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold small m-0">
                                                {{ $tenantCart['tenant_name'] }}
                                            </h6>
                                            <h6 class="fw-bold small m-0">Subtotal</h6>
                                        </div>

                                        @foreach ($tenantCart['items'] as $item)
                                            @php
                                                $itemSubtotal = (float) $item['unit_price'] * (int) $item['quantity'];
                                                $tenantSubtotal += $itemSubtotal;
                                            @endphp

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="text-muted small m-0">
                                                    {{ $item['product_name'] }} × {{ $item['quantity'] }}
                                                </h6>

                                                <h6 class="text-muted small m-0">
                                                    Rp{{ number_format($itemSubtotal, 0, ',', '.') }}
                                                </h6>
                                            </div>
                                        @endforeach

                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="fw-bold small">Subtotal Kantin</span>
                                            <span class="fw-bold small">
                                                Rp{{ number_format($tenantSubtotal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <hr>

                            <div class="d-flex flex-column mb-4">
                                <h6 class="fw-bold">Total Pembayaran</h6>

                                <h4 class="fw-bold m-0" style="color: var(--primary);"
                                    data-cart-grand-total>
                                    Rp{{ number_format($grandTotal, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="alert alert-warning m-0" role="alert" style="font-size: 12px;">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>
                                    Pembayaran dilakukan dalam satu transaksi untuk seluruh kantin pilihanmu.
                                </span>
                            </div>

                            <hr>

                            <a href="{{ route('customer.checkout') }}"
                                class="btn btn-primary w-100 {{ empty($cart) || $hasUnavailableItems ? 'disabled' : '' }}">
                                <span class="float-start">Pesan</span>
                                <span class="float-end">
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </span>
                            </a>

                            @if ($hasUnavailableItems)
                                <small class="text-danger d-block mt-2">
                                    Hapus produk yang tidak tersedia sebelum melanjutkan.
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection