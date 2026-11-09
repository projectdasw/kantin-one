@extends('layouts.app')
@section('content')
    @php
        $role = auth()->user()->role ?? '';
    @endphp
    
    <div class="container-fluid p-0 mb-4">
        <div class="sticky-top bg-white">
            @include('partials.tenant_dashboard.navbar')
        </div>
        <div class="container p-0">
            <div class="row justify-content-around align-items-center p-3">
                <div class="col-6 d-flex align-items-start">
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
                <div class="col-6 d-flex justify-content-end gap-2">
                    @yield('buttonlist_dashboard')
                    @yield('buttonlist_products')
                    @yield('buttonlist_sales')
                </div>
            </div>
        </div>

        <div class="container-fluid">
            @yield('tenant-dashboard-content')
        </div>
    </div>
@endsection
