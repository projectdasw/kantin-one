<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="60">No.</th>
                <th>Kode Gedung</th>
                <th>Nama Gedung</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th width="180" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buildings as $building)
                <tr>
                    <td>{{ $buildings->firstItem() + $loop->index }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $building->code }}
                        </span>
                    </td>
                    <td class="fw-semibold">{{ $building->name }}</td>
                    <td>{{ Str::limit($building->description, 50) ?: '-' }}</td>
                    <td>
                        @if ($building->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <form action="{{ route('buildings.detail.select') }}" method="POST">
                                @csrf
                                <input type="hidden" name="building_id" value="{{ $building->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>

                            <form action="{{ route('buildings.edit.select') }}" method="POST">
                                @csrf
                                <input type="hidden" name="building_id" value="{{ $building->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <form action="{{ route('buildings.status') }}" method="POST" class="building-status-form">
                                @csrf
                                <input type="hidden" name="building_id" value="{{ $building->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Ubah Status">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>

                            <form action="{{ route('buildings.destroy') }}" method="POST" class="building-delete-form">
                                @csrf
                                <input type="hidden" name="building_id" value="{{ $building->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada data gedung.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">
        Menampilkan {{ $buildings->firstItem() ?? 0 }}–{{ $buildings->lastItem() ?? 0 }}
        dari {{ $buildings->total() }} data
    </small>

    {{ $buildings->links() }}
</div>