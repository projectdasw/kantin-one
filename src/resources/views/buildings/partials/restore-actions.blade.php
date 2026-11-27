
<div class="d-flex justify-content-center">
    <form action="{{ route('buildings.restore.action') }}"
          method="POST"
          class="building-restore-form">
        @csrf

        <input type="hidden" name="building_id" value="{{ $building->id }}">

        <button type="submit"
                class="btn btn-sm btn-outline-success"
                title="Pulihkan">
            <i class="fas fa-undo"></i>
        </button>
    </form>
</div>
