<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\DataTables\UsersTrashDataTable;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    /* Authorization */
    /* -------------------------------------------------------------------------- */
    private function ensureAdministrator(): void
    {
        $user = Auth::guard()->user();

        abort_unless(
            $user instanceof User && $user->isAdministrator(),
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }
    /* -------------------------------------------------------------------------- */

    /* Helper */
    /* -------------------------------------------------------------------------- */
    private function ensureUserAccessible(User $user): void
    {
        $currentUser = Auth::guard()->user();

        abort_if(
            $user->isSuperAdmin() &&
            ! ($currentUser instanceof User && $currentUser->isSuperAdmin()),
            403,
            'Anda tidak memiliki akses untuk mengelola akun Super Admin.'
        );
    }

    private function ensureUserNotProtected(User $user): void
    {
        $this->ensureUserAccessible($user);

        abort_if(
            $user->is_protected,
            403,
            'Akun Super Admin utama tidak dapat diubah melalui aplikasi.'
        );
    }

    private function roles(): array
    {
        $roles = ['administrator', 'canteen_manager', 'tenant', 'tenant_employee'];
        $currentUser = Auth::guard()->user();

        if ($currentUser instanceof User && $currentUser->isSuperAdmin()) {
            array_unshift($roles, 'super_admin');
        }

        return $roles;
    }

    private function tenantValidationRules(Request $request, ?User $user = null): array
    {
        $rules = ['exclude_unless:role,tenant,tenant_employee', 'required', 'uuid',
            Rule::exists('tenants', 'id')
                ->where('is_active', true)
                ->whereNull('deleted_at'),
        ];

        // Satu tenant hanya boleh memiliki satu Kepala Tenant.
        if ($request->input('role') === 'tenant') {
            $uniqueRule = Rule::unique('users', 'tenant_id')
                ->where(fn ($query) => $query
                    ->where('role', 'tenant')
                    ->whereNull('deleted_at'));

            if ($user) {
                $uniqueRule->ignore($user->id);
            }

            $rules[] = $uniqueRule;
        }

        return $rules;
    }

    /* User Selection */
    /* -------------------------------------------------------------------------- */
    private function selectUser(Request $request, bool $onlyTrashed = false): User
    {
        $validated = $request->validate([
            'user_id' => ['required', 'uuid', 'exists:users,id'],
        ]);

        $query = $onlyTrashed
            ? User::onlyTrashed()
            : User::query();

        return $query->findOrFail($validated['user_id']);
    }

    private function selectedUser(): User
    {
        $userId = session('users.selected_user_id');

        abort_unless($userId, 404, 'Pengguna belum dipilih.');

        return User::findOrFail($userId);
    }
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */

    /* Index, Search & Pagination */
    /* -------------------------------------------------------------------------- */
    public function index(UsersDataTable $dataTable)
    {
        $this->ensureAdministrator();

        $currentUser = Auth::guard()->user();
        $visibleUsers = User::query()
            ->when(
                ! ($currentUser instanceof User && $currentUser->isSuperAdmin()),
                fn ($query) => $query->where('role', '!=', 'super_admin')
            );

        return $dataTable->render('users.index', [
            'roles' => $this->roles(),
            'totalUsers' => (clone $visibleUsers)->count(),
            'activeUsers' => (clone $visibleUsers)->where('is_active', true)->count(),
            'inactiveUsers' => (clone $visibleUsers)->where('is_active', false)->count(),
        ]);
    }
    /* -------------------------------------------------------------------------- */

    /* Create User */
    /* -------------------------------------------------------------------------- */
    public function create()
    {
        $this->ensureAdministrator();

        return view('users.create', [
            'roles' => $this->roles(),
            'tenants' => Tenant::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'code', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdministrator();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'regex:/^[a-z0-9_-]+$/', 'max:50', 'unique:users,username'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($this->roles())],
            'tenant_id' => $this->tenantValidationRules($request),
        ]);

        // Simpan tenant_id secara eksplisit.
        $tenantId = $validated['tenant_id'] ?? null;
        unset($validated['tenant_id']);

        $user = User::create($validated);
        $user->tenant_id = $tenantId;
        $user->is_active = true;
        $user->is_protected = false;
        $user->save();

        app(ActivityLogger::class)->log(
            activity: 'user.created',
            description: 'Administrator berhasil menambahkan akun pengguna.',
            subject: $user,
            properties: [
                'new' => $user->only([
                    'name',
                    'username',
                    'email',
                    'role',
                    'tenant_id',
                    'is_active',
                    'is_protected',
                ]),
            ]
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun berhasil dibuat.');
    }
    /* -------------------------------------------------------------------------- */

    /* User Detail */
    /* -------------------------------------------------------------------------- */
    public function selectDetail(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request);
        $this->ensureUserAccessible($user);
        session()->put('users.selected_user_id', $user->id);

        return redirect()->route('users.show');
    }

    public function show()
    {
        $this->ensureAdministrator();
        $user = $this->selectedUser();
        $this->ensureUserAccessible($user);

        return view('users.show', compact('user'));
    }
    /* -------------------------------------------------------------------------- */

    /* Edit User */
    /* -------------------------------------------------------------------------- */
    public function selectEdit(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request);
        $this->ensureUserNotProtected($user);
        session()->put('users.selected_user_id', $user->id);

        return redirect()->route('users.edit');
    }

    public function edit()
    {
        $this->ensureAdministrator();
        $user = $this->selectedUser();
        $this->ensureUserNotProtected($user);

        return view('users.edit', [
            'user' => $user,
            'roles' => $this->roles(),
            'tenants' => Tenant::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'code', 'name']),
        ]);
    }

    public function update(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectedUser();
        $this->ensureUserNotProtected($user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'regex:/^[a-z0-9_-]+$/', 'max:50',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($this->roles())],
            'tenant_id' => $this->tenantValidationRules($request, $user),
        ]);

        $tenantId = $validated['tenant_id'] ?? null;
        unset($validated['tenant_id']);

        $passwordChanged = ! empty($validated['password']);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        // Lindungi Administrator aktif terakhir.
        if ($user->is_active && $user->role === 'administrator' && $validated['role'] !== 'administrator' &&
            User::where('role', 'administrator')
                ->where('is_active', true)
                ->count() <= 1
        ) {
            return back()
                ->withInput()
                ->withErrors(['role' => 'Tidak dapat mengubah role Administrator aktif terakhir.']);
        }

        $trackedAttributes = [
            'name',
            'username',
            'email',
            'role',
            'tenant_id',
            'is_active',
            'is_protected',
        ];

        $oldValues = $user->only($trackedAttributes);

        $user->fill($validated);
        $user->tenant_id = $tenantId;
        $user->save();

        $newValues = $user->only($trackedAttributes);
        $changedKeys = array_keys(array_diff_assoc($newValues, $oldValues));
        $oldChanges = array_intersect_key($oldValues, array_flip($changedKeys));
        $newChanges = array_intersect_key($newValues, array_flip($changedKeys));

        if ($passwordChanged) {
            app(ActivityLogger::class)->log(
                activity: 'user.password_reset',
                description: 'Administrator berhasil mengubah password melalui halaman Edit Pengguna.',
                subject: $user
            );
        }

        app(ActivityLogger::class)->log(
            activity: 'user.updated',
            description: 'Administrator berhasil memperbarui akun pengguna.',
            subject: $user,
            properties: [
                'old' => $oldChanges,
                'new' => $newChanges,
            ]
        );

        return redirect()
            ->route('users.show')
            ->with('success', 'Akun berhasil diperbarui.');
    }
    /* -------------------------------------------------------------------------- */

    /* User Status */
    /* -------------------------------------------------------------------------- */
    public function toggleStatus(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request);
        $this->ensureUserNotProtected($user);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun sendiri.');
        }

        // Lindungi Administrator aktif terakhir dari Administrator biasa.
        // Super Admin tetap boleh menonaktifkannya.
        $currentUser = Auth::guard()->user();
        if (
            ! ($currentUser instanceof User && $currentUser->isSuperAdmin()) &&
            $user->is_active &&
            $user->role === 'administrator' &&
            User::where('role', 'administrator')
                ->where('is_active', true)
                ->count() <= 1
        ) {
            return back()
                ->with('error', 'Administrator aktif terakhir tidak dapat dinonaktifkan.');
        }

        $oldStatus = $user->is_active;
        $user->is_active = ! $user->is_active;
        $user->save();

        app(ActivityLogger::class)->log(
        activity: 'user.status_changed',
        description: 'Administrator berhasil mengubah status akun pengguna.',
        subject: $user,
        properties: [
            'old' => [
                'is_active' => $oldStatus,
            ],
            'new' => [
                'is_active' => $user->is_active,
            ],
        ]
    );

        $message = $user->is_active
            ? 'Akun berhasil diaktifkan kembali.'
            : 'Akun telah dinonaktifkan.';

        return back()->with('success', $message);
    }
    /* -------------------------------------------------------------------------- */

    /* Soft Delete */
    /* -------------------------------------------------------------------------- */
    public function destroy(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request);
        $this->ensureUserNotProtected($user);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($user->is_active) {
            return back()->with('error', 'Nonaktifkan akun terlebih dahulu sebelum menghapusnya.');
        }

        $deletedUserData = $user->only([
            'name',
            'username',
            'email',
            'role',
            'tenant_id',
            'is_active',
            'is_protected',
        ]);

        $user->delete();

        app(ActivityLogger::class)->log(
            activity: 'user.deleted',
            description: 'Administrator berhasil menghapus akun pengguna.',
            subject: $user,
            properties: [
                'deleted' => $deletedUserData,
            ]
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
    /* -------------------------------------------------------------------------- */

    /* Trash, Restore & Force Delete */
    /* -------------------------------------------------------------------------- */
    public function trash(UsersTrashDataTable $dataTable)
    {
        $this->ensureAdministrator();

        return $dataTable->render('users.trash', [
            'roles' => $this->roles(),
        ]);
    }

    public function restore(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request, true);
        $this->ensureUserNotProtected($user);
        $user->restore();

        app(ActivityLogger::class)->log(
            activity: 'user.restored',
            description: 'Administrator berhasil memulihkan akun pengguna.',
            subject: $user,
            properties: [
                'restored' => $user->only([
                    'name',
                    'username',
                    'email',
                    'role',
                    'tenant_id',
                    'is_active',
                    'is_protected',
                ]),
            ]
        );

        return redirect()
            ->route('users.trash')
            ->with('success', 'Akun berhasil dipulihkan.');
    }

    public function forceDelete(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request, true);
        $this->ensureUserNotProtected($user);
        $userId = $user->id;

        $deletedUserData = $user->only([
            'name',
            'username',
            'email',
            'role',
            'tenant_id',
            'is_active',
            'is_protected',
        ]);

        $user->forceDelete();

        app(ActivityLogger::class)->log(
            activity: 'user.force_deleted',
            description: 'Administrator berhasil menghapus akun pengguna secara permanen.',
            subject: $user,
            properties: [
                'deleted' => $deletedUserData,
            ]
        );

        // Bersihkan session jika pengguna yang dihapus
        // masih tersimpan sebagai pengguna terpilih.
        if (session('users.selected_user_id') === $userId) {
            session()->forget('users.selected_user_id');
        }

        if (session('users.reset_password_user_id') === $userId) {
            session()->forget('users.reset_password_user_id');
        }

        if (session('users.main_reset_password_user_id') === $userId) {
            session()->forget('users.main_reset_password_user_id');
        }

        return redirect()
            ->route('users.trash')
            ->with('success', 'Akun telah dihapus secara permanen.');
    }
    /* -------------------------------------------------------------------------- */

    /* Reset Password */
    /* -------------------------------------------------------------------------- */
    /* Halaman Utama Reset Password*/
    /* -------------------------------------------------------------------------- */
    public function resetPasswordUser()
    {
        $this->ensureAdministrator();

        $currentUser = Auth::guard()->user();
        $users = User::query()
            ->where('is_protected', false)
            ->when(
                ! ($currentUser instanceof User && $currentUser->isSuperAdmin()),
                fn ($query) => $query->where('role', '!=', 'super_admin')
            )
            ->orderBy('name')
            ->get(['id', 'name', 'username', 'role']);

        $selectedUser = null;

        return view('users.reset_password_user', compact(
            'users',
            'selectedUser'
        ));
    }

    public function selectResetPasswordUser(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request);
        $this->ensureUserNotProtected($user);

        return redirect()
            ->route('users.reset-password-user')
            ->with('selected_reset_password_user_id', $user->id);
    }

    public function updateResetPasswordUser(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request);
        $this->ensureUserNotProtected($user);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        app(ActivityLogger::class)->log(
            activity: 'user.password_reset',
            description: 'Administrator berhasil mereset password akun melalui halaman Reset Password User.',
            subject: $user
        );

        return redirect()
            ->route('users.reset-password-user')
            ->with('success', 'Password pengguna berhasil diperbarui.');
    }
    /* -------------------------------------------------------------------------- */

    /* Reset Password pada tombol Aksi di halaman utama Akun */
    /* -------------------------------------------------------------------------- */
    public function startPasswordReset(Request $request)
    {
        $this->ensureAdministrator();
        $user = $this->selectUser($request);
        $this->ensureUserNotProtected($user);

        // Simpan target reset password.
        session()->put('users.reset_password_user_id', $user->id);

        // Agar setelah reset dapat kembali ke detail pengguna yang sama.
        session()->put('users.selected_user_id', $user->id);

        return redirect()->route('users.resetpassword.edit');
    }

    public function editPassword()
    {
        $this->ensureAdministrator();
        $userId = session('users.reset_password_user_id');
        abort_unless($userId, 404, 'Target Reset Password tidak ditemukan.');
        $user = User::findOrFail($userId);
        $this->ensureUserNotProtected($user);

        return view('users.resetpassword', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $this->ensureAdministrator();
        $userId = session('users.reset_password_user_id');
        abort_unless($userId, 404, 'Target Reset Password tidak ditemukan.');
        $user = User::findOrFail($userId);
        $this->ensureUserNotProtected($user);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        app(ActivityLogger::class)->log(
            activity: 'user.password_reset',
            description: 'Administrator berhasil mereset password akun pengguna.',
            subject: $user
        );

        session()->forget('users.reset_password_user_id');

        return redirect()
            ->route('users.show')
            ->with('success', 'Akun telah berhasil reset password.');
    }
    /* -------------------------------------------------------------------------- */
}
