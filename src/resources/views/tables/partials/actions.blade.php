<div class="d-flex justify-content-center gap-1">

    {{-- Detail --}}
    <form action="{{ route('tables.select-detail') }}" method="POST">
        @csrf
        <input type="hidden" name="table_id" value="{{ $table->id }}">

        <button type="submit"
            class="btn btn-sm btn-info"
            data-bs-toggle="tooltip"
            title="Detail Meja">
            <i class="fas fa-eye"></i>
        </button>
    </form>

    {{-- Edit --}}
    <form action="{{ route('tables.select-edit') }}" method="POST">
        @csrf
        <input type="hidden" name="table_id" value="{{ $table->id }}">

        <button type="submit"
            class="btn btn-sm btn-warning"
            data-bs-toggle="tooltip"
            title="Edit Meja">
            <i class="fas fa-edit"></i>
        </button>
    </form>

    {{-- Ubah Status --}}
    <form action="{{ route('tables.toggle-status') }}" method="POST">
        @csrf
        <input type="hidden" name="table_id" value="{{ $table->id }}">

        <button type="submit"
            class="btn btn-sm {{ $table->is_active ? 'btn-secondary' : 'btn-success' }}"
            data-bs-toggle="tooltip"
            title="{{ $table->is_active ? 'Nonaktifkan Meja' : 'Aktifkan Meja' }}">
            <i class="fas {{ $table->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
        </button>
    </form>

    {{-- Hapus --}}
    <form action="{{ route('tables.destroy') }}"
        method="POST"
        class="delete-table-form">
        @csrf
        <input type="hidden" name="table_id" value="{{ $table->id }}">

        <button type="submit"
            class="btn btn-sm btn-danger"
            data-bs-toggle="tooltip"
            title="Hapus Meja">
            <i class="fas fa-trash"></i>
        </button>
    </form>

</div>