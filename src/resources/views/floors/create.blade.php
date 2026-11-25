@extends('layouts.dashboard')

@section('page-title', 'Tambah Lantai')
@section('page-description', 'Tambahkan data lantai pada gedung yang tersedia.')

@section('page-actions')
    <a href="{{ route('floors.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-1">Form Tambah Lantai</h5>
        <small class="text-muted">
            Lengkapi informasi lantai berikut.
        </small>
    </div>

    <div class="card-body">
        <form action="{{ route('floors.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="building_id" class="form-label">
                        Gedung <span class="text-danger">*</span>
                    </label>

                    <select name="building_id"
                            id="building_id"
                            class="form-select @error('building_id') is-invalid @enderror"
                            required>
                        <option value="">Pilih Gedung</option>

                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"
                                {{ old('building_id') === $building->id ? 'selected' : '' }}>
                                {{ $building->code }} - {{ $building->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('building_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="code" class="form-label">
                        Kode Lantai <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="code"
                           id="code"
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code') }}"
                           maxlength="30"
                           placeholder="Contoh: L1"
                           required>

                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="name" class="form-label">
                        Nama Lantai <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           maxlength="255"
                           placeholder="Contoh: Lantai 1"
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
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Keterangan tambahan (opsional)">{{ old('description') }}</textarea>

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
                    <i class="fas fa-save me-1"></i> Simpan Lantai
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@vite('resources/js/pages/floors/floors.js')