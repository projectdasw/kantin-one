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

                    {{-- Kantin --}}
                    <div class="mb-3">
                        <label for="canteen_id" class="form-label fw-semibold">
                            Kantin <span class="text-danger">*</span>
                        </label>

                        <select
                            name="canteen_id"
                            id="canteen_id"
                            class="form-select @error('canteen_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Pilih Kantin</option>

                            @foreach ($canteens as $canteen)
                                <option
                                    value="{{ $canteen->id }}"
                                    {{ old('canteen_id') == $canteen->id ? 'selected' : '' }}
                                >
                                    {{ $canteen->name }} ({{ $canteen->code }})
                                </option>
                            @endforeach
                        </select>

                        @error('canteen_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gedung --}}
                    <div class="mb-3">
                        <label for="building_id" class="form-label fw-semibold">
                            Gedung <span class="text-danger">*</span>
                        </label>

                        <select
                            name="building_id"
                            id="building_id"
                            class="form-select @error('building_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Pilih Gedung</option>

                            @foreach ($buildings as $building)
                                <option
                                    value="{{ $building->id }}"
                                    {{ old('building_id') == $building->id ? 'selected' : '' }}
                                >
                                    {{ $building->name }} ({{ $building->code }})
                                </option>
                            @endforeach
                        </select>

                        @error('building_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lantai --}}
                    <div class="mb-3">
                        <label for="floor_id" class="form-label fw-semibold">
                            Lantai <span class="text-danger">*</span>
                        </label>

                        <select
                            name="floor_id"
                            id="floor_id"
                            class="form-select @error('floor_id') is-invalid @enderror"
                            required
                            disabled
                        >
                            <option value="">Pilih gedung terlebih dahulu</option>
                        </select>

                        @error('floor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    {{-- Nama Meja --}}
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
                            maxlength="255"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Masukkan nama meja sesuai penamaan yang diinginkan.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label for="table_number" class="form-label">
                            Nomor Meja
                        </label>

                        <input
                            type="text"
                            id="table_number"
                            class="form-control"
                            value="Otomatis"
                            disabled
                        >

                        <small class="text-muted">
                            Nomor meja akan dibuat otomatis oleh sistem.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label for="capacity" class="form-label">
                            Kapasitas <span class="text-danger">*</span>
                        </label>

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

                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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