<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersTrashDataTable extends DataTable
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
                    <div class="d-flex align-items-center gap-2">
                        <div class="account-avatar">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-bold">'.e($user->name).'</span>
                            <span class="text-muted">'.e($user->email ?: '—').'</span>
                        </div>
                    </div>
                ';
            })

            // Badge role
            ->addColumn('role_label', function (User $user) {
                $class = match ($user->role) {
                    'administrator' => 'bg-warning bg-gradient',
                    'canteen_manager' => 'bg-info bg-gradient text-dark',
                    'tenant' => 'bg-success bg-gradient',
                    'tenant_employee' => 'bg-primary bg-gradient',
                    default => 'bg-secondary bg-gradient',
                };

                $label = ucwords(str_replace('_', ' ', $user->role));

                return '<span class="badge '.$class.'">'
                    .e($label).
                    '</span>';
            })

            // Badge status sebelumnya
            ->addColumn('status_label', function (User $user) {
                $class = $user->is_active
                    ? 'bg-success bg-gradient'
                    : 'bg-danger bg-gradient';

                $label = $user->is_active ? 'Aktif' : 'Nonaktif';

                return '<span class="badge '.$class.'">'
                    .$label.
                    '</span>';
            })

            // Tanggal penghapusan
            ->addColumn('deleted_date', function (User $user) {
                return formatTanggal($user->deleted_at);
            })

            // Tombol aksi
            ->addColumn('action', function (User $user) {
                return view(
                    'users.partials.trash-actions',
                    compact('user')
                )->render();
            })

            // Pencarian nama, email dan username
            ->filterColumn('account', function ($query, $keyword) {
                $keyword = mb_strtolower($keyword);

                $query->where(function ($query) use ($keyword) {
                    $query->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
                        ->orWhereRaw('LOWER(email) LIKE ?', ["%{$keyword}%"])
                        ->orWhereRaw('LOWER(username) LIKE ?', ["%{$keyword}%"]);
                });
            })

            ->orderColumn('deleted_date', 'deleted_at $1')

            // Kolom yang berisi HTML
            ->rawColumns([
                'account',
                'role_label',
                'status_label',
                'action',
            ]);
    }

    /**
     * Query sumber data akun yang telah dihapus.
     */
    public function query(User $model): QueryBuilder
    {
        $currentUser = Auth::guard()->user();

        return $model->newQuery()
            ->onlyTrashed()

            // Administrator tidak boleh melihat akun Super Admin.
            ->when(
                ! ($currentUser instanceof User && $currentUser->isSuperAdmin()),
                fn ($query) => $query->where('role', '!=', 'super_admin')
            )

            // Filter berdasarkan peran.
            ->when(request()->filled('role'), function ($query) {
                $query->where('role', request('role'));
            })

            // Filter berdasarkan status sebelumnya.
            ->when(
                request()->input('status') !== null &&
                request()->input('status') !== '',
                function ($query) {
                    $query->where('is_active', request('status'));
                }
            )

            ->latest('deleted_at');
    }

    /**
     * Konfigurasi HTML DataTables.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-trash-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('users.trash'),
                'type' => 'GET',
                'data' => 'function(data) {
                    data.role = document.querySelector("#userTrashRoleFilter")?.value ?? "";
                    data.status = document.querySelector("#userTrashStatusFilter")?.value ?? "";
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
                    'emptyTable' => 'Belum ada akun yang dihapus',
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
                ->title('Status Sebelumnya')
                ->searchable(false)
                ->orderable(false),

            Column::make('deleted_date')
                ->title('Tanggal Dihapus')
                ->searchable(false)
                ->orderable(true),

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
        return 'Akun_Kadaluarsa_'.date('YmdHis');
    }
}
