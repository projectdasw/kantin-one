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
                        <small class="text-muted">{{ $user->email ?: '—' }}</small>
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

                            {{-- Detail --}}
                            <form action="{{ route('users.select-detail') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <button type="submit"
                                        class="btn btn-sm btn-light"
                                        title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>

                            {{-- Edit --}}
                            <form action="{{ route('users.select-edit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <button type="submit"
                                        class="btn btn-sm btn-light"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            {{-- Reset Password --}}
                            <form action="{{ route('users.resetpassword.start') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>
                            </form>

                            @if ($user->id !== auth()->id())

                                {{-- Toggle Status --}}
                                <form action="{{ route('users.toggle-status') }}"
                                      method="POST"
                                      class="status-form"
                                      data-name="{{ $user->name }}"
                                      data-active="{{ $user->is_active ? '1' : '0' }}">

                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                                    <button type="submit"
                                            class="btn btn-sm btn-light {{ $user->is_active ? 'text-danger' : 'text-success' }}"
                                            title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                    </button>
                                </form>

                                @if (!$user->is_active)

                                    {{-- Soft Delete --}}
                                    <form action="{{ route('users.destroy') }}"
                                          method="POST"
                                          class="delete-user-form"
                                          data-name="{{ $user->name }}">

                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                                        <button type="submit"
                                                class="btn btn-sm btn-light text-danger"
                                                title="Hapus Akun">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                @endif
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