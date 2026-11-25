@extends('layouts.dashboard')

@section('page-title', 'Tambah Gedung')
@section('page-description', 'Tambahkan data gedung baru ke Kantin.ONE.')

@section('page-actions')
    <a href="{{ route('buildings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-1">Form Tambah Gedung</h5>
        <small class="text-muted">
            Lengkapi informasi gedung berikut.
        </small>
    </div>

    <div class="card-body">
        <form action="{{ route('buildings.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="code" class="form-label">
                    Kode Gedung <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="code"
                       id="code"
                       class="form-control @error('code') is-invalid @enderror"
                       value="{{ old('code') }}"
                       placeholder="Contoh: GA"
                       maxlength="30"
                       required>

                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-muted">
                    Gunakan kode unik untuk setiap gedung.
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
                       value="{{ old('name') }}"
                       placeholder="Contoh: Gedung A"
                       maxlength="255"
                       required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">
                    Deskripsi
                </label>

                <textarea name="description"
                          id="description"
                          rows="3"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Deskripsi tambahan (opsional)">{{ old('description') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('buildings.index') }}" class="btn btn-light">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Gedung
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@vite('resources/js/pages/buildings/buildings.js')