<?php

namespace App\DataTables;

use App\Models\ReferralSetting;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReferralSettingDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $view_btn = '<a href="' . route('admin.referral.edit', $query->id) .
                    '" class="btn btn-primary"><i class="far fa-edit"></i></a>';
                $delete_btn = '<a href="' . route('admin.referral.destroy', $query->id) .
                    '" class="btn btn-danger ml-2 delete-item"><i class="far fa-trash-alt"></i></a>';

                return $view_btn . $delete_btn;
            })
            ->addColumn('status', function ($query) {
                return '<label class="custom-switch mt-2">
                        <input type="checkbox" name="status" class="custom-switch-input change-status" ' .
                    ($query->status === 1 ? 'checked' : '') . ' data-id="' . $query->id . '">
                        <span class="custom-switch-indicator"></span>
                    </label>';
            })
            ->addColumn('bonus', function ($query) {
                return $query->bonus . '%';
            })
            ->addColumn('points', function ($query) {
                return $query->points . '%';
            })
            ->addColumn('package', function ($query) {
                return $query->productType->name;
            })
            ->rawColumns(['action', 'status', 'bonus', 'points', 'package'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ReferralSetting $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('referralsetting-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('package'),
            Column::make('bonus'),
            Column::make('points'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ReferralSetting_' . date('YmdHis');
    }
}
