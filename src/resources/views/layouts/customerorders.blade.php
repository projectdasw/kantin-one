@extends('layouts.app')
@section('content')
    <div class="container-fluid p-0 sticky-top bg-white">
        @include('partials.customer.navbar')
    </div>

    <div class="container p-0 mt-4">
        @yield('customer-content')
    </div>
@endsection
