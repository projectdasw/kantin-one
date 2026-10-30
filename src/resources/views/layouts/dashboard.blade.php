@extends('layouts.app')
@section('content')
<div class="dashboard-wrapper">

    @include('partials.sidebar')

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main class="dashboard-main">

        @include('partials.navbar')

        <div class="dashboard-content">

            <div class="page-heading">
                <h1>@yield('page-title', 'Dashboard')</h1>

                <p>
                    @yield('page-description', 'Selamat datang di Kantin.ONE Management System.')
                </p>
            </div>

            <div class="flex-grow-1">
                @yield('dashboard-content')
            </div>

            @include('partials.footer')

        </div>

    </main>

</div>
@endsection
