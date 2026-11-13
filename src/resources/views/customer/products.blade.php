@extends('layouts.customerorders')
@section('title', '[Nama Kantin]')
@section('customer-content')
    <div class="container p-0 mb-3">
        <div class="container d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h3 class="bg-light px-2 py-1 rounded-3 me-3 border-0">
                    <i class="fa-solid fa-store" style="color: var(--primary);"></i>
                </h3>
                <div class="d-flex flex-column align-items-start">
                    <span class="badge d-flex justify-content-center align-items-center text-success
                        bg-white border border-1 fs-6">
                        <i class="fa-solid fa-circle me-1"></i>
                        <span>Kantin ini buka</span>
                    </span>
                    <h3 class="my-2" style="font-weight: 800; color: var(--text-main);">[Nama Kantin]</h3>
                    <span class="small" style="color: var(--text-muted);">
                        Temukan makanan dan minuman favoritmu dari berbagai tenant kantin.
                    </span>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-primary bg-gradient">
                <i class="fa-solid fa-arrow-left-long me-1"></i>
                <span>Kembali ke Daftar Kantin</span>
            </button>
        </div>
        <div class="container">
            <div class="input-group mb-3 mx-auto shadow-sm">
                <span class="input-group-text bg-white border-0" id="basic-addon1">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="search" class="form-control border-0" placeholder="Cari produk kantin"
                    aria-label="Cari nama kantin" aria-describedby="basic-addon1">
            </div>
            <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
                <button type="button" class="btn btn-sm text-white rounded-5 px-3 py-2"
                    style="background-color: var(--primary);">Semua</button>
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
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <span class="small">Tersedia</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Produk 1</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold">Rp. 999.999</h6>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="fw-bold">0</span>
                                        <button type="button" class="btn btn-sm btn-success bg-gradient">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <span class="small">Tersedia</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Produk 2</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold">Rp. 999.999</h6>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="fw-bold">0</span>
                                        <button type="button" class="btn btn-sm btn-success bg-gradient">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <span class="small">Tersedia</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Produk 3</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold">Rp. 999.999</h6>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="fw-bold">0</span>
                                        <button type="button" class="btn btn-sm btn-success bg-gradient">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge d-flex justify-content-center align-items-center text-success
                                    bg-white border border-1">
                                    <span class="small">Tersedia</span>
                                </span>
                            </div>
                            <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Produk 4</h6>
                                <p class="card-text text-muted small m-0">
                                    Aneka makanan khas nusantara dengan cita rasa rumahan.
                                </p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold">Rp. 999.999</h6>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <button type="button" class="btn btn-sm btn-danger bg-gradient">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="fw-bold">0</span>
                                        <button type="button" class="btn btn-sm btn-success bg-gradient">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
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