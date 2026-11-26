<?php

namespace App\DataTables;

use App\Models\Table;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TableDataTable extends DataTable
{
    /**
     * Konfigurasi kolom tabel.
     */
    protected function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->width(50)
                ->addClass('text-center'),

            Column::make('code')
                ->title('Kode'),

            Column::make('table_number')
                ->title('Nomor Meja')
                ->addClass('text-center'),

            Column::make('name')
                ->title('Nama Meja'),

            Column::make('capacity')
                ->title('Kapasitas')
                ->addClass('text-center'),

            Column::make('location')
                ->title('Lokasi'),

            Column::computed('status_label')
                ->title('Status')
                ->addClass('text-center'),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Nama file ketika data diekspor.
     */
    protected function filename(): string
    {
        return 'Data_Meja_' . date('YmdHis');
    }

    /**
     * Konfigurasi HTML DataTables.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tables-table')
            ->columns($this->getColumns())
            ->postAjax([
                'url' => route('tables.search'),
                'headers' => [
                    'X-CSRF-TOKEN' => csrf_token(),
                ],
                'data' => 'function(data) {
                    data.status = document.querySelector("#tableStatus")?.value ?? "";
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
                    'searchPlaceholder' => 'Kode, nomor meja, nama, atau lokasi...',
                    'lengthMenu' => 'Tampilkan _MENU_ data',
                    'info' => 'Menampilkan _START_–_END_ dari _TOTAL_ meja',
                    'infoEmpty' => 'Tidak ada data',
                    'zeroRecords' => 'Data tidak ditemukan',
                    'emptyTable' => 'Belum ada data meja',
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
     * Mengolah data tabel menggunakan Yajra DataTables.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            // Nomor urut
            ->addIndexColumn()

            // Kode meja
            ->editColumn('code', function (Table $table) {
                return '<span class="badge bg-dark">'
                    .e($table->code).
                    '</span>';
            })

            // Nomor meja
            ->editColumn('table_number', function (Table $table) {
                return '<span class="badge bg-primary">'
                    .e($table->table_number).
                    '</span>';
            })

            // Nama meja
            ->editColumn('name', function (Table $table) {
                return '<span class="fw-semibold">'
                    .e($table->name).
                    '</span>';
            })

            // Kapasitas
            ->editColumn('capacity', function (Table $table) {
                return '<i class="fas fa-users text-muted me-1"></i>'
                    .$table->capacity.' orang';
            })

            // Lokasi
            ->editColumn('location', function (Table $table) {
                return e($table->location ?: '-');
            })

            // Status
            ->addColumn('status_label', function (Table $table) {
                $class = $table->is_active
                    ? 'bg-success'
                    : 'bg-secondary';

                $label = $table->is_active
                    ? 'Aktif'
                    : 'Nonaktif';

                return '<span class="badge '.$class.'">'
                    .$label.
                    '</span>';
            })

            // Filter status
            ->filterColumn('status_label', function ($query, $keyword) {
                if ($keyword === '1' || $keyword === '0') {
                    $query->where('is_active', $keyword);
                }
            })

            // Tombol aksi
            ->addColumn('action', function (Table $table) {
                return view('tables.partials.actions', compact('table'))->render();
            })

            // Kolom HTML
            ->rawColumns([
                'code',
                'table_number',
                'name',
                'capacity',
                'status_label',
                'action'
            ]);
    }

    /**
     * Query sumber data meja.
     */
    public function query(Table $model): QueryBuilder
    {
        return $model->newQuery()

            // Filter status
            ->when(
                request()->input('status') !== null &&
                request()->input('status') !== '',
                function ($query) {
                    $query->where('is_active', request('status'));
                }
            )

            ->latest();
    }
}