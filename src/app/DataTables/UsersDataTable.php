<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Mengolah data tabel menggunakan Yajra DataTables.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            // Nomor urut
            ->addIndexColumn()

            // Nama dan email pengguna
            ->addColumn('account', function (User $user) {
                return '
                    <div class="account-info">
                        <div class="account-avatar">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <div class="account-details">
                            <span class="account-name">'
                                .e($user->name).
                            '</span>
                            <span class="account-email">'
                                .e($user->email ?: '—').
                            '</span>
                        </div>
                    </div>
                ';
            })

            // Badge role
            ->addColumn('role_label', function (User $user) {
                $class = match ($user->role) {
                    'super_admin' => 'badge-role-danger',
                    'administrator' => 'badge-role-warning',
                    default => 'badge-role-primary',
                };

                $label = ucwords(str_replace('_', ' ', $user->role));

                return '<span class="badge-custom '.$class.'">'
                    .e($label).
                    '</span>';
            })

            // Badge status
            ->addColumn('status_label', function (User $user) {
                $class = $user->is_active
                    ? 'badge-status-active'
                    : 'badge-status-inactive';

                $label = $user->is_active ? 'Aktif' : 'Nonaktif';

                return '<span class="badge-custom '.$class.'">'
                    .$label.
                    '</span>';
            })

            // Tombol aksi
            ->addColumn('action', function (User $user) {
                return view('users.partials.actions', compact('user'))->render();
            })

            // Pencarian nama dan email
            ->filterColumn('account', function ($query, $keyword) {
                $keyword = mb_strtolower($keyword);

                $query->where(function ($query) use ($keyword) {
                    $query->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
                        ->orWhereRaw('LOWER(email) LIKE ?', ["%{$keyword}%"]);
                });
            })

            // Kolom yang berisi HTML
            ->rawColumns([
                'account',
                'role_label',
                'status_label',
                'action',
            ]);
    }

    /**
     * Query sumber data pengguna.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()

            // Administrator tidak boleh melihat akun Super Admin.
            ->when(
                ! auth()->user()->isSuperAdmin(),
                fn ($query) => $query->where('role', '!=', 'super_admin')
            )

            // Filter role
            ->when(request()->filled('role'), function ($query) {
                $query->where('role', request('role'));
            })

            // Filter status
            ->when(request()->input('status') !== null &&
                request()->input('status') !== '', function ($query) {
                    $query->where('is_active', request('status'));
                })

            ->latest();
    }

    /**
     * Konfigurasi HTML DataTables.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->postAjax([
                'url' => route('users.search'),
                'headers' => [
                    'X-CSRF-TOKEN' => csrf_token(),
                ],
                'data' => 'function(data) {
                    data.role = document.querySelector("#userRoleFilter")?.value ?? "";
                    data.status = document.querySelector("#userStatusFilter")?.value ?? "";
                }',
            ])
            ->orderBy(1)
            ->pageLength(10)
            ->parameters([
                'lengthMenu' => [10, 25, 50, 100],
                'searching' => true,
                'ordering' => true,
                'autoWidth' => false,
                'language' => [
                    'search' => 'Cari:',
                    'searchPlaceholder' => 'Nama, email, atau username...',
                    'lengthMenu' => 'Tampilkan _MENU_ data',
                    'info' => 'Menampilkan _START_–_END_ dari _TOTAL_ akun',
                    'infoEmpty' => 'Tidak ada data',
                    'zeroRecords' => 'Data tidak ditemukan',
                    'emptyTable' => 'Belum ada data akun',
                    'processing' => 'Memuat data...',
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
                ->title('')
                ->searchable(true)
                ->orderable(false),

            Column::make('username')
                ->title('Username'),

            Column::computed('role_label')
                ->title('Peran')
                ->searchable(false)
                ->orderable(false),

            Column::computed('status_label')
                ->title('Status')
                ->searchable(false)
                ->orderable(false),

            Column::computed('action')
                ->title('')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Nama file export.
     */
    protected function filename(): string
    {
        return 'Master_Akun_'.date('YmdHis');
    }
}
