<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Canteen;
use App\Models\Floor;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                        ->orWhere('table_number', 'ILIKE', "%{$search}%")
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

        $canteens = Canteen::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $buildings = Building::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('tables.create', compact(
            'canteens',
            'buildings'
        ));
    }

    public function store(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'canteen_id' => [
                'required',
                'uuid',
                'exists:canteens,id',
            ],
            'building_id' => [
                'required',
                'uuid',
                'exists:buildings,id',
            ],
            'floor_id' => [
                'required',
                'uuid',
                'exists:floors,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:32767',
            ],
            'location' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $canteen = Canteen::query()
                ->whereKey($validated['canteen_id'])
                ->where('is_active', true)
                ->firstOrFail();

            $building = Building::query()
                ->whereKey($validated['building_id'])
                ->where('is_active', true)
                ->firstOrFail();

            // Kunci data lantai untuk mencegah
            // nomor meja ganda pada proses bersamaan.
            $floor = Floor::query()
                ->whereKey($validated['floor_id'])
                ->where('is_active', true)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan lantai benar-benar milik gedung pilihan.
            abort_unless(
                $floor->building_id === $building->id,
                422,
                'Lantai tidak sesuai dengan gedung yang dipilih.'
            );

            // Format dasar kode meja.
            $prefix = $canteen->code
                .'-'.$building->code
                .'-'.$floor->code
                .'-';

            // Periksa seluruh meja, termasuk yang sudah dihapus.
            $existingCodes = Table::withTrashed()
                ->where('code', 'like', $prefix.'%')
                ->pluck('code');

            $lastNumber = 0;

            foreach ($existingCodes as $existingCode) {
                $suffix = substr($existingCode, strlen($prefix));

                if (ctype_digit($suffix)) {
                    $lastNumber = max($lastNumber, (int) $suffix);
                }
            }

            $nextNumber = $lastNumber + 1;

            $tableNumber = str_pad(
                (string) $nextNumber,
                2,
                '0',
                STR_PAD_LEFT
            );

            $code = $prefix.$tableNumber;

            $table = new Table([
                'canteen_id' => $canteen->id,
                'floor_id' => $floor->id,
                'table_number' => $tableNumber,
                'code' => $code,
                'name' => $validated['name'],
                'capacity' => $validated['capacity'],
                'location' => $validated['location'] ?? null,
                'is_active' => true,
            ]);

            $table->qr_token = $this->generateQrToken();

            $table->save();
        });

        return redirect()
            ->route('tables.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    public function getFloors(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'building_id' => ['required', 'uuid', 'exists:buildings,id'],
        ]);

        $floors = Floor::query()
            ->where('building_id', $validated['building_id'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'code', 'name']);

        return response()->json($floors);
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:32767',
            ],
            'location' => [
                'nullable',
                'string',
                'max:100',
            ],
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
                        ->orWhere('table_number', 'ILIKE', "%{$search}%")
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
