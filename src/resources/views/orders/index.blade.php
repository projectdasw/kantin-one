@extends('layouts.orders')
@section('title', 'Pesan Kantin')
@section('orders-content')
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <h1 class="fw-bold">Pilih Kantin</h1>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="search" class="form-control" placeholder="Cari kantin..." aria-label="Cari kantin" aria-describedby="basic-addon1">
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <div class="col">
            <div class="card">
                <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="{{ asset('img-dummy/supermarket.png') }}" class="card-img-top" alt="image/png">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
    </div>
@endsection