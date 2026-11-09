@extends('layouts.app')
@section('content')
    @php
        $role = auth()->user()->role ?? '';
    @endphp
    
    <div class="container vh-100 d-flex flex-column justify-content-center p-0">
        <div class="container bg-white">
            @include('partials.tenant_dashboard.navbar')
            <hr class="m-0">
        </div>
        <div class="container p-2 bg-white">
            <div class="row justify-content-around align-items-center p-3">
                <div class="col-5 d-flex align-items-start">
                    <span class="text-bg-primary bg-gradient p-2 fs-4 rounded-3">
                        <i class="fa-solid fa-store"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="m-0" style="font-weight: 800;">@yield('page-title')</h5>
                        <span class="text-muted small" style="font-size: 12px;">
                            @yield('page-description')
                        </span>
                    </div>
                </div>
                <div class="col-5 d-flex justify-content-end">
                    @yield('buttonlist_dashboard')
                    @yield('buttonlist_products')
                    @yield('buttonlist_sales')
                </div>
            </div>
        </div>

        <div class="container px-5 pb-5 bg-white">
            @yield('tenant-dashboard-content')
        </div>
    </div>
@endsection
