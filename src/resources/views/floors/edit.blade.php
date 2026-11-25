@extends('layouts.dashboard')

@section('page-title', 'Edit Lantai')
@section('page-description', 'Perbarui informasi lantai yang terdaftar.')

@section('page-actions')
    <a href="{{ route('floors.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-1">Form Edit Lantai</h5>
        <small class="text-muted">
            Perbarui nama dan deskripsi lantai.
        </small>
    </div>

    <div class="card-body">
        <form action="{{ route('floors.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Gedung</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $floor->building->code }} - {{ $floor->building->name }}"
                           disabled>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kode Lantai</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $floor->code }}"
                           disabled>

                    <div class="form-text">
                        Kode lantai tidak dapat diubah setelah dibuat.
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="name" class="form-label">
                        Nama Lantai <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $floor->name) }}"
                           maxlength="255"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="description" class="form-label">Deskripsi</label>

                    <textarea name="description"
                              id="description"
                              rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $floor->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('floors.index') }}" class="btn btn-light">
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

@vite('resources/js/pages/floors/floors.js')