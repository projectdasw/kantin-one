@extends('layouts.app')
@section('title', 'Bayar')
@section('content')
    <div class="container-fluid p-0 mb-4">
        <div class="sticky-top bg-white">
            <div class="d-flex flex-row justify-content-around align-items-center p-3">
                <div class="d-flex flex-row align-items-center">
                    <span class="p-2 fs-5 rounded-3 text-white" style="background-color: var(--primary);">
                        <i class="fa-solid fa-utensils"></i>
                    </span>
                    <div class="ms-2">
                        <h5 class="m-0" style="font-weight: 800;">
                            Kantin<span class="text-primary">.ONE</span>
                        </h5>
                    </div>
                </div>
                <ul class="nav nav-pills small">
                    <li class="nav-item">
                        <i class="fa-solid fa-cash-register fs-5 me-1 text-primary"></i>
                        <span>Pembayaran</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container p-0 mt-5 mb-3">
            <div class="d-flex flex-column justify-content align-items-center">
                <span class="display-5 bg-success-subtle text-success bg-gradient p-3 mb-4 rounded-circle">
                    <i class="fa-solid fa-check"></i>
                </span>
                <div class="text-center">
                    <h3 class="fw-bold">Pesanan Berhasil Dibuat!</h3>
                    <span class="text-muted m-0">
                        Pesanan kamu sudah kami terima. Silakan lakukan pembayaran pesanan Anda
                    </span>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card border-0 py-3 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-center gap-4">
                    <img src="{{ asset('img-dummy/qris.png') }}" class="img-thumbnail w-25 mx-auto border-0" alt="image/png">
                    <img src="{{ asset('img-dummy/qrcode.jpg') }}" class="img-thumbnail w-25 mx-auto" alt="image/png">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <h6 class="m-0">Total Pembayaran</h6>
                            <h6 class="fw-bold m-0">Rp999.999</h6>
                        </li>
                    </ul>
                    <div class="alert alert-warning fw-bold text-center" role="alert">
                        Silahkan lakukan pembayaran sebelum kadaluarsa di [00:00]
                    </div>
                    <button type="button" class="btn btn-success bg-gradient w-25 mx-auto">
                        Download QRIS
                    </button>
                    <a href="{{ route('customer.paycomplete') }}" class="btn btn-success w-100">
                        <span class="float-start">Next (Simulasi)</span>
                        <span class="float-end">
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection