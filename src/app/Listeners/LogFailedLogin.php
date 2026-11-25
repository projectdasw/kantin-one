<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Failed;

class LogFailedLogin
{
    /**
     * Mencatat percobaan login yang gagal.
     */
    public function handle(Failed $event): void
    {
        app(ActivityLogger::class)->log(
            activity: 'auth.login_failed',
            description: 'Percobaan login gagal karena kredensial tidak valid.',
            subject: $event->user
        );
    }
}