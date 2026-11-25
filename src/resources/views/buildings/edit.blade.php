@extends('layouts.dashboard')

@section('page-title', 'Edit Gedung')
@section('page-description', 'Perbarui informasi gedung yang terdaftar.')

@section('page-actions')
    <a href="{{ route('buildings.show') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-1">Form Edit Gedung</h5>
        <small class="text-muted">
            Perbarui informasi gedung berikut.
        </small>
    </div>

    <div class="card-body">
        <form action="{{ route('buildings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="code" class="form-label">Kode Gedung</label>

                <input type="text"
                       id="code"
                       class="form-control"
                       value="{{ $building->code }}"
                       disabled>

                <small class="text-muted">
                    Kode gedung tidak dapat diubah.
                </small>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">
                    Nama Gedung <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="name"
                       id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $building->name) }}"
                       maxlength="255"
                       required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>

                <textarea name="description"
                          id="description"
                          rows="3"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $building->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('buildings.show') }}" class="btn btn-light">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@vite('resources/js/pages/buildings/buildings.js')