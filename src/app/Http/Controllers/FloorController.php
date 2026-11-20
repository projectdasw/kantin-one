<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FloorController extends Controller
{
    private function ensureAdministrator(): void
    {
        abort_unless(
            auth()->user()?->isAdministrator(),
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    private function selectedFloor(): Floor
    {
        $floorId = session('selected_floor_id');

        abort_unless($floorId, 404);

        return Floor::with('building')->findOrFail($floorId);
    }

    public function index(Request $request)
    {
        $this->ensureAdministrator();

        $query = Floor::with('building');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('code', 'ilike', "%{$search}%")
                    ->orWhere('name', 'ilike', "%{$search}%")
                    ->orWhere('description', 'ilike', "%{$search}%")
                    ->orWhereHas('building', function ($building) use ($search) {
                        $building->where('code', 'ilike', "%{$search}%")
                            ->orWhere('name', 'ilike', "%{$search}%");
                    });
            });
        }

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === '1');
        }

        $floors = $query->latest()->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('floors.partials.table', compact('floors'));
        }

        $buildings = Building::orderBy('name')->get();

        return view('floors.index', compact('floors', 'buildings'));
    }

    public function create()
    {
        $this->ensureAdministrator();

        $buildings = Building::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('floors.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'building_id' => [
                'required',
                'uuid',
                Rule::exists('buildings', 'id')->where('is_active', true),
            ],
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('floors', 'code')
                    ->where('building_id', $request->building_id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $floor = new Floor($validated);
        $floor->is_active = true;
        $floor->save();

        return redirect()
            ->route('floors.index')
            ->with('success', 'Lantai berhasil ditambahkan.');
    }

    public function selectDetail(Request $request)
    {
        $this->ensureAdministrator();

        $request->validate([
            'floor_id' => ['required', 'uuid', 'exists:floors,id'],
        ]);

        session(['selected_floor_id' => $request->floor_id]);

        return redirect()->route('floors.show');
    }

    public function show()
    {
        $this->ensureAdministrator();

        $floor = $this->selectedFloor();

        return view('floors.show', compact('floor'));
    }

    public function selectEdit(Request $request)
    {
        $this->ensureAdministrator();

        $request->validate([
            'floor_id' => ['required', 'uuid', 'exists:floors,id'],
        ]);

        session(['selected_floor_id' => $request->floor_id]);

        return redirect()->route('floors.edit');
    }

    public function edit()
    {
        $this->ensureAdministrator();

        $floor = $this->selectedFloor();

        return view('floors.edit', compact('floor'));
    }

    public function update(Request $request)
    {
        $this->ensureAdministrator();

        $floor = $this->selectedFloor();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $floor->update($validated);

        return redirect()
            ->route('floors.show')
            ->with('success', 'Data lantai berhasil diperbarui.');
    }

    public function toggleStatus(Request $request)
    {
        $this->ensureAdministrator();

        $request->validate([
            'floor_id' => ['required', 'uuid', 'exists:floors,id'],
        ]);

        $floor = Floor::findOrFail($request->floor_id);
        $floor->is_active = ! $floor->is_active;
        $floor->save();

        return back()->with('success', 'Status lantai berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $this->ensureAdministrator();

        $request->validate([
            'floor_id' => ['required', 'uuid', 'exists:floors,id'],
        ]);

        $floor = Floor::findOrFail($request->floor_id);

        $floor->delete();

        if (session('selected_floor_id') === $floor->id) {
            session()->forget('selected_floor_id');
        }

        return back()->with('success', 'Lantai berhasil dihapus.');
    }
}
