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
    <ul class="nav nav-pills small">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.index')}}">
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tenant.products') }}">
                <span>Riwayat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tenant.sales') }}">
                <span>Lacak Pesanan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn border border-1 rounded-3 text-white" href="{{ route('customer.cart') }}"
                style="background-color: var(--primary);">
                <i class="fa-solid fa-basket-shopping"></i>
                <span class="mx-2">Keranjang</span>
                <span class="badge text-bg-light">4</span>
            </a>
        </li>
    </ul>
</div>