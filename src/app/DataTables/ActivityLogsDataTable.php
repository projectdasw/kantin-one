<?php

namespace App\DataTables;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ActivityLogsDataTable extends DataTable
{
    /**
     * Mengolah data tabel menggunakan Yajra DataTables.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            // Informasi pengguna yang melakukan aktivitas.
            ->addColumn('account', function (ActivityLog $log) {
                if (! $log->user) {
                    return '
                        <div class="d-flex flex-column">
                            <span class="fw-bold">Pengguna tidak tersedia</span>
                            <span class="text-muted">—</span>
                        </div>
                    ';
                }

                return '
                    <div class="d-flex flex-column">
                        <span class="fw-bold">'.e($log->user->name).'</span>
                        <span class="text-muted">'.e($log->user->username).'</span>
                    </div>
                ';
            })

            // Badge jenis aktivitas.
            ->addColumn('activity_label', function (ActivityLog $log) {
                $class = match (true) {
                    str_starts_with($log->activity, 'auth.') =>
                        'bg-info bg-gradient text-dark',

                    str_starts_with($log->activity, 'user.') =>
                        'bg-primary bg-gradient',

                    str_starts_with($log->activity, 'page.') =>
                        'bg-secondary bg-gradient',

                    default => 'bg-warning bg-gradient text-dark',
                };

                $label = ucwords(str_replace(
                    ['.', '_'],
                    ' ',
                    $log->activity
                ));

                return '<span class="badge '.$class.'">'
                    .e($label).
                    '</span>';
            })

            // Deskripsi aktivitas.
            ->addColumn('description_label', function (ActivityLog $log) {
                return e($log->description ?: '—');
            })

            // Waktu aktivitas.
            ->addColumn('time_label', function (ActivityLog $log) {
                return $log->created_at
                    ? $log->created_at->format('d/m/Y H:i:s')
                    : '—';
            })

            // Pencarian pelaku aktivitas.
            ->filterColumn('account', function ($query, $keyword) {
                $keyword = mb_strtolower($keyword);

                $query->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->whereRaw(
                        'LOWER(name) LIKE ?',
                        ["%{$keyword}%"]
                    )->orWhereRaw(
                        'LOWER(username) LIKE ?',
                        ["%{$keyword}%"]
                    );
                });
            })

            // Pencarian jenis aktivitas.
            ->filterColumn('activity_label', function ($query, $keyword) {
                $query->whereRaw(
                    'LOWER(activity) LIKE ?',
                    ['%'.mb_strtolower($keyword).'%']
                );
            })

            // Pencarian deskripsi.
            ->filterColumn('description_label', function ($query, $keyword) {
                $query->whereRaw(
                    'LOWER(description) LIKE ?',
                    ['%'.mb_strtolower($keyword).'%']
                );
            })

            ->rawColumns([
                'account',
                'activity_label',
            ]);
    }

    /**
     * Query sumber data histori aktivitas.
     */
    public function query(ActivityLog $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('user')
            ->latest('created_at');
    }

    /**
     * Konfigurasi HTML DataTables.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('activity-logs-table')
            ->columns($this->getColumns())
            ->postAjax([
                'url' => route('activity-logs.search'),
                'headers' => [
                    'X-CSRF-TOKEN' => csrf_token(),
                ],
            ])
            ->orderBy(1, 'desc')
            ->pageLength(10)
            ->parameters([
                'lengthMenu' => [10, 25, 50, 100],
                'searching' => true,
                'ordering' => true,
                'autoWidth' => false,
                'language' => [
                    'search' => 'Cari:',
                    'searchPlaceholder' => 'Pengguna, aktivitas, atau deskripsi...',
                    'lengthMenu' => 'Tampilkan _MENU_ aktivitas',
                    'info' => 'Menampilkan _START_–_END_ dari _TOTAL_ aktivitas',
                    'infoEmpty' => 'Tidak ada aktivitas',
                    'zeroRecords' => 'Aktivitas tidak ditemukan',
                    'emptyTable' => 'Belum ada histori aktivitas',
                    'processing' => 'Memuat histori...',
                    'paginate' => [
                        'first' => 'Pertama',
                        'last' => 'Terakhir',
                        'next' => 'Berikutnya',
                        'previous' => 'Sebelumnya',
                    ],
                ],
            ])
            ->processing(true)
            ->serverSide(true);
    }

    /**
     * Definisi kolom tabel.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->searchable(false)
                ->orderable(false)
                ->width(40)
                ->addClass('text-center'),

            Column::computed('account')
                ->title('Pengguna')
                ->searchable(true)
                ->orderable(false),

            Column::computed('activity_label')
                ->title('Aktivitas')
                ->searchable(true)
                ->orderable(false),

            Column::computed('description_label')
                ->title('Deskripsi')
                ->searchable(true)
                ->orderable(false),

            Column::computed('time_label')
                ->title('Waktu')
                ->searchable(false)
                ->orderable(false),
        ];
    }

    /**
     * Nama file export.
     */
    protected function filename(): string
    {
        return 'Histori_Akun_'.date('YmdHis');
    }
}