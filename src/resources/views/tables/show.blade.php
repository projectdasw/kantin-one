@extends('layouts.dashboard')

@section('title', 'Detail Meja')

@section('page-title')
    <i class="fas fa-info-circle me-2"></i> Detail Meja
@endsection

@section('page-description')
    Informasi lengkap meja food court.
@endsection

@section('page-actions')
    <a href="{{ route('tables.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>

    <form action="{{ route('tables.select-edit') }}" method="POST">
        @csrf
        <input type="hidden" name="table_id" value="{{ $table->id }}">

        <button type="submit" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit Meja
        </button>
    </form>
@endsection

@section('dashboard-content')

<div class="row g-4">

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Informasi Meja</h5>
            </div>

            <div class="card-body">
                <div class="row g-4">

                    <div class="col-md-6">
                        <small class="text-muted">Kode Meja</small>
                        <h5 class="fw-bold mt-1">{{ $table->code }}</h5>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Nama Meja</small>
                        <h5 class="fw-bold mt-1">{{ $table->name }}</h5>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Kapasitas</small>
                        <h5 class="fw-bold mt-1">
                            <i class="fas fa-users text-primary me-1"></i>
                            {{ $table->capacity }} Orang
                        </h5>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Lokasi</small>
                        <h5 class="fw-bold mt-1">
                            {{ $table->location ?: 'Belum ditentukan' }}
                        </h5>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Status</small>
                        <div class="mt-2">
                            @if ($table->is_active)
                                <span class="badge bg-success fs-6">Aktif</span>
                            @else
                                <span class="badge bg-secondary fs-6">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Dibuat Pada</small>
                        <h6 class="fw-semibold mt-2">
                            {{ $table->created_at->format('d M Y, H:i') }}
                        </h6>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="fas fa-qrcode fa-3x text-primary mb-3"></i>

                <h5 class="fw-bold">QR Code Meja</h5>

                <p class="text-muted small">
                    QR Code akan tersedia setelah integrasi
                    pemesanan pelanggan berbasis meja selesai.
                </p>

                <span class="badge bg-warning text-dark">
                    Belum Terintegrasi
                </span>
            </div>
        </div>
    </div>

</div>

@endsection