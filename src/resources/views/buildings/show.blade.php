@extends('layouts.dashboard')

@section('page-title', 'Detail Gedung')
@section('page-description', 'Informasi lengkap gedung yang terdaftar.')

@section('page-actions')
    <a href="{{ route('buildings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>

    <a href="{{ route('buildings.edit') }}" class="btn btn-primary">
        <i class="fas fa-edit me-1"></i> Edit Gedung
    </a>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-1">{{ $building->name }}</h5>
        <small class="text-muted">Informasi Master Gedung</small>
    </div>

    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label text-muted">Kode Gedung</label>
                <div class="fw-semibold">{{ $building->code }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted">Nama Gedung</label>
                <div class="fw-semibold">{{ $building->name }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted">Status</label>
                <div>
                    @if ($building->is_active)
                        <span class="badge bg-success-subtle text-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted">Tanggal Dibuat</label>
                <div>{{ $building->created_at?->format('d M Y H:i') ?? '-' }}</div>
            </div>

            <div class="col-12">
                <label class="form-label text-muted">Deskripsi</label>
                <div>{{ $building->description ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>

@endsection

@vite('resources/js/pages/buildings/buildings.js')