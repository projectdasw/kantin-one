@extends('layouts.app')
@section('content')
    @php
        $role = auth()->user()->role ?? '';
        $menus = match ($role) {
            'super_admin', 'administrator' => [
                [
                    'label' => 'Beranda',
                    'icon' => 'fa-solid fa-house',
                    'url' => '/dashboard',
                    'active' => ['dashboard'],
                ],
                [
                    'label' => 'Manajemen Pengguna',
                    'id' => 'management-account',
                    'icon' => 'fa-solid fa-users',
                    'active' => [
                        'users*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Master Akun',
                            'icon' => 'fa-solid fa-users',
                            'url' => route('users.index'),
                            'active' => ['users*'],
                        ],
                        [
                            'label' => 'Akun Kadaluarsa',
                            'icon' => 'fa-solid fa-users',
                            'url' => '#',
                            'active' => ['trash*'],
                        ],
                        [
                            'label' => 'Reset Password',
                            'icon' => 'fa-solid fa-users',
                            'url' => '#',
                            'active' => ['resetpassword*'],
                        ],
                    ],
                ],
                [
                    'label' => 'Manajemen Kantin Utama',
                    'id' => 'management-canteen',
                    'icon' => 'fa-solid fa-store',
                    'active' => [
                        'canteens*',
                        'buildings*',
                        'floors*',
                        'tables*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Kantin',
                            'icon' => 'fa-solid fa-store',
                            'url' => route('canteens.index'),
                            'active' => ['canteens*'],
                        ],
                        [
                            'label' => 'Gedung',
                            'icon' => 'fa-solid fa-building',
                            'url' => route('buildings.index'),
                            'active' => ['buildings*'],
                        ],
                        [
                            'label' => 'Lantai',
                            'icon' => 'fa-solid fa-layer-group',
                            'url' => route('floors.index'),
                            'active' => ['floors*'],
                        ],
                        [
                            'label' => 'Meja',
                            'icon' => 'fa-solid fa-chair',
                            'url' => route('tables.index'),
                            'active' => ['tables*'],
                        ],
                    ],
                ],
                [
                    'label' => 'Manajemen Tenant',
                    'id' => 'management-tenant',
                    'icon' => 'fa-solid fa-shop',
                    'active' => [
                        'tenants*',
                        'tenant-categories*',
                        'tenant-employees*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Data Tenant',
                            'icon' => 'fa-solid fa-store',
                            'url' => route('tenants.index'),
                            'active' => ['tenants*'],
                        ],
                        [
                            'label' => 'Kategori Tenant',
                            'icon' => 'fa-solid fa-tags',
                            'url' => '#',
                            'active' => ['tenant-categories*'],
                        ],
                        [
                            'label' => 'Pegawai Tenant',
                            'icon' => 'fa-solid fa-users',
                            'url' => '#',
                            'active' => ['tenant-employees*'],
                        ],
                    ],
                ],
                [
                    'label' => 'Manajemen Produk',
                    'id' => 'management-products',
                    'icon' => 'fa-solid fa-shop',
                    'active' => [
                        'products*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Master Menu',
                            'icon' => 'fa-solid fa-users',
                            'url' => route('products.index'),
                            'active' => ['products*'],
                        ],
                        [
                            'label' => 'Kategori Menu',
                            'icon' => 'fa-solid fa-users',
                            'url' => '#',
                            'active' => [''],
                        ],
                    ],
                ],
                [
                    'label' => 'Manajemen Stok (Segera ada)',
                    'icon' => 'fa-solid fa-chart-pie',
                    'url' => '#',
                    'active' => [''],
                ],
                [
                    'label' => 'Laporan (Segera ada)',
                    'id' => 'management-report',
                    'icon' => 'fa-solid fa-chart-pie',
                    'active' => [
                        'reports*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Saldo',
                            'icon' => 'fa-solid fa-chart-pie',
                            'url' => '#',
                            'active' => [''],
                        ],
                        [
                            'label' => 'Penjualan',
                            'icon' => 'fa-solid fa-chart-pie',
                            'url' => '#',
                            'active' => ['reports*'],
                        ],
                        [
                            'label' => 'Laba/Rugi',
                            'icon' => 'fa-solid fa-chart-pie',
                            'url' => '#',
                            'active' => [''],
                        ],
                        [
                            'label' => 'Neraca',
                            'icon' => 'fa-solid fa-chart-pie',
                            'url' => '#',
                            'active' => [''],
                        ],
                        [
                            'label' => 'Hasil Penjualan Pokok',
                            'icon' => 'fa-solid fa-chart-pie',
                            'url' => '#',
                            'active' => [''],
                        ],
                    ],
                ],
            ],

            'Pengelola Kantin', 'Kepala Pengelolaan Tenant' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'fa-solid fa-house',
                    'url' => '/dashboard',
                    'active' => ['dashboard'],
                ],
                [
                    'label' => 'Data Tenant',
                    'icon' => 'fa-solid fa-store',
                    'url' => '#',
                    'active' => ['tenants*'],
                ],
                [
                    'label' => 'Monitoring Tenant',
                    'icon' => 'fa-solid fa-chart-line',
                    'url' => '#',
                    'active' => ['monitoring*'],
                ],
                [
                    'label' => 'Laporan',
                    'icon' => 'fa-solid fa-file-lines',
                    'url' => '#',
                    'active' => ['reports*'],
                ],
            ],

            'Kepala Tenant', 'Tenant' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'fa-solid fa-house',
                    'url' => '/dashboard',
                    'active' => ['dashboard'],
                ],
                [
                    'label' => 'Produk',
                    'icon' => 'fa-solid fa-box',
                    'url' => '#',
                    'active' => ['products*'],
                ],
                [
                    'label' => 'Persediaan',
                    'icon' => 'fa-solid fa-boxes-stacked',
                    'url' => '#',
                    'active' => ['inventory*'],
                ],
                [
                    'label' => 'Transaksi',
                    'icon' => 'fa-solid fa-receipt',
                    'url' => '#',
                    'active' => ['transactions*'],
                ],
                [
                    'label' => 'Laporan',
                    'icon' => 'fa-solid fa-chart-column',
                    'url' => '#',
                    'active' => ['reports*'],
                ],
            ],

            'Pegawai Tenant' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'fa-solid fa-house',
                    'url' => '/dashboard',
                    'active' => ['dashboard'],
                ],
                [
                    'label' => 'Produk',
                    'icon' => 'fa-solid fa-box',
                    'url' => '#',
                    'active' => ['products*'],
                ],
                [
                    'label' => 'Transaksi',
                    'icon' => 'fa-solid fa-receipt',
                    'url' => '#',
                    'active' => ['transactions*'],
                ],
            ],

            default => [],
        };
    @endphp
    <div class="container-fluid bg-light vh-100">
        <div class="row h-100">
            <div class="col-2 bg-white">
                <div class="container d-flex flex-column justify-content-between h-100 py-4">
                    <div>
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="fs-4 p-2 rounded-3 me-3 text-white" style="background-color: var(--primary);">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <div>
                                <h5 class="m-0" style="font-weight: 800;">Kantin<span style="color: var(--primary);">.ONE</span></h5>
                                <span class="text-muted small">Canteen Ecosystem</span>
                            </div>
                        </div>
                        <hr>
                        <div class="list-group small">
                            <div class="list-group list-group-flush" id="sidebarMenu">
                                @foreach ($menus as $menu)
                                    @if (isset($menu['submenu']))
                                        @php
                                            $isMenuActive = request()->is(...$menu['active']);
                                        @endphp
                                        <a href="#{{ $menu['id'] }}" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center mt-1
                                            {{ $isMenuActive ? 'parent-active' : '' }} rounded-3" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isMenuActive ? 'true' : 'false' }}"
                                            aria-controls="{{ $menu['id'] }}" title="{{ $menu['label'] }}"> {{-- Menu Utama dengan Submenu --}}
                                            <div>
                                                <i class="{{ $menu['icon'] }} me-3"></i>
                                                <span>{{ $menu['label'] }}</span>
                                            </div>
                                            <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                                        </a>
                                        <div class="collapse {{ $isMenuActive ? 'show' : '' }}" id="{{ $menu['id'] }}"> {{-- Submenu --}}
                                            @foreach ($menu['submenu'] as $submenu)
                                                <a href="{{ $submenu['url'] }}" class="list-group-item list-group-item-action border-0 mt-1 submenu-link
                                                    {{ request()->is(...$submenu['active']) ? 'active' : '' }} rounded-3" title="{{ $submenu['label'] }}">
                                                    <i class="{{ $submenu['icon'] }} me-3"></i>
                                                    <span>{{ $submenu['label'] }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <a href="{{ $menu['url'] }}" class="list-group-item list-group-item-action border-0 rounded-3
                                            {{ request()->is(...$menu['active']) ? 'single-active' : '' }}" title="{{ $menu['label'] }}">
                                            <i class="{{ $menu['icon'] }} me-3"></i>
                                            <span>{{ $menu['label'] }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div>
                        <span>Kantin.ONE v1.0</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3 me-3 text-white" style="background-color: var(--dashboard-primary-subtle);">
                            <i class="fa-solid fa-bars"></i>
                        </div>
                        <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div class="navbar-breadcrumb">
                            <span>Pages</span>
                            <i class="fa-solid fa-chevron-right"></i>
                            <strong>@yield('page-title', 'Dashboard')</strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="navbar-icon-btn" aria-label="Notifikasi">
                            <i class="fa-regular fa-bell"></i>
                            <span class="notification-dot"></span>
                        </button>
                        <div class="dropdown">
                            <button class="profile-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-avatar">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="profile-info">
                                    <strong>{{ auth()->user()->name }}</strong>
                                    <small>{{ ucwords(str_replace('_', ' ', $role)) }}</small>
                                </div>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-regular fa-user me-2"></i>
                                        Profil Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf

                                        <button type="submit"
                                                class="dropdown-item text-danger">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                                            Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- Page Information --}}
                <div class="d-flex flex-column">
                    <h3 class="fw-bold">@yield('page-title')</h3>
                    <span class="text-muted">@yield('page-description')</span>
                </div>
                {{-- Page Actions --}}
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @yield('page-actions')
                </div>
                @yield('dashboard-content')
                @include('partials.footer')
            </div>
        </div>
    </div>
@endsection
