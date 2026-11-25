@extends('layouts.dashboard')

@section('page-title', 'Detail Kantin')
@section('page-description', 'Informasi lengkap master kantin Kantin.ONE.')

@section('page-actions')
    <a href="{{ route('canteens.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>

    <form action="{{ route('canteens.select-edit') }}" method="POST">
        @csrf
        <input type="hidden" name="canteen_id" value="{{ $canteen->id }}">

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Kantin
        </button>
    </form>
@endsection

@section('dashboard-content')

<div class="row g-4">
    <div class="col-xl-8 col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Informasi Kantin</h5>
            </div>

            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-1">{{ $canteen->name }}</h4>
                        <span class="text-muted">
                            Kode: {{ $canteen->code }}
                        </span>
                    </div>

                    @if ($canteen->is_active)
                        <span class="badge bg-success-subtle text-success fs-6">
                            <i class="fas fa-check-circle me-1"></i> Aktif
                        </span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary fs-6">
                            <i class="fas fa-ban me-1"></i> Nonaktif
                        </span>
                    @endif
                </div>

                <hr>

                <div class="row g-4">
                    <div class="col-12">
                        <small class="text-muted d-block mb-1">
                            <i class="fas fa-store me-1"></i> Nama Kantin
                        </small>
                        <span class="fw-medium">{{ $canteen->name }}</span>
                    </div>

                    <div class="col-12">
                        <small class="text-muted d-block mb-1">
                            <i class="fas fa-align-left me-1"></i> Deskripsi
                        </small>

                        <div class="text-body">
                            @if ($canteen->description)
                                {!! nl2br(e($canteen->description)) !!}
                            @else
                                <span class="text-muted">Belum ada deskripsi.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-primary-subtle text-primary p-3 me-3">
                        <i class="fas fa-barcode fa-lg"></i>
                    </div>

                    <div>
                        <small class="text-muted d-block">Kode Identifikasi</small>
                        <h4 class="mb-0">{{ $canteen->code }}</h4>
                    </div>
                </div>

                <hr>

                <small class="text-muted d-block mb-1">Tanggal Dibuat</small>
                <span>{{ $canteen->created_at?->format('d/m/Y H:i') ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>

@endsection

@vite('resources/js/pages/canteens/canteens.js')