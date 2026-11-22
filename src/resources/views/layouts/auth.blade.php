<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Authentication') | Kantin.ONE</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body>
        <div class="container-fluid auth-panel vh-100 p-0">
            <div class="container h-100">
                <div class="row h-100 py-5">
                    <div class="col d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="fs-4 p-2 rounded-4 me-3" style="background-color: #ffffff2a;">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <div>
                                <h4 class="m-0" style="font-weight: 800;">Kantin<span style="color: var(--login-text-logo);">.ONE</span></h4>
                                <span class="small" style="color: var(--login-text-description);">Smart Canteen Management</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <h1 class="display-5" style="font-weight: 800;">
                                Manage Your <br>
                                <span style="color: var(--login-text-logo);">Canteen</span> Smarter
                            </h1>
                            <span class="small w-75" style="color: var(--login-text-description);">
                                Kelola operasional kantin dengan lebih mudah, terstruktur, dan efisien melalui satu platform manajemen terintegrasi
                            </span>
                            <div class="d-flex justify-content-start mt-3">
                                <div class="fs-3 p-3 rounded-4 me-3 bg-primary bg-gradient shadow">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <div class="fs-3 p-3 rounded-4 me-3 bg-success bg-gradient shadow">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <div class="fs-3 p-3 rounded-4 me-3 bg-danger bg-gradient shadow">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="small" style="color: var(--login-text-description);">
                                &copy; {{ date('Y') }} Kantin.ONE. All rights reserved.
                            </span>
                        </div>
                    </div>
                    <div class="col d-flex flex-column justify-content-center">
                        @yield('auth-content')
                    </div>
                </div>
            </div>
        </div>
    </body>
    
    @stack('scripts')
</html>
