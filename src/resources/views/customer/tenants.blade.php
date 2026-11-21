@extends('layouts.customerorders')

@section('title', 'Pilih Kantin')

@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container text-center mb-3">
            <h1 class="display-5" style="font-weight: 800; color: var(--text-main);">
                Pilih <span style="color: var(--primary);">Kantin</span>
            </h1>
            <span class="small" style="color: var(--text-muted);">
                Pilih satu atau beberapa kantin untuk melihat seluruh menu yang tersedia.
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
                                <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                    <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
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
                <span class="input-group-text bg-white border-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input
                    type="search"
                    class="form-control border-0"
                    placeholder="Cari nama kantin"
                    aria-label="Cari nama kantin"
                >
            </div>

            <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
                <button type="button" class="btn btn-sm text-white rounded-5 px-3 py-2"
                    style="background-color: var(--primary);">Semua</button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    Tersedia
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    Tidak Tersedia
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <i class="fa-solid fa-bowl-food me-1"></i>
                    Makanan
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <i class="fa-solid fa-mug-hot me-1"></i>
                    Minuman
                </button>
                <button type="button" class="btn btn-sm bg-white rounded-5 px-3 py-2 border border-1">
                    <i class="fa-solid fa-cookie-bite me-1"></i>
                    Snacks
                </button>
            </div>

            <form action="{{ route('customer.tenants.store') }}" method="POST">
                @csrf

                @php
                    $selectedTenants = old(
                        'tenant_ids',
                        session('customer_selected_tenants', [])
                    );
                @endphp

                @if ($errors->has('tenant_ids'))
                    <div class="alert alert-danger rounded-3">
                        {{ $errors->first('tenant_ids') }}
                    </div>
                @endif

                <div class="container p-0">
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        @forelse ($tenants as $tenant)
                            <div class="col">
                                <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge d-flex justify-content-center align-items-center text-success bg-white border border-1">
                                            <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                            <span class="small">Buka</span>
                                        </span>
                                    </div>

                                    <img
                                        src="{{ asset('img-dummy/supermarket.png') }}"
                                        class="card-img-top"
                                        alt="{{ $tenant->name }}"
                                    >

                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-2">
                                            {{ $tenant->name }}
                                        </h6>

                                        <p class="card-text text-muted small m-0">
                                            {{ $tenant->description ?: 'Belum ada deskripsi kantin.' }}
                                        </p>

                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small text-muted">
                                                {{ $tenant->products_count }} menu tersedia
                                            </span>

                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input tenant-checkbox"
                                                    name="tenant_ids[]"
                                                    value="{{ $tenant->id }}"
                                                    id="tenant-{{ $loop->index }}"
                                                    {{ in_array($tenant->id, $selectedTenants) ? 'checked' : '' }}
                                                >

                                                <label
                                                    class="form-check-label small fw-semibold"
                                                    for="tenant-{{ $loop->index }}"
                                                >
                                                    Pilih
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light text-center rounded-4">
                                    <i class="fa-solid fa-store-slash fs-2 mb-2"></i>
                                    <p class="mb-0">Belum ada kantin yang tersedia saat ini.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if ($tenants->isNotEmpty())
                    <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-white rounded-4 shadow-sm">
                        <div>
                            <span class="fw-bold" id="selected-count">0 kantin dipilih</span>
                            <div class="small text-muted">
                                Pilih minimal satu kantin untuk melanjutkan.
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary rounded-3 px-4"
                            id="continue-button"
                            disabled
                        >
                            Lanjutkan
                            <i class="fa-solid fa-arrow-right-long ms-1"></i>
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.tenant-checkbox');
            const selectedCount = document.getElementById('selected-count');
            const continueButton = document.getElementById('continue-button');

            function updateSelection() {
                const totalSelected = document.querySelectorAll('.tenant-checkbox:checked').length;

                selectedCount.textContent = totalSelected + ' kantin dipilih';
                continueButton.disabled = totalSelected === 0;
            }

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', updateSelection);
            });

            updateSelection();
        });
    </script>
@endsection