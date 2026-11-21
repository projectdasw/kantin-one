@extends('layouts.dashboard')

@section('title', 'Recycle Bin Meja')

@section('page-title')
    <i class="fas fa-trash me-2"></i> Recycle Bin Meja
@endsection

@section('page-description')
    Kelola data meja yang telah dihapus.
@endsection

@section('page-actions')
    <a href="{{ route('tables.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Manajemen Meja
    </a>
@endsection

@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Data yang dihapus permanen tidak dapat dipulihkan kembali.
        </div>

        <form action="{{ route('tables.trash') }}" method="GET" class="mb-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Cari kode, nomor, atau nama meja..."
                >

                <button class="btn btn-primary" type="submit">
                    Cari
                </button>

                @if (request('search'))
                    <a href="{{ route('tables.trash') }}"
                        class="btn btn-outline-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nomor Meja</th>
                        <th>Nama Meja</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>Dihapus Pada</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tables as $table)
                        <tr>
                            <td>{{ $tables->firstItem() + $loop->index }}</td>

                            <td>
                                <span class="badge bg-dark">
                                    {{ $table->code }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $table->table_number }}
                                </span>
                            </td>

                            <td class="fw-semibold">{{ $table->name }}</td>

                            <td>{{ $table->capacity }} Orang</td>

                            <td>{{ $table->location ?: '-' }}</td>

                            <td>
                                {{ $table->deleted_at->format('d M Y, H:i') }}
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <form action="{{ route('tables.restore') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="table_id"
                                            value="{{ $table->id }}">

                                        <button type="submit"
                                            class="btn btn-sm btn-success"
                                            data-bs-toggle="tooltip"
                                            title="Pulihkan">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('tables.force-delete') }}"
                                        method="POST"
                                        class="force-delete-table-form">
                                        @csrf
                                        <input type="hidden" name="table_id"
                                            value="{{ $table->id }}">

                                        <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">
                                    Recycle Bin masih kosong.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($tables->hasPages())
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $tables->firstItem() }}–{{ $tables->lastItem() }}
                    dari {{ $tables->total() }} meja
                </small>

                {{ $tables->links() }}
            </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.force-delete-table-form').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const result = await Swal.fire({
                title: 'Hapus permanen?',
                text: 'Data meja ini tidak dapat dipulihkan kembali.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus permanen',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            });

            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush