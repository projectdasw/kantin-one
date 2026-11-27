<?php

namespace App\DataTables;

use App\Models\Building;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BuildingsInactiveDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('code', fn ($building) => $building->code)
            ->editColumn('name', fn ($building) => $building->name)
            ->editColumn('description', fn ($building) => $building->description ?: '-')
            ->addColumn('status_label', function ($building) {
                return '<span class="badge bg-secondary">Nonaktif</span>';
            })
            ->addColumn('action', function ($building) {
                return view('buildings.partials.actions', compact('building'))->render();
            })
            ->filter(function ($query) {
                // Halaman ini hanya menampilkan gedung nonaktif.
                $query->where('is_active', false);
            }, true)
            ->rawColumns(['status_label', 'action'])
            ->setRowId('id');
    }

    public function query(Building $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('is_active', false)
            ->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('buildings-inactive-table')
            ->columns($this->getColumns())
            ->postAjax([
                'url' => route('buildings.inactive.search'),
                'headers' => [
                    'X-CSRF-TOKEN' => csrf_token(),
                ],
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
                    'searchPlaceholder' => 'Kode atau nama gedung...',
                    'lengthMenu' => 'Tampilkan _MENU_ data',
                    'info' => 'Menampilkan _START_–_END_ dari _TOTAL_ gedung',
                    'infoEmpty' => 'Tidak ada data',
                    'zeroRecords' => 'Data tidak ditemukan',
                    'emptyTable' => 'Tidak ada gedung nonaktif',
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->searchable(false)
                ->orderable(false)
                ->width(50),

            Column::make('code')
                ->title('Kode Gedung'),

            Column::make('name')
                ->title('Nama Gedung'),

            Column::make('description')
                ->title('Deskripsi'),

            Column::computed('status_label')
                ->title('Status')
                ->searchable(false)
                ->orderable(false),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'BuildingsInactive_' . date('YmdHis');
    }
}
