<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use Illuminate\Http\Request;

class CanteenController extends Controller
{
    private function ensureAdministrator(): void
    {
        abort_unless(
            auth()->user()?->isAdministrator(),
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    private function selectCanteen(Request $request): Canteen
    {
        $validated = $request->validate([
            'canteen_id' => ['required', 'uuid', 'exists:canteens,id'],
        ]);

        return Canteen::findOrFail($validated['canteen_id']);
    }

    private function selectedCanteen(): Canteen
    {
        $canteenId = session('canteens.selected_canteen_id');

        abort_unless($canteenId, 404, 'Kantin belum dipilih.');

        return Canteen::findOrFail($canteenId);
    }

    public function index(Request $request)
    {
        $this->ensureAdministrator();

        $canteens = Canteen::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when(
                $request->input('status') !== null &&
                $request->input('status') !== '',
                fn ($query) => $query->where('is_active', $request->input('status'))
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('canteens.partials.table', compact('canteens'));
        }

        return view('canteens.index', compact('canteens'));
    }

    public function create()
    {
        $this->ensureAdministrator();

        return view('canteens.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:canteens,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $canteen = new Canteen($validated);
        $canteen->is_active = true;
        $canteen->save();

        return redirect()
            ->route('canteens.index')
            ->with('success', 'Master kantin berhasil ditambahkan.');
    }

    public function selectDetail(Request $request)
    {
        $this->ensureAdministrator();

        $canteen = $this->selectCanteen($request);

        session()->put('canteens.selected_canteen_id', $canteen->id);

        return redirect()->route('canteens.show');
    }

    public function show()
    {
        $this->ensureAdministrator();

        $canteen = $this->selectedCanteen();

        return view('canteens.show', compact('canteen'));
    }

    public function selectEdit(Request $request)
    {
        $this->ensureAdministrator();

        $canteen = $this->selectCanteen($request);

        session()->put('canteens.selected_canteen_id', $canteen->id);

        return redirect()->route('canteens.edit');
    }

    public function edit()
    {
        $this->ensureAdministrator();

        $canteen = $this->selectedCanteen();

        return view('canteens.edit', compact('canteen'));
    }

    public function update(Request $request)
    {
        $this->ensureAdministrator();

        $canteen = $this->selectedCanteen();

        abort_unless($canteen, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $canteen->update($validated);

        return redirect()
            ->route('canteens.show')
            ->with('success', 'Data kantin berhasil diperbarui.');
    }

    public function toggleStatus(Request $request)
    {
        $this->ensureAdministrator();

        $canteen = $this->selectCanteen($request);
        $canteen->is_active = ! $canteen->is_active;
        $canteen->save();

        $message = $canteen->is_active
            ? 'Kantin berhasil diaktifkan.'
            : 'Kantin berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }

    public function destroy(Request $request)
    {
        $this->ensureAdministrator();

        $canteen = $this->selectCanteen($request);

        $canteen->delete();

        if (session('canteens.selected_canteen_id') === $canteen->id) {
            session()->forget('canteens.selected_canteen_id');
        }

        return redirect()
            ->route('canteens.index')
            ->with('success', 'Master kantin berhasil dihapus.');
    }
}
