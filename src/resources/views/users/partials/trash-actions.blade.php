<div class="d-flex align-items-center gap-1">
    {{-- Pulihkan --}}
    <form action="{{ route('users.restore') }}" method="POST" class="restore-user-form"
        data-name="{{ $user->name }}">
        @csrf

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip"
            data-bs-placement="left" data-bs-title="Pulihkan Akun">
            <i class="fas fa-trash-restore"></i>
        </button>
    </form>

    @if (!$user->is_protected)
        {{-- Hapus Permanen --}}
        <form action="{{ route('users.force-delete') }}" method="POST" class="force-delete-user-form"
            data-name="{{ $user->name }}">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                data-bs-placement="left" data-bs-title="Hapus Permanen">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endif
</div>