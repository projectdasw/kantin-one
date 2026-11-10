<div class="d-flex flex-row justify-content-around align-items-center p-3">
    <div class="d-flex flex-row align-items-center">
        <span class="p-2 fs-5 rounded-3 text-white" style="background-color: var(--primary);">
            <i class="fa-solid fa-utensils"></i>
        </span>
        <div class="ms-2">
            <h5 class="m-0" style="font-weight: 800;">
                Kantin<span class="text-primary">.ONE</span>
            </h5>
        </div>
    </div>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.tenant')}}">
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tenant.products') }}">
                <span>Riwayat Pesanan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tenant.sales') }}">
                <span>Track Pesanan</span>
            </a>
        </li>
    </ul>
</div>