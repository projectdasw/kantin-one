<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\DataTables\BuildingsDataTable;
use App\DataTables\BuildingsInactiveDataTable;
use App\DataTables\BuildingsRestoreDataTable;

class BuildingController extends Controller
{
    private function ensureAdministrator(): void
    {
        abort_unless(
            auth()->user()?->isAdministrator(),
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    private function selectedBuilding(): ?Building
    {
        $id = session('selected_building_id');

        return $id ? Building::find($id) : null;
    }

    public function index(BuildingsDataTable $dataTable)
    {
        $this->ensureAdministrator();

        return $dataTable->render('buildings.index');
    }

    public function inactive(BuildingsInactiveDataTable $dataTable)
    {
        $this->ensureAdministrator();

        return $dataTable->render('buildings.inactive');
    }

    public function restorePage(BuildingsRestoreDataTable $dataTable)
    {
        $this->ensureAdministrator();

        return $dataTable->render('buildings.restore');
    }

    public function restore(Request $request)
    {
        $this->ensureAdministrator();

        $request->validate([
            'building_id' => ['required', 'uuid'],
        ]);

        $building = Building::onlyTrashed()
            ->findOrFail($request->building_id);

        $building->restore();

        return redirect()
            ->route('buildings.restore')
            ->with('success', 'Gedung berhasil dipulihkan.');
    }

    public function create()
    {
        $this->ensureAdministrator();

        return view('buildings.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:buildings,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $building = new Building($validated);
        $building->is_active = true;
        $building->save();

        return redirect()
            ->route('buildings.index')
            ->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function storeFloor(Request $request)
    {
        $this->ensureAdministrator();

        $building = $this->selectedBuilding();

        abort_unless($building, 404);

        abort_unless(
            $building->is_active,
            403,
            'Lantai tidak dapat ditambahkan pada gedung nonaktif.'
        );

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('floors', 'code')
                    ->where('building_id', $building->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $floor = new Floor($validated);
        $floor->building_id = $building->id;
        $floor->is_active = true;
        $floor->save();

        return redirect()
            ->route('buildings.show')
            ->with('success', 'Lantai berhasil ditambahkan.');
    }

    public function updateFloor(Request $request)
    {
        $this->ensureAdministrator();

        $building = $this->selectedBuilding();

        abort_unless($building, 404);

        $validated = $request->validate([
            'floor_id' => ['required', 'uuid'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $floor = $building->floors()
            ->findOrFail($validated['floor_id']);

        $floor->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('buildings.show')
            ->with('success', 'Data lantai berhasil diperbarui.');
    }

    public function destroyFloor(Request $request)
    {
        $this->ensureAdministrator();

        $building = $this->selectedBuilding();

        abort_unless($building, 404);

        $validated = $request->validate([
            'floor_id' => ['required', 'uuid'],
        ]);

        $floor = $building->floors()
            ->findOrFail($validated['floor_id']);

        if ($floor->tables()->exists()) {
            return redirect()
                ->route('buildings.show')
                ->with('error', 'Lantai tidak dapat dihapus karena masih memiliki data meja.');
        }

        $floor->delete();

        return redirect()
            ->route('buildings.show')
            ->with('success', 'Lantai berhasil dihapus.');
    }

    public function toggleFloorStatus(Request $request)
    {
        $this->ensureAdministrator();

        $building = $this->selectedBuilding();

        abort_unless($building, 404);

        $validated = $request->validate([
            'floor_id' => ['required', 'uuid'],
        ]);

        $floor = $building->floors()
            ->findOrFail($validated['floor_id']);

        $floor->is_active = ! $floor->is_active;
        $floor->save();

        return redirect()
            ->route('buildings.show')
            ->with('success', 'Status lantai berhasil diperbarui.');
    }

    public function selectDetail(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'building_id' => ['required', 'uuid', 'exists:buildings,id'],
        ]);

        session(['selected_building_id' => $validated['building_id']]);

        return redirect()->route('buildings.show');
    }

    public function show()
    {
        $this->ensureAdministrator();

        $building = $this->selectedBuilding();

        abort_unless($building, 404);

        $building->load([
            'floors' => fn ($query) => $query->latest(),
        ]);

        return view('buildings.show', compact('building'));
    }

    public function selectEdit(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'building_id' => ['required', 'uuid', 'exists:buildings,id'],
        ]);

        session(['selected_building_id' => $validated['building_id']]);

        return redirect()->route('buildings.edit');
    }

    public function edit()
    {
        $this->ensureAdministrator();

        $building = $this->selectedBuilding();

        abort_unless($building, 404);

        return view('buildings.edit', compact('building'));
    }

    public function update(Request $request)
    {
        $this->ensureAdministrator();

        $building = $this->selectedBuilding();

        abort_unless($building, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $building->update($validated);

        return redirect()
            ->route('buildings.show')
            ->with('success', 'Data gedung berhasil diperbarui.');
    }

    public function toggleStatus(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'building_id' => ['required', 'uuid', 'exists:buildings,id'],
        ]);

        $building = Building::findOrFail($validated['building_id']);

        $building->is_active = ! $building->is_active;
        $building->save();

        return redirect()
            ->route('buildings.index')
            ->with('success', 'Status gedung berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'building_id' => ['required', 'uuid', 'exists:buildings,id'],
        ]);

        $building = Building::findOrFail($validated['building_id']);

        $building->delete();

        session()->forget('selected_building_id');

        return redirect()
            ->route('buildings.index')
            ->with('success', 'Gedung berhasil dihapus.');
    }
}
