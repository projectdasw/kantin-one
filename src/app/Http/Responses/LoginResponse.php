<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Services\ActivityLogger;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        $route = match ($user->role) {
            'super_admin', 'administrator' => 'dashboard',
            'canteen_manager' => 'dashboard.canteen_manager',
            'tenant', 'tenant_employee' => 'dashboard.tenant',

            default => abort(403, 'Role akun belum memiliki dashboard.'),
        };

        app(ActivityLogger::class)->log(
            activity: 'auth.login',
            description: 'Pengguna berhasil login ke sistem.',
            subject: $user
        );

        if ($request->wantsJson()) {
            return new JsonResponse([
                'redirect' => route($route),
            ]);
        }

        return redirect()->route($route);
    }
}
