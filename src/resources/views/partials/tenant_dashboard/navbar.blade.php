<div class="d-flex flex-row justify-content-around align-items-center p-3">
    <div class="d-flex flex-row align-items-center">
        <span class="text-bg-success bg-gradient p-2 fs-5 rounded-3">
            <i class="fa-solid fa-utensils"></i>
        </span>
        <div class="ms-3">
            <h6 class="m-0" style="font-weight: 800;">
                Kantin<span class="text-success">.ONE</span>
            </h6>
            <span class="text-muted" style="font-size: 11px;">[Nama Tenant]</span>
        </div>
    </div>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.tenant')}}">
                <i class="fa-solid fa-house"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tenant.products') }}">
                <i class="fa-solid fa-cubes-stacked"></i>
                <span>Produk Kantin</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tenant.sales') }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Penjualan</span>
            </a>
        </li>
    </ul>
    <div class="dropstart">
        <ul class="dropdown-menu">
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
        <button class="btn btn-sm btn-outline-success bg-gradient d-flex justify-content-center align-items-center p-1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-chevron-left"></i>
            <div class="mx-3 text-end">
                <h6 class="fw-bold m-0">{{ auth()->user()->name }}</h6>
                <span class="small" style="font-size: 12px;">
                    [Nama Tenant]
                </span>
            </div>
            <div class="fs-6 text-bg-primary bg-gradient px-3 py-2 rounded-circle border border-1 border-light">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
        </button>
    </div>
</div>