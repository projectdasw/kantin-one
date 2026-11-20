<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama Meja</th>
                <th>Kapasitas</th>
                <th>Lokasi</th>
                <th>Status</th>
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

                    <td class="fw-semibold">
                        {{ $table->name }}
                    </td>

                    <td>
                        <i class="fas fa-users text-muted me-1"></i>
                        {{ $table->capacity }} orang
                    </td>

                    <td>
                        {{ $table->location ?: '-' }}
                    </td>

                    <td>
                        @if ($table->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-1">

                            <form action="{{ route('tables.select-detail') }}" method="POST">
                                @csrf
                                <input type="hidden" name="table_id" value="{{ $table->id }}">

                                <button type="submit" class="btn btn-sm btn-info text-white"
                                    data-bs-toggle="tooltip" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>

                            <form action="{{ route('tables.select-edit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="table_id" value="{{ $table->id }}">

                                <button type="submit" class="btn btn-sm btn-warning"
                                    data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <form action="{{ route('tables.toggle-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="table_id" value="{{ $table->id }}">

                                <button type="submit"
                                    class="btn btn-sm {{ $table->is_active ? 'btn-secondary' : 'btn-success' }}"
                                    data-bs-toggle="tooltip"
                                    title="{{ $table->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas {{ $table->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                </button>
                            </form>

                            <form action="{{ route('tables.destroy') }}" method="POST"
                                class="delete-table-form">
                                @csrf
                                <input type="hidden" name="table_id" value="{{ $table->id }}">

                                <button type="submit" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-table fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Belum ada data meja.</p>
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
@elseif ($tables->total() > 0)
    <div class="text-muted small">
        Menampilkan {{ $tables->total() }} meja
    </div>
@endif