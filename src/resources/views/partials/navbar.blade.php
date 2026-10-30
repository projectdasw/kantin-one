
<header class="dashboard-navbar">

    <div class="d-flex align-items-center gap-3">

        <button type="button"
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Toggle Sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="navbar-breadcrumb">
            <span>Pages</span>
            <i class="fa-solid fa-chevron-right"></i>
            <strong>@yield('page-title', 'Dashboard')</strong>
        </div>

    </div>

    <div class="d-flex align-items-center gap-3">

        <button type="button" class="navbar-icon-btn"
                aria-label="Notifikasi">
            <i class="fa-regular fa-bell"></i>
            <span class="notification-dot"></span>
        </button>

        <div class="dropdown">

            <button class="profile-dropdown"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>

                <div class="profile-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ auth()->user()->role }}</small>
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

</header>
