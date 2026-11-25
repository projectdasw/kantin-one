@extends('layouts.dashboard')

@section('page-title', 'Tambah Kantin')
@section('page-description', 'Tambahkan master lokasi kantin baru.')

@section('page-actions')
    <a href="{{ route('canteens.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('dashboard-content')

<div class="row">
    <div class="col-xl-9 col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-1">Form Tambah Kantin</h5>
                <small class="text-muted">
                    Lengkapi informasi master kantin berikut.
                </small>
            </div>

            <div class="card-body">
                <form action="{{ route('canteens.store') }}"
                      method="POST"
                      id="canteenCreateForm">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label">
                                Kode Kantin <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="code"
                                   id="code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   value="{{ old('code') }}"
                                   placeholder="Contoh: FC"
                                   maxlength="30"
                                   required>

                            <small class="text-muted">
                                Kode unik untuk identifikasi kantin.
                            </small>

                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                Nama Kantin <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Contoh: Food Court"
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
                                      placeholder="Masukkan deskripsi kantin">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('canteens.index') }}" class="btn btn-light">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Kantin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@vite('resources/js/pages/canteens/canteens.js')