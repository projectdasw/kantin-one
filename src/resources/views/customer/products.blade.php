@extends('layouts.customerorders')

@section('title', $tenant->name)

@section('customer-content')
    <div class="container p-0 mb-3" data-customer-products>
        <div class="container d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-store" style="color: var(--primary);"></i>
                </h3>

                <div class="d-flex flex-column align-items-start">
                    <span class="badge d-flex justify-content-center align-items-center
                        {{ $tenant->is_active ? 'text-success' : 'text-secondary' }}
                        bg-white border border-1 fs-6">
                        <i class="fa-solid fa-circle me-1"></i>
                        <span>{{ $tenant->is_active ? 'Kantin ini buka' : 'Kantin tutup' }}</span>
                    </span>

                    <h3 class="my-2" style="font-weight: 800; color: var(--text-main);">
                        {{ $tenant->name }}
                    </h3>

                    <span class="small" style="color: var(--text-muted);">
                        {{ $tenant->description ?: 'Temukan makanan dan minuman favoritmu dari kantin ini.' }}
                    </span>
                </div>
            </div>

            <a href="{{ route('customer.tenants') }}" class="btn btn-sm btn-primary bg-gradient">
                <i class="fa-solid fa-arrow-left-long me-1"></i>
                <span>Kembali ke Daftar Kantin</span>
            </a>
        </div>

        <div class="container">
            <div class="input-group mb-3 mx-auto shadow-sm">
                <span class="input-group-text bg-white border-0" id="basic-addon1">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>

                <input
                    type="search"
                    class="form-control border-0"
                    placeholder="Cari produk kantin"
                    aria-label="Cari produk kantin"
                    aria-describedby="basic-addon1"
                >
            </div>

            <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
                <button type="button" class="btn btn-sm text-white rounded-5 px-3 py-2"
                    style="background-color: var(--primary);">
                    Semua
                </button>

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
                    @forelse ($products as $product)
                        @php
                            $cartQuantity = session('customer_cart.' . $tenant->id . '.items.' . $product->id . '.quantity', 0);
                        @endphp
                        <div class="col">
                            <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge d-flex justify-content-center align-items-center
                                        {{ $product->is_active ? 'text-success' : 'text-danger' }}
                                        bg-white border border-1">
                                        <span class="small">
                                            {{ $product->is_active ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </span>
                                </div>

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

                                    <div class="d-flex justify-content-center align-items-center gap-3">

    <form action="{{ route('customer.cart.decrease', $product) }}"
        method="POST"
        data-cart-action>
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

    <span class="fw-bold" data-cart-quantity>{{ $cartQuantity }}</span>

    <form action="{{ route('customer.cart.increase', $product) }}"
        method="POST"
        data-cart-action>
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
                                <p class="mb-0">Belum ada produk yang tersedia di kantin ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection