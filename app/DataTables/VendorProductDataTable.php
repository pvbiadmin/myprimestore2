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

class VendorProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $edit_btn = '<a href="' . route('vendor.products.edit', $query->id) .
                    '" class="btn btn-primary"><i class="far fa-edit"></i></a>';
                $delete_btn = '<a href="' . route('vendor.products.destroy', $query->id) .
                    '" class="btn btn-danger delete-item"><i class="far fa-trash-alt"></i></a>';
                $more_btn = '<div class="btn-group dropstart" style="margin-left: 4px">
                      <button type="button" class="btn btn-primary dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item has-icon" href="' .
                    route('vendor.products-image-gallery.index', ['product' => $query->id]) .
                    '">Image Gallery</a></li>
                        <li><a class="dropdown-item has-icon" href="' .
                    route('vendor.products-variant.index', ['product' => $query->id]) .
                    '">Variants</a></li>
                      </ul>
                    </div>';

                return $edit_btn . $delete_btn . $more_btn;
            })
            ->addColumn('name', function ($query) {
                return $this->truncateColStr($query->name, 'name');
            })
            ->addColumn('image', function ($query) {
                return '<img src="' . asset($query->thumb_image) . '" width="70" alt="" />';
            })
            ->addColumn('type', function ($query) {
                return match ($query->product_type) {
                    'featured_product' => '<i class="badge bg-success">Featured Product</i>',
                    'top_product' => '<i class="badge bg-info">Top Product</i>',
                    'best_product' => '<i class="badge bg-warning">Best Product</i>',
                    'new_arrival' => '<i class="badge bg-danger">New Arrival</i>',
                    default => '<i class="badge bg-dark">None</i>',
                };
            })
            ->addColumn('status', function ($query) {
                return '<div class="form-check form-switch">
                        <input type="checkbox" name="status" id="vendor_product_status"
                            class="form-check-input change-status" ' .
                    ($query->status == 1 ? 'checked' : '') . ' data-id="' . $query->id . '">
                    </div>';
            })
            ->addColumn('approved', function ($query) {
                return match ($query->is_approved) {
                    1 => '<i class="badge bg-success">Approved</i>',
                    default => '<i class="badge bg-warning">Pending</i>',
                };
            })
            ->rawColumns(['name', 'image', 'action', 'status', 'type', 'approved'])
            ->setRowId('id');
    }

    /**
     * @param $string
     * @param $col_name
     * @param int $length
     * @return string
     */
    protected function truncateColStr($string, $col_name, $length = 20): string
    {
        if (strlen($string) > $length) {
            return '<span class="truncate_' . $col_name . '" data-full-text="' .
                htmlentities($string) . '">' . substr($string, 0, $length) .
                '...</span><span class="toggle-full-name" style="cursor: pointer">(+)</span>';
        } else {
            return $string;
        }
    }

    /**
     * Get the query source of dataTable.
     * Fetch only users with corresponding vendor id
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()->where('vendor_id', '=', Auth::user()->vendor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
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
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('image')->width(150),
            Column::make('name'),
            Column::make('price'),
            Column::make('approved'),
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
        return 'VendorProduct_' . date('YmdHis');
    }
}
