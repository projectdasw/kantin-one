<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /* Authorization */
    /* -------------------------------------------------------------------------- */

    private function ensureAdministrator(): void
    {
        $user = auth()->user();

        abort_unless(
            $user && (
                $user->isSuperAdmin() ||
                $user->isAdministrator()
            ),
            403,
            'Anda tidak memiliki akses untuk mengelola meja.'
        );
    }

    private function ensureMonitorAccess(): void
    {
        abort_unless(
            auth()->user()?->role === 'canteen_manager',
            403,
            'Anda tidak memiliki akses monitoring meja.'
        );
    }

    /* -------------------------------------------------------------------------- */
    /* Helper */
    /* -------------------------------------------------------------------------- */

    private function generateTableCode(): string
    {
        do {
            $code = 'TB-'.str_pad(
                (string) random_int(0, 999999),
                6,
                '0',
                STR_PAD_LEFT
            );
        } while (Table::withTrashed()->where('code', $code)->exists());

        return $code;
    }

    private function generateQrToken(): string
    {
        do {
            $token = bin2hex(random_bytes(32));
        } while (Table::withTrashed()->where('qr_token', $token)->exists());

        return $token;
    }

    private function selectTable(Request $request): Table
    {
        $validated = $request->validate([
            'table_id' => [
                'required',
                'uuid',
                'exists:tables,id',
            ],
        ]);

        return Table::query()->findOrFail($validated['table_id']);
    }

    private function selectedTable(): Table
    {
        $tableId = session('tables.selected_table_id');

        abort_unless($tableId, 404, 'Meja belum dipilih.');

        return Table::query()->findOrFail($tableId);
    }

    /* -------------------------------------------------------------------------- */
    /* Index, Search & Pagination */
    /* -------------------------------------------------------------------------- */

    public function index(Request $request)
    {
        $this->ensureAdministrator();

        $tables = Table::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('code', 'ILIKE', "%{$search}%")
                        ->orWhere('name', 'ILIKE', "%{$search}%")
                        ->orWhere('location', 'ILIKE', "%{$search}%");
                });
            })
            ->when(
                $request->input('status') !== null &&
                $request->input('status') !== '',
                function ($query) use ($request) {
                    $query->where('is_active', $request->input('status'));
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('tables.partials.table', compact('tables'));
        }

        return view('tables.index', compact('tables'));
    }

    /* -------------------------------------------------------------------------- */
    /* Create Table */
    /* -------------------------------------------------------------------------- */

    public function create()
    {
        $this->ensureAdministrator();

        return view('tables.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1', 'max:32767'],
            'location' => ['nullable', 'string', 'max:100'],
        ]);

        $table = new Table([
            'code' => $this->generateTableCode(),
            'name' => $validated['name'],
            'capacity' => $validated['capacity'],
            'location' => $validated['location'] ?? null,
            'is_active' => true,
        ]);

        // QR Token dibuat oleh sistem, bukan dari input pengguna.
        $table->qr_token = $this->generateQrToken();
        $table->save();

        return redirect()
            ->route('tables.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    /* -------------------------------------------------------------------------- */
    /* Table Detail */
    /* -------------------------------------------------------------------------- */

    public function selectDetail(Request $request)
    {
        $this->ensureAdministrator();

        $table = $this->selectTable($request);

        session()->put('tables.selected_table_id', $table->id);

        return redirect()->route('tables.show');
    }

    public function show()
    {
        $this->ensureAdministrator();

        $table = $this->selectedTable();

        return view('tables.show', compact('table'));
    }

    /* -------------------------------------------------------------------------- */
    /* Edit Table */
    /* -------------------------------------------------------------------------- */

    public function selectEdit(Request $request)
    {
        $this->ensureAdministrator();

        $table = $this->selectTable($request);

        session()->put('tables.selected_table_id', $table->id);

        return redirect()->route('tables.edit');
    }

    public function edit()
    {
        $this->ensureAdministrator();

        $table = $this->selectedTable();

        return view('tables.edit', compact('table'));
    }

    public function update(Request $request)
    {
        $this->ensureAdministrator();

        $table = $this->selectedTable();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1', 'max:32767'],
            'location' => ['nullable', 'string', 'max:100'],
        ]);

        $table->update([
            'name' => $validated['name'],
            'capacity' => $validated['capacity'],
            'location' => $validated['location'] ?? null,
        ]);

        return redirect()
            ->route('tables.index')
            ->with('success', 'Data meja berhasil diperbarui.');
    }

    /* -------------------------------------------------------------------------- */
    /* Table Status */
    /* -------------------------------------------------------------------------- */

    public function toggleStatus(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'table_id' => ['required', 'uuid'],
        ]);

        $table = Table::query()
            ->findOrFail($validated['table_id']);

        $table->update([
            'is_active' => ! $table->is_active,
        ]);

        return redirect()
            ->route('tables.index')
            ->with(
                'success',
                $table->is_active
                    ? 'Meja berhasil diaktifkan.'
                    : 'Meja berhasil dinonaktifkan.'
            );
    }

    /* -------------------------------------------------------------------------- */
    /* Soft Delete */
    /* -------------------------------------------------------------------------- */

    public function destroy(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'table_id' => ['required', 'uuid'],
        ]);

        $table = Table::query()
            ->findOrFail($validated['table_id']);

        $table->delete();

        if (session('tables.selected_table_id') === $table->id) {
            session()->forget('tables.selected_table_id');
        }

        return redirect()
            ->route('tables.index')
            ->with('success', 'Meja berhasil dihapus.');
    }

    /* -------------------------------------------------------------------------- */
    /* Trash */
    /* -------------------------------------------------------------------------- */

    public function trash()
    {
        $this->ensureAdministrator();

        $tables = Table::onlyTrashed()
            ->when(request()->filled('search'), function ($query) {
                $search = request('search');

                $query->where(function ($q) use ($search) {
                    $q->where('code', 'ILIKE', "%{$search}%")
                        ->orWhere('name', 'ILIKE', "%{$search}%");
                });
            })
            ->latest('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('tables.trash', compact('tables'));
    }

    public function restore(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'table_id' => ['required', 'uuid'],
        ]);

        $table = Table::onlyTrashed()
            ->findOrFail($validated['table_id']);

        $table->restore();

        return redirect()
            ->route('tables.trash')
            ->with('success', 'Meja berhasil dipulihkan.');
    }

    public function forceDelete(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'table_id' => ['required', 'uuid'],
        ]);

        $table = Table::onlyTrashed()
            ->findOrFail($validated['table_id']);

        $table->forceDelete();

        return redirect()
            ->route('tables.trash')
            ->with('success', 'Meja berhasil dihapus permanen.');
    }

    /* -------------------------------------------------------------------------- */
    /* Monitoring - Kepala Pengelola Tenant */
    /* -------------------------------------------------------------------------- */

    public function monitor()
    {
        $this->ensureMonitorAccess();

        $tables = Table::query()
            ->orderBy('code')
            ->paginate(15);

        return view('tables.monitor', compact('tables'));
    }
}
