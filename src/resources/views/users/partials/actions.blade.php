<div class="action-buttons">
    {{-- Detail --}}
    <form action="{{ route('users.select-detail') }}" method="POST">
        @csrf

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <button type="submit" class="btn btn-sm btn-primary"
            data-bs-toggle="tooltip" data-bs-placement="left"
            data-bs-title="Detail Akun">
            <i class="fas fa-eye"></i>
        </button>
    </form>

    @if (!$user->is_protected)
        {{-- Edit --}}
        <form action="{{ route('users.select-edit') }}" method="POST">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <button type="submit" class="btn btn-sm btn-warning"
                data-bs-toggle="tooltip" data-bs-placement="left"
                data-bs-title="Edit Akun">
                <i class="fas fa-edit"></i>
            </button>
        </form>

        {{-- Reset Password --}}
        <form action="{{ route('users.resetpassword.start') }}" method="POST">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <button type="submit" class="btn btn-sm btn-secondary"
                data-bs-toggle="tooltip" data-bs-placement="left"
                data-bs-title="Reset Password">
                <i class="fas fa-key"></i>
            </button>
        </form>

        @if ($user->id !== auth()->id())
            {{-- Toggle Status --}}
            <form action="{{ route('users.toggle-status') }}" method="POST"
                class="status-form"
                data-name="{{ $user->name }}"
                data-active="{{ $user->is_active ? '1' : '0' }}">
                @csrf

                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <button type="submit"
                    class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}"
                    data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                    <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                </button>
            </form>
        @endif
    @endif

    @if (!$user->is_active && !$user->is_protected)
        {{-- Soft Delete --}}
        <form action="{{ route('users.destroy') }}" method="POST"
            class="delete-user-form"
            data-name="{{ $user->name }}">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <button type="submit" class="btn btn-sm btn-danger"
                data-bs-toggle="tooltip" data-bs-placement="left"
                data-bs-title="Hapus Akun">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </form>
    @endif
</div>