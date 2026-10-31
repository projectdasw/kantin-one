<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Authentication') | Kantin.ONE</title>
        <meta name="theme-color" content="#172554">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body>
        <main class="auth-wrapper">
            <div class="auth-container">

                {{-- BRANDING --}}
                <section class="auth-brand-panel">
                    <div class="auth-brand-logo">
                        <div class="auth-logo-icon">
                            <i class="fa-solid fa-utensils"></i>
                        </div>
                        <div>
                            <div class="auth-logo-name">
                                Kantin<span>.ONE</span>
                            </div>
                            <small class="auth-logo-subtitle">
                                MANAGEMENT SYSTEM
                            </small>
                        </div>
                    </div>
                    <div class="auth-brand-content">
                        <span class="auth-brand-badge">
                            SMART CANTEEN MANAGEMENT
                        </span>
                        <h1> Manage Your <span>Canteen</span> Smarter.</h1>
                        <p>
                            Kelola operasional kantin dengan lebih mudah,
                            terstruktur, dan efisien melalui satu platform
                            manajemen terintegrasi.
                        </p>
                        <div class="auth-brand-illustration">
                            <div class="auth-illustration-item">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <div class="auth-illustration-item">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div class="auth-illustration-item">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="auth-brand-footer">
                        &copy; {{ date('Y') }} Kantin.ONE. All rights reserved.
                    </div>
                </section>

                {{-- AUTHENTICATION CONTENT --}}
                <section class="auth-form-panel">
                    <div class="auth-form-header">
                        <h2>@yield('auth-heading', 'Welcome Back!')</h2>
                        <p>@yield('auth-description', 'Silakan masuk untuk melanjutkan ke sistem Kantin.ONE.')</p>
                    </div>
                    <div class="auth-form-body">
                        @yield('auth-content')
                    </div>
                    <div class="auth-form-footer">
                        Kantin.ONE Management System
                    </div>
                </section>
            </div>
        </main>
        @stack('scripts')
    </body>
</html>
