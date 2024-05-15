<?php

namespace App\DataTables;

use App\Models\ProductVariantOption;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantOptionDataTable extends DataTable
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
                $edit_btn = '<a href="' . route('vendor.products-variant-option.edit', $query->id) .
                    '" class="btn btn-primary"><i class="far fa-edit"></i></a>';
                $delete_btn = '<a href="' . route('vendor.products-variant-option.destroy', $query->id) .
                    '" class="btn btn-danger ml-2 delete-item"><i class="far fa-trash-alt"></i></a>';

                return $edit_btn . $delete_btn;
            })
            ->addColumn('is_default', function ($query) {
                return '<div class="form-check form-switch">
                        <input type="checkbox" name="is_default" id="vendor_product_variant_option_is_default"
                            class="form-check-input change-is-default" ' .
                    ($query->is_default == 1 ? 'checked' : '') . ' data-id="' . $query->id . '">
                    </div>';
            })
            ->addColumn('status', function ($query) {
                return '<div class="form-check form-switch">
                        <input type="checkbox" name="status" id="vendor_product_variant_option_status"
                            class="form-check-input change-status" ' .
                    ($query->status == 1 ? 'checked' : '') . ' data-id="' . $query->id . '">
                    </div>';
            })
            ->addColumn('variant_name', function ($query) {
                return $query->productVariant->name;
            })
            ->rawColumns(['action', 'is_default', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantOption $model): QueryBuilder
    {
        return $model->newQuery()->where('product_variant_id', '=', request()->variantId);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductvariantoption-table')
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
            Column::make('name'),
            Column::make('variant_name'),
            Column::make('price'),
            Column::make('is_default'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductVariantOption_' . date('YmdHis');
    }
}
