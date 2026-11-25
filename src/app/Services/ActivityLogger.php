<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Daftar atribut sensitif yang tidak boleh dicatat.
     */
    protected array $sensitiveKeys = [
        'password',
        'password_confirmation',
        'current_password',
        'new_password',
        'remember_token',
        'token',
        'access_token',
        'refresh_token',
        'api_token',
        'csrf_token',
        '_token',
        'session',
        'session_id',
        'cookie',
        'authorization',
        'secret',
        'client_secret',
        'credential',
        'credentials',
    ];

    /**
     * Mencatat aktivitas pengguna.
     */
    public function log(
        string $activity,
        ?string $description = null,
        ?Model $subject = null,
        array $properties = []
    ): ActivityLog {
        $currentUser = Auth::guard()->user();

        $request = request();

        return ActivityLog::create([
            'user_id' => $currentUser instanceof User
                ? $currentUser->id
                : null,

            'activity' => $activity,
            'description' => $description,

            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),

            'properties' => $this->sanitizeProperties($properties),

            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->url(),
            'method' => $request->method(),
        ]);
    }

    /**
     * Menghapus atribut sensitif dari properties secara rekursif.
     */
    protected function sanitizeProperties(array $properties): array
    {
        $sanitized = [];

        foreach ($properties as $key => $value) {
            $normalizedKey = strtolower((string) $key);

            foreach ($this->sensitiveKeys as $sensitiveKey) {
                if (
                    $normalizedKey === $sensitiveKey ||
                    str_contains($normalizedKey, $sensitiveKey)
                ) {
                    continue 2;
                }
            }

            if (is_array($value)) {
                $value = $this->sanitizeProperties($value);
            }

            $sanitized[$key] = $value;
        }

        return $sanitized;
    }
}