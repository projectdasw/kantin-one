
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th style="width: 50px">No.</th>
                <th>Pengguna</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>

                    <td>
                        <div class="fw-semibold">{{ $user->name }}</div>
                        <small class="text-muted">{{ $user->email }}</small>
                    </td>

                    <td>{{ $user->username }}</td>

                    <td>
                        <span class="badge bg-info-subtle text-info">
                            {{ ucwords(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>

                    <td>
                        @if ($user->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">Nonaktif</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('users.show', $user) }}"
                               class="btn btn-sm btn-light" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('users.edit', $user) }}"
                               class="btn btn-sm btn-light" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if ($user->id !== auth()->id())
                                <form action="{{ route('users.toggle-status', $user) }}"
                                      method="POST"
                                      class="status-form"
                                      data-name="{{ $user->name }}"
                                      data-active="{{ $user->is_active ? '1' : '0' }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="btn btn-sm btn-light {{ $user->is_active ? 'text-danger' : 'text-success' }}"
                                            title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-2x mb-3 d-block"></i>
                        Tidak ada pengguna ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
    <small class="text-muted">
        Menampilkan {{ $users->firstItem() ?? 0 }}
        sampai {{ $users->lastItem() ?? 0 }}
        dari {{ $users->total() }} pengguna
    </small>

    {{ $users->links() }}
</div>
