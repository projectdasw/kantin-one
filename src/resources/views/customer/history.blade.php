
@extends('layouts.customerorders')

@section('title', 'Riwayat Pesanan')

@section('customer-content')
    <div class="container p-0 mb-3">
        {{-- Header --}}
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-file-invoice" style="color: var(--primary);"></i>
                </h3>

                <div class="d-flex flex-column align-items-start">
                    <h3 class="my-2" style="font-weight: 800; color: var(--text-main);">
                        Riwayat <span style="color: var(--primary);">Pesanan</span>
                    </h3>

                    <span class="small" style="color: var(--text-muted);">
                        Kelola riwayat pemesanan Anda.
                    </span>
                </div>
            </div>
        </div>

        {{-- Riwayat Pesanan --}}
        <div class="card border-0 shadow-sm p-2">
            <div class="card-body">

                {{-- Form Pencarian dan Filter --}}
                <form action="{{ route('customer.history.search') }}" method="POST">
                    @csrf

                    @php
                        $activeFilter = $filter ?? 'all';
                        $searchValue = $search ?? old('search', '');
                    @endphp

                    <ul class="nav nav-pills gap-2">
                        <li class="nav-item">
                            <button type="submit" name="filter" value="all"
                                class="btn btn-sm {{ $activeFilter === 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                                Semua
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="submit" name="filter" value="processing"
                                class="btn btn-sm {{ $activeFilter === 'processing' ? 'btn-info' : 'btn-outline-info' }} text-dark">
                                Sedang diproses
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="submit" name="filter" value="pending"
                                class="btn btn-sm {{ $activeFilter === 'pending' ? 'btn-warning' : 'btn-outline-warning' }} text-dark">
                                Tertunda
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="submit" name="filter" value="completed"
                                class="btn btn-sm {{ $activeFilter === 'completed' ? 'btn-success' : 'btn-outline-success' }}">
                                Selesai
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="submit" name="filter" value="failed"
                                class="btn btn-sm {{ $activeFilter === 'failed' ? 'btn-danger' : 'btn-outline-danger' }}">
                                Gagal
                            </button>
                        </li>
                    </ul>

                    <div class="input-group mt-3">
                        <span class="input-group-text">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>

                        <input
                            type="search"
                            name="search"
                            class="form-control"
                            placeholder="Cari nama pemesan atau nomor pesanan"
                            value="{{ $searchValue }}"
                            maxlength="150"
                        >

                        <button type="submit" name="filter" value="all" class="btn btn-primary">
                            Cari
                        </button>
                    </div>
                </form>

                <hr>

                {{-- Pesan --}}
                @if (session('warning'))
                    <div class="alert alert-warning border-0 shadow-sm">
                        {{ session('warning') }}
                    </div>
                @endif

                {{-- Hasil Pencarian --}}
                @isset($orders)
                    @forelse ($orders as $order)
                        @php
                            $paymentStatus = $order->payment?->status ?? 'unknown';

                            if (
                                $paymentStatus === 'pending'
                                && $order->payment?->expires_at
                                && $order->payment->expires_at->isPast()
                            ) {
                                $paymentStatus = 'expired';
                            }

                            $statusLabels = [
                                'pending' => 'Tertunda',
                                'paid' => 'Sedang diproses',
                                'failed' => 'Gagal',
                                'expired' => 'Kedaluwarsa',
                                'unknown' => 'Tidak tersedia',
                            ];

                            $statusClasses = [
                                'pending' => 'bg-warning-subtle text-warning-emphasis',
                                'paid' => 'bg-info-subtle text-info-emphasis',
                                'failed' => 'bg-danger-subtle text-danger-emphasis',
                                'expired' => 'bg-secondary-subtle text-secondary-emphasis',
                                'unknown' => 'bg-secondary-subtle text-secondary-emphasis',
                            ];

                            $isCompleted = $order->tenantOrders->isNotEmpty()
                                && $order->tenantOrders->every(
                                    fn ($tenantOrder) => $tenantOrder->status === 'completed'
                                );
                        @endphp

                        <div class="border rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <small class="text-muted d-block">Nomor Pesanan</small>
                                    <span class="fw-bold" style="color: var(--primary);">
                                        {{ $order->order_number }}
                                    </span>
                                </div>

                                <span class="badge rounded-pill
                                    {{ $isCompleted ? 'bg-success-subtle text-success-emphasis' : ($statusClasses[$paymentStatus] ?? $statusClasses['unknown']) }}">
                                    {{ $isCompleted ? 'Selesai' : ($statusLabels[$paymentStatus] ?? 'Tidak tersedia') }}
                                </span>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Nama Pemesan</small>
                                    <span class="fw-semibold">
                                        {{ $order->customer_name }}
                                    </span>
                                </div>

                                <div class="col-6">
                                    <small class="text-muted d-block">Tanggal Pesanan</small>
                                    <span class="fw-semibold">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fw-semibold">Total Pesanan</span>
                                <span class="fw-bold">
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="container d-flex flex-column justify-content-center align-items-center bg-secondary-subtle rounded-2 py-4">
                            <div class="display-6 text-secondary mb-2">
                                <i class="fa-solid fa-file-invoice"></i>
                            </div>

                            <h6 class="m-0">Pesanan tidak ditemukan</h6>

                            <span class="small text-muted mt-2 text-center">
                                Tidak ada pesanan yang sesuai dengan pencarian dan filter.
                            </span>
                        </div>
                    @endforelse
                @else
                    {{-- Tampilan Awal --}}
                    <div class="container d-flex flex-column justify-content-center align-items-center bg-secondary-subtle rounded-2 py-4">
                        <div class="display-6 text-secondary mb-2">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>

                        <h6 class="m-0">Belum ada riwayat</h6>

                        <span class="small text-muted mt-2 text-center">
                            Masukkan nama pemesan atau nomor pesanan untuk melihat riwayat transaksi.
                        </span>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
