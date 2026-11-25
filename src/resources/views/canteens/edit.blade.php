@extends('layouts.dashboard')

@section('page-title', 'Edit Kantin')
@section('page-description', 'Perbarui informasi master kantin.')

@section('page-actions')
    <a href="{{ route('canteens.show') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('dashboard-content')

<div class="row">
    <div class="col-xl-9 col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-1">Form Edit Kantin</h5>
                <small class="text-muted">
                    Perbarui informasi master kantin berikut.
                </small>
            </div>

            <div class="card-body">
                <form action="{{ route('canteens.update') }}"
                      method="POST"
                      id="canteenEditForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label">
                                Kode Kantin
                            </label>

                            <input type="text"
                                   id="code"
                                   class="form-control"
                                   value="{{ $canteen->code }}"
                                   disabled>

                            <small class="text-muted">
                                Kode identifikasi kantin.
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Kantin</label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $canteen->is_active ? 'Aktif' : 'Nonaktif' }}"
                                   disabled>

                            <small class="text-muted">
                                Status diubah melalui tombol pada daftar kantin.
                            </small>
                        </div>

                        <div class="col-12">
                            <label for="name" class="form-label">
                                Nama Kantin <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $canteen->name) }}"
                                   placeholder="Masukkan nama kantin"
                                   maxlength="255"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">
                                Deskripsi
                            </label>

                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Masukkan deskripsi kantin">{{ old('description', $canteen->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('canteens.show') }}" class="btn btn-light">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@vite('resources/js/pages/canteens/canteens.js')