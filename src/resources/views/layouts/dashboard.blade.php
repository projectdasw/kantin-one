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
                    'icon' => 'fa-solid fa-house-user',
                    'active' => [
                        'users*',
                        'activity-logs*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Master Akun',
                            'icon' => 'fa-solid fa-users',
                            'url' => route('users.index'),
                            'active' => ['users'],
                        ],
                        [
                            'label' => 'Tambah Akun',
                            'icon' => 'fa-solid fa-user-plus',
                            'url' => route('users.create'),
                            'active' => ['users/create'],
                        ],
                        [
                            'label' => 'Akun Kadaluarsa',
                            'icon' => 'fa-solid fa-person-circle-exclamation',
                            'url' => route('users.trash'),
                            'active' => ['users/trash'],
                        ],
                        [
                            'label' => 'Reset Password',
                            'icon' => 'fa-solid fa-user-shield',
                            'url' => route('users.reset-password-user'),
                            'active' => ['users/reset_password_user'],
                        ],
                        [
                            'label' => 'Histori Akun',
                            'icon' => 'fa-solid fa-clock-rotate-left',
                            'url' => route('activity-logs.index'),
                            'active' => ['activity-logs'],
                        ],
                    ],
                ],
                [
                    'label' => 'Manajemen Kantin Utama',
                    'id' => 'management-canteen',
                    'icon' => 'fa-solid fa-landmark',
                    'active' => [
                        'buildings*',
                        'floors*',
                        'canteens*',
                        'tables*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Gedung/Lahan',
                            'id' => 'submenu-buildings',
                            'icon' => 'fa-solid fa-building',
                            'active' => ['buildings*'],
                            'submenu' => [
                                [
                                    'label' => 'Master Gedung/Lahan',
                                    'icon' => 'fa-solid fa-list',
                                    'url' => route('buildings.index'),
                                    'active' => ['buildings'],
                                ],
                                [
                                    'label' => 'Tambah Gedung/Lahan',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => route('buildings.create'),
                                    'active' => ['buildings/create'],
                                ],
                                [
                                    'label' => 'Gedung/Lahan Nonaktif',
                                    'icon' => 'fa-solid fa-building-circle-xmark',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Pemulihan Gedung/Lahan',
                                    'icon' => 'fa-solid fa-building-shield',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                        [
                            'label' => 'Kantin',
                            'id' => 'submenu-canteens',
                            'icon' => 'fa-solid fa-shop',
                            'active' => ['canteens*'],
                            'submenu' => [
                                [
                                    'label' => 'Master Kantin',
                                    'icon' => 'fa-solid fa-list',
                                    'url' => route('canteens.index'),
                                    'active' => ['canteens'],
                                ],
                                [
                                    'label' => 'Tambah Kantin',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => route('canteens.create'),
                                    'active' => ['canteens/create'],
                                ],
                                [
                                    'label' => 'Kantin Nonaktif',
                                    'icon' => 'fa-solid fa-shop-slash',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Pemulihan Kantin',
                                    'icon' => 'fa-solid fa-shield-halved',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                        [
                            'label' => 'Meja',
                            'id' => 'submenu-tables',
                            'icon' => 'fa-solid fa-chair',
                            'active' => ['tables*'],
                            'submenu' => [
                                [
                                    'label' => 'Master Meja',
                                    'icon' => 'fa-solid fa-list',
                                    'url' => route('tables.index'),
                                    'active' => ['tables'],
                                ],
                                [
                                    'label' => 'Tambah Meja',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => route('tables.create'),
                                    'active' => ['tables/create'],
                                ],
                                [
                                    'label' => 'Meja Nonaktif',
                                    'icon' => 'fa-solid fa-ban',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Pemulihan Meja',
                                    'icon' => 'fa-solid fa-shield-halved',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Manajemen Outlet',
                    'id' => 'management-tenant',
                    'icon' => 'fa-solid fa-tents',
                    'active' => [
                        'tenants*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Outlet',
                            'id' => 'submenu-tenants',
                            'icon' => 'fa-solid fa-store',
                            'active' => [
                                'tenants',
                                'tenants/create'
                            ],
                            'submenu' => [
                                [
                                    'label' => 'Master Outlet',
                                    'icon' => 'fa-solid fa-list',
                                    'url' => route('tenants.index'),
                                    'active' => ['tenants'],
                                ],
                                [
                                    'label' => 'Tambah Outlet',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => route('tenants.create'),
                                    'active' => ['tenants/create'],
                                ],
                                [
                                    'label' => 'Outlet Nonaktif',
                                    'icon' => 'fa-solid fa-store-slash',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Pemulihan Outlet',
                                    'icon' => 'fa-solid fa-shield-halved',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                        [
                            'label' => 'Kategori Outlet',
                            'id' => 'submenu-category',
                            'icon' => 'fa-solid fa-layer-group',
                            'active' => ['tenants/category'],
                            'submenu' => [
                                [
                                    'label' => 'Master Kategori',
                                    'icon' => 'fa-solid fa-list',
                                    'url' => '#' ,
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Tambah Kategori',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Kategori Nonaktif',
                                    'icon' => 'fa-solid fa-ban',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Pemulihan Kategori',
                                    'icon' => 'fa-solid fa-shield-halved',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Manajemen Produk',
                    'id' => 'management-products',
                    'icon' => 'fa-solid fa-cubes-stacked',
                    'active' => [
                        'products*',
                    ],
                    'submenu' => [
                        [
                            'label' => 'Menu',
                            'id' => 'submenu-products',
                            'icon' => 'fa-solid fa-utensils',
                            'active' => [
                                'products',
                                'products/create'
                            ],
                            'submenu' => [
                                [
                                    'label' => 'Master Menu',
                                    'icon' => 'fa-solid fa-list',
                                    'url' => route('products.index'),
                                    'active' => ['products'],
                                ],
                                [
                                    'label' => 'Tambah Menu',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => route('products.create'),
                                    'active' => ['products/create'],
                                ],
                                [
                                    'label' => 'Ketersediaan Menu',
                                    'icon' => 'fa-solid fa-champagne-glasses',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Pemulihan Menu',
                                    'icon' => 'fa-solid fa-shield-halved',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                        [
                            'label' => 'Etalase',
                            'id' => 'submenu-display-menu',
                            'icon' => 'fa-solid fa-store',
                            'active' => [
                                'display-menu',
                                'display-menu/create'
                            ],
                            'submenu' => [
                                [
                                    'label' => 'Master Etalase',
                                    'icon' => 'fa-solid fa-store',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Tambah Etalase',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                        [
                            'label' => 'Kategori',
                            'id' => 'submenu-category',
                            'icon' => 'fa-solid fa-store',
                            'active' => [
                                'category',
                                'category/create'
                            ],
                            'submenu' => [
                                [
                                    'label' => 'Master Kategori',
                                    'icon' => 'fa-solid fa-store',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                                [
                                    'label' => 'Tambah Kategori',
                                    'icon' => 'fa-solid fa-plus',
                                    'url' => '#',
                                    'active' => [''],
                                ],
                            ],
                        ],
                    ],
                ],
                // [
                //     'label' => 'Manajemen Stok (Segera ada)',
                //     'icon' => 'fa-solid fa-chart-pie',
                //     'url' => '#',
                //     'active' => [''],
                // ],
                // [
                //     'label' => 'Laporan (Segera ada)',
                //     'id' => 'management-report',
                //     'icon' => 'fa-solid fa-chart-pie',
                //     'active' => [
                //         'reports*',
                //     ],
                //     'submenu' => [
                //         [
                //             'label' => 'Saldo',
                //             'icon' => 'fa-solid fa-chart-pie',
                //             'url' => '#',
                //             'active' => [''],
                //         ],
                //         [
                //             'label' => 'Penjualan',
                //             'icon' => 'fa-solid fa-chart-pie',
                //             'url' => '#',
                //             'active' => ['reports*'],
                //         ],
                //         [
                //             'label' => 'Laba/Rugi',
                //             'icon' => 'fa-solid fa-chart-pie',
                //             'url' => '#',
                //             'active' => [''],
                //         ],
                //         [
                //             'label' => 'Neraca',
                //             'icon' => 'fa-solid fa-chart-pie',
                //             'url' => '#',
                //             'active' => [''],
                //         ],
                //         [
                //             'label' => 'Hasil Penjualan Pokok',
                //             'icon' => 'fa-solid fa-chart-pie',
                //             'url' => '#',
                //             'active' => [''],
                //         ],
                //     ],
                // ],
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
            <div class="col-3 bg-white">
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
                                                @if (isset($submenu['submenu']))
                                                    @php
                                                        $isSubmenuActive = request()->is(...$submenu['active']);
                                                    @endphp
                                                    <a href="#{{ $submenu['id'] }}" class="list-group-item list-group-item-action border-0
                                                        d-flex justify-content-between align-items-center mt-1 submenu-link
                                                        {{ $isSubmenuActive ? 'active' : '' }} rounded-3" data-bs-toggle="collapse" role="button"
                                                        aria-expanded="{{ $isSubmenuActive ? 'true' : 'false' }}" aria-controls="{{ $submenu['id'] }}"
                                                        title="{{ $submenu['label'] }}"> {{-- Submenu yang memiliki submenu lagi --}}
                                                        <div>
                                                            <i class="{{ $submenu['icon'] }} me-3"></i>
                                                            <span>{{ $submenu['label'] }}</span>
                                                        </div>
                                                        <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                                                    </a>
                                                    <div class="collapse {{ $isSubmenuActive ? 'show' : '' }}" id="{{ $submenu['id'] }}"> {{-- Submenu tingkat berikutnya --}}
                                                        @foreach ($submenu['submenu'] as $child)
                                                            <a href="{{ $child['url'] }}" class="list-group-item list-group-item-action border-0 mt-1 nested-submenu-link
                                                                {{ request()->is(...$child['active']) ? 'active' : '' }} rounded-3" title="{{ $child['label'] }}">
                                                                <i class="{{ $child['icon'] }} me-3"></i>
                                                                <span>{{ $child['label'] }}</span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    {{-- Submenu biasa --}}
                                                    <a href="{{ $submenu['url'] }}" class="list-group-item list-group-item-action border-0 mt-1 submenu-link
                                                        {{ request()->is(...$submenu['active']) ? 'active' : '' }} rounded-3" title="{{ $submenu['label'] }}">
                                                        <i class="{{ $submenu['icon'] }} me-3"></i>
                                                        <span>{{ $submenu['label'] }}</span>
                                                    </a>
                                                @endif
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
            <div class="col d-flex flex-column gap-3 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center bg-white shadow-sm p-3 rounded-3">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded-3 me-3 text-white" style="background-color: var(--dashboard-primary-subtle);">
                            <i class="fa-solid fa-bars"></i>
                        </div>
                        <nav class="text-muted small" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    @yield('page-title', 'Dashboard')
                                </li>
                            </ol>
                        </nav>
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
                <div class="d-flex justify-content-between align-items-center">
                    {{-- Page Information --}}
                    <div class="d-flex flex-column">
                        <h3 class="fw-bold">@yield('page-title')</h3>
                        <span class="text-muted">@yield('page-description')</span>
                    </div>
                    {{-- Page Actions --}}
                    <div class="d-flex align-items-center">
                        @yield('page-actions')
                    </div>
                </div>
                <div class="container-fluid d-flex flex-column gap-3 p-0">
                    @yield('button-list')
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary-subtle border-0"></div>
                        <div class="card-body">@yield('dashboard-content')</div>
                    </div>
                </div>
                @include('partials.footer')
            </div>
        </div>
    </div>
@endsection
