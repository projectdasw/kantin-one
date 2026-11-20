@extends('layouts.dashboard')

@section('page-title', 'Detail Lantai')
@section('page-description', 'Informasi lengkap lantai yang terdaftar.')

@section('page-actions')
    <a href="{{ route('floors.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>

    <form action="{{ route('floors.edit.select') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="floor_id" value="{{ $floor->id }}">

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Lantai
        </button>
    </form>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-1">Informasi Lantai</h5>
        <small class="text-muted">
            Detail data lantai dan gedung terkait.
        </small>
    </div>

    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="text-muted small">Kode Lantai</label>
                <div class="fw-semibold">{{ $floor->code }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Nama Lantai</label>
                <div class="fw-semibold">{{ $floor->name }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Gedung</label>
                <div class="fw-semibold">{{ $floor->building->name }}</div>
                <small class="text-muted">{{ $floor->building->code }}</small>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Status</label>
                <div>
                    @if ($floor->is_active)
                        <span class="badge bg-success-subtle text-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <label class="text-muted small">Deskripsi</label>
                <div>{{ $floor->description ?: '-' }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Tanggal Dibuat</label>
                <div>{{ $floor->created_at?->format('d M Y, H:i') }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Terakhir Diperbarui</label>
                <div>{{ $floor->updated_at?->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>
</div>

@endsection