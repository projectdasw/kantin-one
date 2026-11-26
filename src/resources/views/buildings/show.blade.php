@extends('layouts.dashboard')
@section('page-title', 'Detail Gedung')
@section('page-description', 'Informasi lengkap gedung yang terdaftar.')
@section('page-actions')
    <a href="{{ route('buildings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>

    <a href="{{ route('buildings.edit') }}" class="btn btn-primary">
        <i class="fas fa-edit me-1"></i> Edit Gedung
    </a>
@endsection
@section('dashboard-content')
    {{-- Bootstrap Modal Lantai --}}
    {{-- Modal Tambah Lantai --}}
    <div class="modal fade" id="addFloorModal" tabindex="-1" aria-labelledby="addFloorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('buildings.floors.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="addFloorModalLabel">
                            Tambah Lantai
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="floor_code" class="form-label">
                                Kode Lantai <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="floor_code" name="code"
                                placeholder="Contoh: L1" required maxlength="30">
                        </div>
                        <div class="mb-3">
                            <label for="floor_name" class="form-label">
                                Nama Lantai <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="floor_name" name="name"
                                placeholder="Contoh: Lantai 1" required maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="floor_description" class="form-label">
                                Deskripsi
                            </label>
                            <textarea class="form-control" id="floor_description" name="description"
                                rows="3" placeholder="Deskripsi lantai (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Lantai --}}
    @foreach ($building->floors as $floor)
        <div class="modal fade" id="editFloorModal-{{ $floor->id }}" tabindex="-1"
            aria-labelledby="editFloorModalLabel-{{ $floor->id }}" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('buildings.floors.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="floor_id" value="{{ $floor->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editFloorModalLabel-{{ $floor->id }}">
                                Edit Lantai
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Kode Lantai</label>
                                <input type="text" class="form-control"
                                    value="{{ $floor->code }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="floor_name_{{ $floor->id }}" class="form-label">
                                    Nama Lantai <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="floor_name_{{ $floor->id }}" name="name" value="{{ $floor->name }}"
                                    maxlength="255" required>
                            </div>
                            <div class="mb-3">
                                <label for="floor_description_{{ $floor->id }}" class="form-label">
                                    Deskripsi
                                </label>
                                <textarea class="form-control" id="floor_description_{{ $floor->id }}" name="description"
                                    rows="3">{{ $floor->description }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-1">{{ $building->name }}</h5>
            <small class="text-muted">Informasi Master Gedung</small>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label text-muted">Kode Gedung</label>
                    <div class="fw-semibold">{{ $building->code }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Nama Gedung</label>
                    <div class="fw-semibold">{{ $building->name }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Status</label>
                    <div>
                        @if ($building->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Tanggal Dibuat</label>
                    <div>{{ $building->created_at?->format('d M Y H:i') ?? '-' }}</div>
                </div>

                <div class="col-12">
                    <label class="form-label text-muted">Deskripsi</label>
                    <div>{{ $building->description ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Daftar Lantai</h5>
                <small class="text-muted">
                    Lantai yang terdaftar pada gedung ini.
                </small>
            </div>

            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFloorModal">
                <i class="fas fa-plus me-1"></i> Tambah Lantai
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Kode Lantai</th>
                            <th>Nama Lantai</th>
                            <th>Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($building->floors as $floor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $floor->code }}
                                    </span>
                                </td>
                                <td>{{ $floor->name }}</td>
                                <td>
                                    @if ($floor->is_active)
                                        <span class="badge bg-success-subtle text-success">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editFloorModal-{{ $floor->id }}" title="Edit Lantai">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('buildings.floors.status') }}" method="POST" class="d-inline floor-status-form"
                                        data-active="{{ $floor->is_active ? '1' : '0' }}">
                                        @csrf

                                        <input type="hidden" name="floor_id" value="{{ $floor->id }}">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-{{ $floor->is_active ? 'warning' : 'success' }}"
                                            title="{{ $floor->is_active ? 'Nonaktifkan Lantai' : 'Aktifkan Lantai' }}">

                                            <i class="fas fa-{{ $floor->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('buildings.floors.destroy') }}" method="POST"
                                        class="d-inline floor-delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <input type="hidden" name="floor_id" value="{{ $floor->id }}">

                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Lantai">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada lantai yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/buildings/buildings.js')
@endpush