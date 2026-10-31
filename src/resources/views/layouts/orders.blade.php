@extends('layouts.app')
@section('content')
    <div class="container-fluid d-flex flex-column justify-content-center min-vh-100">

        {{-- Offcanvas Example --}}
        <div class="offcanvas offcanvas-start w-50" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="staticBackdropLabel">Offcanvas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                I will not close if you click outside of me.
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm m-auto">
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 sticky-top">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    Toggle static offcanvas
                </button>
                <h5 class="fw-bold mb-0">Kantin.ONE</h5>
            </div>
            <div class="card-body">
                @yield('orders-content')  
            </div>
        </div>
    </div>
@endsection
