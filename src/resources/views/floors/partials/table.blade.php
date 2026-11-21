<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="60">No.</th>
                <th>Gedung</th>
                <th>Kode Lantai</th>
                <th>Nama Lantai</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th width="180" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($floors as $floor)
                <tr>
                    <td>{{ $floors->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold">
                            {{ $floor->building?->name ?? 'Building tidak tersedia' }}
                        </div>
                        <small class="text-muted">
                            {{ $floor->building?->code ?? '-' }}
                        </small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $floor->code }}
                        </span>
                    </td>
                    <td class="fw-semibold">{{ $floor->name }}</td>
                    <td>{{ Str::limit($floor->description, 50) ?: '-' }}</td>
                    <td>
                        @if ($floor->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <form action="{{ route('floors.detail.select') }}" method="POST">
                                @csrf
                                <input type="hidden" name="floor_id" value="{{ $floor->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>

                            <form action="{{ route('floors.edit.select') }}" method="POST">
                                @csrf
                                <input type="hidden" name="floor_id" value="{{ $floor->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <form action="{{ route('floors.status') }}" method="POST" class="floor-status-form">
                                @csrf
                                <input type="hidden" name="floor_id" value="{{ $floor->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Ubah Status">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>

                            <form action="{{ route('floors.destroy') }}" method="POST" class="floor-delete-form">
                                @csrf
                                <input type="hidden" name="floor_id" value="{{ $floor->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Belum ada data lantai.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">
        Menampilkan {{ $floors->firstItem() ?? 0 }}–{{ $floors->lastItem() ?? 0 }}
        dari {{ $floors->total() }} data
    </small>

    {{ $floors->links() }}
</div>