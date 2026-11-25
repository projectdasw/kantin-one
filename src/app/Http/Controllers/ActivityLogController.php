<?php

namespace App\Http\Controllers;

use App\DataTables\ActivityLogsDataTable;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan halaman histori akun.
     */
    public function index(ActivityLogsDataTable $dataTable)
    {
        return $dataTable->render('activity-logs.index', [
            'totalActivities' => ActivityLog::count(),

            'todayActivities' => ActivityLog::whereDate(
                'created_at',
                today()
            )->count(),

            'loginActivities' => ActivityLog::whereIn('activity', [
                'auth.login',
                'auth.login_failed',
                'auth.logout',
            ])->count(),

            'userActivities' => ActivityLog::where(
                'activity',
                'like',
                'user.%'
            )->count(),
        ]);
    }
}