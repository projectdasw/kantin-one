@extends('layouts.tenantdashboard')
@section('title', 'Monitoring Meja')
@section('page-title', 'Monioring Meja')
@section('page-description', 'Pantau informasi dan status meja food court.')
@section('tenant-dashboard-content')
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Meja</small>
                        <h3 class="fw-bold mb-0">{{ $tables->total() }}</h3>
                    </div>
                    <i class="fas fa-table fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Informasi Monitoring
                </h6>
                <p class="text-muted small mb-0">
                    Halaman ini digunakan untuk memantau data meja.
                    Pengelolaan meja hanya dapat dilakukan oleh
                    Super Admin dan Administrator.
                </p>
            </div>
        </div>
    </div>

</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">Daftar Meja Food Court</h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Meja</th>
                        <th>Nama Meja</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tables as $table)
                        <tr>
                            <td>{{ $tables->firstItem() + $loop->index }}</td>

                            <td>
                                <span class="badge bg-dark">
                                    {{ $table->code }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                {{ $table->name }}
                            </td>

                            <td>
                                <i class="fas fa-users text-muted me-1"></i>
                                {{ $table->capacity }} Orang
                            </td>

                            <td>{{ $table->location ?: '-' }}</td>

                            <td>
                                @if ($table->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-table fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">
                                    Belum ada data meja.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($tables->hasPages())
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $tables->firstItem() }}–{{ $tables->lastItem() }}
                    dari {{ $tables->total() }} meja
                </small>

                {{ $tables->links() }}
            </div>
        @endif

    </div>
</div>

@endsection