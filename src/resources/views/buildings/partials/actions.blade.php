
<div class="d-flex justify-content-center gap-1">
    {{-- Detail --}}
    <form action="{{ route('buildings.detail.select') }}" method="POST">
        @csrf
        <input type="hidden" name="building_id" value="{{ $building->id }}">
        <button type="submit" class="btn btn-sm btn-outline-info" title="Detail">
            <i class="fas fa-eye"></i>
        </button>
    </form>

    {{-- Edit --}}
    <form action="{{ route('buildings.edit.select') }}" method="POST">
        @csrf
        <input type="hidden" name="building_id" value="{{ $building->id }}">
        <button type="submit" class="btn btn-sm btn-outline-primary" title="Edit">
            <i class="fas fa-edit"></i>
        </button>
    </form>

    {{-- Ubah Status --}}
    <form action="{{ route('buildings.status') }}" method="POST" class="building-status-form">
        @csrf
        <input type="hidden" name="building_id" value="{{ $building->id }}">
        <button type="submit" class="btn btn-sm btn-outline-warning" title="Ubah Status">
            <i class="fas fa-power-off"></i>
        </button>
    </form>

    {{-- Hapus --}}
    <form action="{{ route('buildings.destroy') }}" method="POST" class="building-delete-form">
        @csrf
        <input type="hidden" name="building_id" value="{{ $building->id }}">
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
