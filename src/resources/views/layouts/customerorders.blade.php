@extends('layouts.app')
@section('content')
    <div class="container p-0">
        @include('partials.customer.navbar')
    </div>

    <div class="container p-0 mt-5">
        @yield('customer-content')
    </div>
@endsection
