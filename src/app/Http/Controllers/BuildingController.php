<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $this->ensureAdministrator();

        $query = Building::query();

        // Pencarian tanpa membedakan huruf besar dan kecil
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('code', 'ilike', "%{$search}%")
                    ->orWhere('name', 'ilike', "%{$search}%")
                    ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        // Filter status hanya diterapkan jika benar-benar dipilih
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === '1');
        }

        $buildings = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('buildings.partials.table', compact('buildings'));
        }

        return view('buildings.index', compact('buildings'));
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
