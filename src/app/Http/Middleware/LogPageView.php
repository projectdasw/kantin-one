<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogPageView
{
    /**
     * Mencatat aktivitas pembukaan halaman.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya mencatat request GET.
        if (! $request->isMethod('get')) {
            return $response;
        }

        // Abaikan request AJAX dan JSON.
        if ($request->ajax() || $request->expectsJson()) {
            return $response;
        }

        // Hanya mencatat pengguna yang sudah login.
        if (! Auth::guard()->check()) {
            return $response;
        }

        // Hanya mencatat halaman HTML yang berhasil dibuka.
        if (
            $response->getStatusCode() !== 200 ||
            ! str_contains(
                (string) $response->headers->get('Content-Type'),
                'text/html'
            )
        ) {
            return $response;
        }

        app(ActivityLogger::class)->log(
            activity: 'page.viewed',
            description: 'Pengguna membuka halaman aplikasi.',
            properties: [
                'route' => $request->route()?->getName(),
            ]
        );

        return $response;
    }
}