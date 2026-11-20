@extends('layouts.dashboard')

@section('title', 'Edit Meja')

@section('page-title')
    <i class="fas fa-edit me-2"></i> Edit Meja
@endsection

@section('page-description')
    Perbarui informasi meja food court.
@endsection

@section('page-actions')
    <a href="{{ route('tables.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('dashboard-content')

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Informasi Meja</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('tables.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Meja</label>
                        <input
                            type="text"
                            class="form-control bg-light"
                            value="{{ $table->code }}"
                            readonly
                        >
                        <small class="text-muted">
                            Kode meja dibuat otomatis oleh sistem.
                        </small>
                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Meja</label>
                        <input
                            type="text"
                            class="form-control bg-light"
                            value="{{ $table->table_number }}"
                            readonly
                        >
                        <small class="text-muted">
                            Nomor meja dibuat otomatis dan tidak dapat diubah.
                        </small>
                    </div>

                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            Nama Meja <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $table->name) }}"
                            maxlength="255"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Nama meja dapat diubah sesuai kebutuhan.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="capacity" class="form-label fw-semibold">
                            Kapasitas <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input
                                type="number"
                                name="capacity"
                                id="capacity"
                                class="form-control @error('capacity') is-invalid @enderror"
                                value="{{ old('capacity', $table->capacity) }}"
                                min="1"
                                max="32767"
                                required
                            >

                            <span class="input-group-text">Orang</span>

                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="location" class="form-label fw-semibold">
                            Lokasi
                        </label>

                        <input
                            type="text"
                            name="location"
                            id="location"
                            class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location', $table->location) }}"
                            maxlength="100"
                            placeholder="Contoh: Area A"
                        >

                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('tables.index') }}"
                            class="btn btn-light">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-3 mt-lg-0">
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h6 class="fw-bold mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Informasi
                </h6>

                <p class="text-muted small">
                    Perubahan informasi meja tidak akan mengubah kode
                    identitas maupun QR Token yang sudah dibuat.
                </p>

                <hr>

                <small class="text-muted">Terakhir diperbarui</small>
                <div class="fw-semibold">
                    {{ $table->updated_at->format('d M Y, H:i') }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection