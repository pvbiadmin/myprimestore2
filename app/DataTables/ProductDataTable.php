<?php

namespace App\DataTables;

use App\Models\Product;
use Auth;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
                $edit_btn = '<a href="' . route('admin.products.edit', $query->id) .
                    '" class="btn btn-primary"><i class="far fa-edit"></i></a>';
                $delete_btn = '<a href="' . route('admin.products.destroy', $query->id) .
                    '" class="btn btn-danger ml-2 delete-item"><i class="far fa-trash-alt"></i></a>';
                $more_btn = '<div class="dropleft d-inline ml-1">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item has-icon" href="' .
                    route('admin.products-image-gallery.index', ['product' => $query->id]) .
                    '">Image Gallery</a>
                        <a class="dropdown-item has-icon" href="' .
                    route('admin.products-variant.index', ['product' => $query->id]) .
                    '">Variants</a>
                      </div>
                  </div>';

                return $edit_btn . $delete_btn . $more_btn;
            })
            ->addColumn('image', function ($query) {
                return '<img src="' . asset($query->thumb_image) . '" width="70" alt="" />';
            })
            ->addColumn('type', function ($query) {
                return match ($query->product_type) {
                    'featured_product' => '<i class="badge badge-success">Featured Product</i>',
                    'top_product' => '<i class="badge badge-info">Top Product</i>',
                    'best_product' => '<i class="badge badge-warning">Best Product</i>',
                    'new_arrival' => '<i class="badge badge-danger">New Arrival</i>',
                    default => '<i class="badge badge-dark">None</i>',
                };
            })
            ->addColumn('status', function ($query) {
                return '<label class="custom-switch mt-2">
                        <input type="checkbox" name="status" class="custom-switch-input change-status" ' .
                    ($query->status == 1 ? 'checked' : '') . ' data-id="' . $query->id . '">
                        <span class="custom-switch-indicator"></span>
                    </label>';
            })
            ->rawColumns(['image', 'action', 'status', 'type'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()->where('vendor_id', '=', Auth::user()->vendor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
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
            Column::make('image'),
            Column::make('name'),
            Column::make('price'),
            Column::make('type')->width(100),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(300)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
