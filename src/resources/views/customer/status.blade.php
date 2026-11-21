@extends('layouts.customerorders')
@section('title', 'Lacak Pesanan')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-circle text-success"></i>
                </h3>
                <div class="d-flex flex-column align-items-start">
                    <h3 class="my-2" style="font-weight: 800; color: var(--text-main);">
                        Lacak <span style="color: var(--primary);">Pesanan</span>
                    </h3>
                    <span class="small" style="color: var(--text-muted);">
                        Pantau perkembangan pesanan kamu dari setiap kantin.
                    </span>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mb-3 p-2">
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center align-items-center border border-1
                    p-3 gap-2 bg-success-subtle rounded-4">
                    <h6 class="text-muted m-0">Antrian Pesanan</h6>
                    <h5 class="m-0 mt-2 text-success fw-bold" style="word-spacing: 2px;">[Nomor Antrian Pesanan]</h5>
                    <h5 class="m-0 mb-2 text-success fw-bold">{{ $order->customer_name }}</h5>
                    <span class="text-muted small">
                        Tunjukan nomor Antrian Pesanan Anda kepada pegawai kantin saat mengambil pesanan
                    </span>
                </div>
                <hr class="mt-4 mb-3">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-receipt fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">No. Pesanan</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">{{ $order->order_number }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-wallet fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">Metode Pembayaran</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">
                                    {{ strtoupper($order->payment?->payment_method ?? '-') }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-utensils fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">Jenis Layanan</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">
                                    @switch($order->service_type)
                                        @case('dine_in')
                                            Dine In
                                            @break
                                        @case('take_away')
                                            Take Away
                                            @break
                                        @case('after_activity')
                                            Pesanan Terjadwal
                                            @break
                                        @default
                                            -
                                    @endswitch
                                </h6>

                                @if ($order->service_type === 'after_activity' && $order->pickup_date && $order->pickup_time)
                                    <div class="small text-muted mt-2">
                                        <i class="fa-regular fa-calendar me-1"></i>
                                        Jadwal Pengambilan
                                        <div class="fw-semibold text-success mt-1">
                                            {{ \Carbon\Carbon::parse($order->pickup_date)->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                                            <br>
                                            {{ \Carbon\Carbon::parse($order->pickup_time)->format('H:i') }} WIB
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-receipt fs-5" style="color: var(--primary);"></i>
                            <div class="ms-3">
                                <span class="text-muted small">Jumlah Kantin yang dipesan</span>
                                <h6 class="fw-bold m-0" style="color: var(--primary);">
                                    {{ $order->tenantOrders->count() }} Kantin
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-4 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Total Pesanan</span>
                    <h5 class="fw-bold text-success m-0">
                        Rp{{ number_format((float) $order->total, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>
        
        <div class="container p-0">
            <div class="row row-cols-1 row-cols-md-2 g-3">
                @forelse ($order->tenantOrders as $tenantOrder)
                    <div class="col">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex flex-row align-items-center">
                                        <span class="bg-light px-2 py-1 fs-5 rounded-3 me-3 border-0">
                                            <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                        </span>
                                        <h6 class="fw-bold m-0">
                                            {{ $tenantOrder->tenant?->name ?? 'Kantin' }}
                                        </h6>
                                    </div>

                                    <span class="text-muted text-end small">
                                        No. Pesanan
                                        <br>
                                        <strong class="fs-6 text-success">
                                            {{ $tenantOrder->order_number }}
                                        </strong>
                                    </span>
                                </div>

                                <div class="bg-success-subtle rounded-3 p-3 text-center mb-3">
                                    <span class="text-muted small d-block">Kode Pengambilan</span>
                                    <strong class="fs-4 text-success">
                                        {{ $tenantOrder->pickup_code }}
                                    </strong>
                                </div>

                                @php
                                    $statusSteps = [
                                        'pending' => 1,
                                        'preparing' => 2,
                                        'ready' => 3,
                                        'completed' => 4,
                                    ];

                                    $currentStep = $statusSteps[$tenantOrder->status] ?? 0;

                                    $timeline = [
                                        [
                                            'label' => 'Pesanan diterima',
                                            'time' => $tenantOrder->created_at,
                                            'step' => 1,
                                        ],
                                        [
                                            'label' => 'Sedang diproses',
                                            'time' => $tenantOrder->accepted_at,
                                            'step' => 2,
                                        ],
                                        [
                                            'label' => 'Siap diambil',
                                            'time' => $tenantOrder->ready_at,
                                            'step' => 3,
                                        ],
                                        [
                                            'label' => 'Pesanan selesai',
                                            'time' => $tenantOrder->completed_at,
                                            'step' => 4,
                                        ],
                                    ];
                                @endphp

                                <div class="mb-3" data-tracking-progress="{{ $tenantOrder->id }}">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-bold small">Progres Pesanan</span>

                                        <span class="badge data-tracking-status
                                            @if ($tenantOrder->status === 'pending') bg-warning text-dark
                                            @elseif ($tenantOrder->status === 'preparing') bg-info text-dark
                                            @elseif ($tenantOrder->status === 'ready') bg-success
                                            @elseif ($tenantOrder->status === 'completed') bg-secondary
                                            @else bg-light text-dark
                                            @endif">
                                            {{ [
                                                'pending' => 'Menunggu Konfirmasi',
                                                'preparing' => 'Sedang Diproses',
                                                'ready' => 'Siap Diambil',
                                                'completed' => 'Selesai',
                                            ][$tenantOrder->status] ?? 'Tidak Diketahui' }}
                                        </span>
                                    </div>

                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($timeline as $step)
                                            <div class="d-flex align-items-start gap-3">
                                                <div data-tracking-step="{{ $step['step'] }}" class="rounded-circle d-flex justify-content-center
                                                    align-items-center flex-shrink-0
                                                    {{ $currentStep >= $step['step']
                                                        ? 'bg-success text-white'
                                                        : 'bg-light text-muted border' }}"
                                                    style="width: 30px; height: 30px;">
                                                    @if ($currentStep >= $step['step'])
                                                        <i class="fa-solid fa-check small"></i>
                                                    @else
                                                        <i class="fa-solid fa-circle small"></i>
                                                    @endif
                                                </div>

                                                <div>
                                                    <div data-tracking-label="{{ $step['step'] }}" class="small fw-semibold
                                                        {{ $currentStep >= $step['step']
                                                            ? 'text-success'
                                                            : 'text-muted' }}">
                                                        {{ $step['label'] }}
                                                    </div>

                                                    <div class="text-muted"
                                                        data-tracking-time="{{ $step['step'] }}"
                                                        style="font-size: 11px;">
                                                        @if ($step['time'])
                                                            {{ $step['time']->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                                            WIB
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr class="my-3">

                                <ul class="list-group list-group-flush">
                                    @foreach ($tenantOrder->items as $item)
                                        <li class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="small">
                                                    {{ $item->product_name }} x {{ $item->quantity }}
                                                </span>
                                                <span class="fw-bold small">
                                                    Rp{{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <hr class="my-3">

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold small">Subtotal Kantin</span>
                                    <span class="fw-bold small">
                                        Rp{{ number_format((float) $tenantOrder->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Belum ada rincian pesanan kantin.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection