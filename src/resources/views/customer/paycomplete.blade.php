@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')
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
        <div class="container p-0 mt-4">
            <div class="d-flex flex-column justify-content align-items-center gap-3">
                <span class="display-5 bg-success-subtle text-success bg-gradient p-3 rounded-circle">
                    <i class="fa-solid fa-check"></i>
                </span>
                <div class="text-center">
                    <h3 class="fw-bold">Pembayaran berhasil</h3>
                    <span class="text-muted m-0">
                        Pembayaran telah berhasil dan terverifikasi.
                        <br>
                        Terima kasih telah berbelanja di Kantin.ONE
                    </span>
                </div>
                <button type="button" class="btn btn-success bg-gradient w-25">
                    Lihat Pesanan
                </button>
            </div>
        </div>
    </div>
@endsection