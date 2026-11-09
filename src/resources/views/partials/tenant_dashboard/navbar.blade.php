<div class="row justify-content-around align-items-center p-3">
    <div class="col-4 d-flex align-items-start">
        <span class="text-bg-success bg-gradient p-2 fs-4 rounded-3">
            <i class="fa-solid fa-utensils"></i>
        </span>
        <div class="ms-3">
            <h5 class="m-0" style="font-weight: 800;">
                Kantin<span class="text-success">.ONE</span>
            </h5>
            <span class="text-muted small" style="font-size: 12px;">[Nama Tenant]</span>
        </div>
    </div>
    <div class="col-4 d-flex justify-content-end">
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
            <button class="btn btn-outline-success bg-gradient d-flex justify-content-center align-items-center p-2" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-chevron-left"></i>
                <div class="mx-3 text-end">
                    <h6 class="fw-bold m-0">{{ auth()->user()->name }}</h6>
                    <span class="small" style="font-size: 12px;">
                        [Nama Tenant]
                    </span>
                </div>
                <div class="fs-5 text-bg-primary bg-gradient px-3 py-2 rounded-5 border border-1 border-light">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </button>
        </div>
    </div>    
</div>