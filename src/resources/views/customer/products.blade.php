@extends('layouts.customerorders')

@section('title', 'Daftar Produk')

@section('customer-content')
    <div class="container p-0 mb-3" data-customer-products>

        {{-- Header --}}
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="my-2" style="font-weight: 800; color: var(--text-main);">
                    Pilih <span style="color: var(--primary);">Produk</span>
                </h2>

                <span class="small" style="color: var(--text-muted);">
                    Temukan makanan dan minuman favoritmu dari berbagai kantin.
                </span>
            </div>

            <a href="{{ route('customer.tenants') }}" class="btn btn-sm btn-primary bg-gradient">
                <i class="fa-solid fa-arrow-left-long me-1"></i>
                <span>Ubah Pilihan Kantin</span>
            </a>
        </div>

        <div class="container">

            {{-- Pencarian --}}
            <div class="input-group mb-4 mx-auto shadow-sm">
                <span class="input-group-text bg-white border-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>

                <input
                    type="search"
                    class="form-control border-0"
                    placeholder="Cari produk dari seluruh kantin"
                    aria-label="Cari produk"
                >
            </div>

            {{-- Daftar Kantin dan Produk --}}
            @forelse ($tenants as $tenant)

                <div class="mb-5">

                    {{-- Informasi Kantin --}}
                    <div class="d-flex align-items-center mb-3">
                        <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                            <i class="fa-solid fa-store" style="color: var(--primary);"></i>
                        </h3>

                        <div class="d-flex flex-column align-items-start">
                            <span class="badge d-flex justify-content-center align-items-center
                                {{ $tenant->is_active ? 'text-success' : 'text-secondary' }}
                                bg-white border border-1">
                                <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                <span>{{ $tenant->is_active ? 'Kantin Buka' : 'Kantin Tutup' }}</span>
                            </span>

                            <h4 class="my-1 fw-bold" style="color: var(--text-main);">
                                {{ $tenant->name }}
                            </h4>

                            <span class="small" style="color: var(--text-muted);">
                                {{ $tenant->description ?: 'Temukan makanan dan minuman favoritmu dari kantin ini.' }}
                            </span>
                        </div>
                    </div>

                    {{-- Produk Kantin --}}
                    <div class="container p-0">
                        <div class="row row-cols-1 row-cols-md-3 g-3">

                            @forelse ($tenant->products as $product)

                                @php
                                    $cartQuantity = session(
                                        'customer_cart.' . $tenant->id . '.items.' . $product->id . '.quantity',
                                        0
                                    );
                                @endphp

                                <div class="col">
                                    <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">

                                        {{-- Status Produk --}}
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge d-flex justify-content-center align-items-center
                                                {{ $product->is_active ? 'text-success' : 'text-danger' }}
                                                bg-white border border-1">
                                                <span class="small">
                                                    {{ $product->is_active ? 'Tersedia' : 'Tidak Tersedia' }}
                                                </span>
                                            </span>
                                        </div>

                                        {{-- Gambar Produk --}}
                                        <img
                                            src="{{ $product->image
                                                ? asset('storage/' . $product->image)
                                                : asset('img-dummy/supermarket.png') }}"
                                            class="card-img-top"
                                            alt="{{ $product->name }}"
                                        >

                                        <div class="card-body">

                                            <h6 class="card-title fw-bold mb-2">
                                                {{ $product->name }}
                                            </h6>

                                            <p class="card-text text-muted small m-0">
                                                {{ $product->description ?: 'Belum ada deskripsi produk.' }}
                                            </p>

                                            <hr>

                                            {{-- Kontrol Keranjang --}}
                                            <div class="d-flex justify-content-center align-items-center gap-3">

                                                <form
                                                    action="{{ route('customer.cart.decrease', $product) }}"
                                                    method="POST"
                                                    data-cart-action
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger bg-gradient"
                                                        data-cart-decrease
                                                        {{ !$product->is_active || $cartQuantity <= 0 ? 'disabled' : '' }}
                                                    >
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                </form>

                                                <span class="fw-bold" data-cart-quantity>
                                                    {{ $cartQuantity }}
                                                </span>

                                                <form
                                                    action="{{ route('customer.cart.increase', $product) }}"
                                                    method="POST"
                                                    data-cart-action
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-success bg-gradient"
                                                        {{ !$product->is_active ? 'disabled' : '' }}
                                                    >
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty

                                <div class="col-12">
                                    <div class="alert alert-light text-center rounded-4">
                                        <i class="fa-solid fa-box-open fs-2 mb-2"></i>
                                        <p class="mb-0">
                                            Belum ada produk tersedia dari kantin ini.
                                        </p>
                                    </div>
                                </div>

                            @endforelse

                        </div>
                    </div>
                </div>

                @if (!$loop->last)
                    <hr class="my-4">
                @endif

            @empty

                <div class="alert alert-light text-center rounded-4">
                    <i class="fa-solid fa-store-slash fs-2 mb-2"></i>
                    <p class="mb-0">
                        Belum ada kantin yang dipilih.
                    </p>
                </div>

            @endforelse

        </div>
    </div>
@endsection