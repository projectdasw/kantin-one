<div class="table-responsive">
    <table class="table table-sm table-hover align-middle">
        <thead class="table-primary">
            <tr class="small">
                <th>#</th>
                <th>Kode</th>
                <th>Nama Kantin</th>
                <th>Deskripsi</th>
                <th class="text-center">Status</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @forelse ($canteens as $canteen)
                <tr>
                    <td>{{ $canteens->firstItem() + $loop->index }}</td>

                    <td>
                        <span class="badge bg-primary-subtle text-primary">
                            {{ $canteen->code }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary-subtle rounded-circle d-flex justify-content-center align-items-center"
                                 style="width: 2.5rem; height: 2.5rem;">
                                <i class="fas fa-store text-primary"></i>
                            </div>

                            <strong>{{ $canteen->name }}</strong>
                        </div>
                    </td>

                    <td>{{ $canteen->description ?: '-' }}</td>

                    <td class="text-center">
                        @if ($canteen->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <form action="{{ route('canteens.select-detail') }}" method="POST">
                                @csrf
                                <input type="hidden" name="canteen_id" value="{{ $canteen->id }}">

                                <button type="submit" class="btn btn-sm btn-outline-info"
                                        title="Detail Kantin">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>

                            <form action="{{ route('canteens.select-edit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="canteen_id" value="{{ $canteen->id }}">

                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                        title="Edit Kantin">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <form action="{{ route('canteens.toggle-status') }}"
                                  method="POST"
                                  class="canteen-status-form"
                                  data-name="{{ $canteen->name }}"
                                  data-status="{{ $canteen->is_active ? 'nonaktifkan' : 'aktifkan' }}">
                                @csrf
                                <input type="hidden" name="canteen_id" value="{{ $canteen->id }}">

                                <button type="submit" class="btn btn-sm btn-outline-warning"
                                        title="{{ $canteen->is_active ? 'Nonaktifkan' : 'Aktifkan' }} Kantin">
                                    <i class="fas {{ $canteen->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </form>

                            <form action="{{ route('canteens.destroy') }}"
                                  method="POST"
                                  class="canteen-delete-form"
                                  data-name="{{ $canteen->name }}">
                                @csrf
                                <input type="hidden" name="canteen_id" value="{{ $canteen->id }}">

                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        title="Hapus Kantin">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">
                            Belum ada data kantin.
                        </p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($canteens->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">
            Menampilkan {{ $canteens->firstItem() ?? 0 }}
            sampai {{ $canteens->lastItem() ?? 0 }}
            dari {{ $canteens->total() }} kantin
        </small>

        {{ $canteens->links() }}
    </div>
@endif