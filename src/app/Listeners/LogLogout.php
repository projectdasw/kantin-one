<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Logout;

class LogLogout
{
    /**
     * Mencatat aktivitas logout pengguna.
     */
    public function handle(Logout $event): void
    {
        app(ActivityLogger::class)->log(
            activity: 'auth.logout',
            description: 'Pengguna berhasil logout dari sistem.',
            subject: $event->user
        );
    }
}