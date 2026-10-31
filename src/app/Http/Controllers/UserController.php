<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function ensureAdministrator(): void
    {
        abort_unless(
            auth()->user()?->isAdministrator(),
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    private function roles(): array
    {
        return ['administrator', 'canteen_manager', 'tenant',];
    }

    public function index(Request $request)
    {
        $this->ensureAdministrator();

        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->when($request->status !== null && $request->status !== '', function ($query) use ($request) {
                $query->where('is_active', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $data = [
            'users' => $users,
            'roles' => $this->roles(),
        ];

        if (request()->ajax()) {
            return view('users.partials.table', $data);
        }

        return view('users.index', $data);
    }

    public function create()
    {
        $this->ensureAdministrator();

        return view('users.create', [
            'roles' => $this->roles(),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdministrator();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'regex:/\A[a-z0-9_-]+\z/', 'max:50', 'unique:users,username',],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed',],
            'role' => ['required', Rule::in($this->roles())],
        ]);

        $validated['is_active'] = true;
        User::create($validated);
        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $this->ensureAdministrator();
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->ensureAdministrator();
        return view('users.edit', [
            'user' => $user,
            'roles' => $this->roles(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->ensureAdministrator();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'regex:/\A[a-z0-9_-]+\z/', 'max:50', Rule::unique('users', 'username')->ignore($user->id),],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id),],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($this->roles())],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        // Jangan izinkan Administrator terakhir kehilangan role Administrator.
        if (
            $user->is_active &&
            $user->role === 'administrator' &&
            $validated['role'] !== 'administrator' &&
            User::where('role', 'administrator')
                ->where('is_active', true)
                ->count() <= 1
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'Tidak dapat mengubah role Administrator aktif terakhir.',
                ]);
        }

        $user->update($validated);
        return redirect()
            ->route('users.show', $user)
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->ensureAdministrator();

        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun sendiri.'
            );
        }

        if ($user->is_active) {
            return back()->with('error', 'Nonaktifkan akun terlebih dahulu sebelum menghapusnya.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        $this->ensureAdministrator();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        if (
            $user->is_active &&
            $user->role === 'administrator' &&
            User::where('role', 'administrator')
                ->where('is_active', true)
                ->count() <= 1
        ) {
            return back()->with('error', 'Administrator aktif terakhir tidak dapat dinonaktifkan.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $message = $user->is_active
            ? 'Akun pengguna berhasil diaktifkan.'
            : 'Akun pengguna berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }
}
