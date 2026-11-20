@extends('layouts.dashboard')

@section('title', 'Tambah Meja')

@section('page-title')
    <i class="fas fa-plus-circle me-2"></i> Tambah Meja
@endsection

@section('page-description')
    Tambahkan meja baru ke area food court.
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
                <h5 class="mb-0 fw-bold">Informasi Meja</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('tables.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            Nama Meja <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Meja A1"
                            maxlength="100"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                value="{{ old('capacity', 4) }}"
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
                            value="{{ old('location') }}"
                            placeholder="Contoh: Area A"
                            maxlength="100"
                        >

                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Lokasi bersifat opsional.
                        </small>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('tables.index') }}"
                            class="btn btn-light">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Meja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-3 mt-lg-0">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-primary mb-3">
                    <i class="fas fa-qrcode fa-2x"></i>
                </div>

                <h6 class="fw-bold">Informasi QR Meja</h6>

                <p class="text-muted small mb-0">
                    Kode meja dan QR Token akan dibuat secara otomatis
                    setelah meja berhasil disimpan. QR dapat digunakan
                    pelanggan untuk mengakses pemesanan berdasarkan meja.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection