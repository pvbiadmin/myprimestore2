<?php

namespace App\DataTables;

use App\Models\Order;
use Auth;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorOrderDataTable extends DataTable
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
                return '<a href="' . route('vendor.orders.show', $query->id) .
                    '" class="btn btn-primary"><i class="far fa-eye"></i></a>';
            })
            ->addColumn('customer', function ($query) {
                return $query->user->name;
            })
            ->addColumn('amount', function ($query) {
                return $query->currency_icon . number_format($query->amount, 2);
            })
            ->addColumn('payment', function ($query) {
                return ucwords($query->payment_method);
            })
            ->addColumn('qty', function ($query) {
                return $query->product_quantity;
            })
            ->addColumn('date', function ($query) {
                return date('d-M-Y', strtotime($query->created_at));
            })
            ->addColumn('order_status', function ($query) {
                foreach (config('order_status.admin') as $key => $arr) {
                    if ($query->order_status === $key) {
                        $badge = match ($key) {
                            'cancelled' => 'warning text-dark',
                            'processed_and_ready_to_ship' => 'secondary',
                            'dropped_off' => 'primary',
                            'shipped' => 'dark',
                            'out_for_delivery' => 'info text-dark',
                            'delivered' => 'success',
                            default => 'danger'
                        };

                        return '<span class="badge bg-' . $badge . '">' . $arr['status'] . '</span>';
                    }
                }

                return '<span class="badge badge-danger">' .
                    config('order_status.admin')['pending']['status'] . '</span>';
            })
            ->addColumn('payment_status', function ($query) {
                $badge = match ($query->payment_status) {
                    1 => ['badge' => 'success', 'status' => 'Completed'],
                    default => ['badge' => 'danger', 'status' => 'Pending']
                };

                return '<span class="badge bg-' . $badge['badge'] . '">' . $badge['status'] . '</span>';
            })
            ->rawColumns(['action', 'order_status', 'payment_status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery()->whereHas('orderProducts', function ($query) {
            $query->where('vendor_id', '=', Auth::user()->vendor->id);
        });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendororder-table')
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
            Column::make('invoice_id'),
            Column::make('customer'),
            Column::make('date'),
            Column::make('qty'),
            Column::make('amount'),
            Column::make('payment'),
            Column::make('payment_status'),
            Column::make('order_status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorOrder_' . date('YmdHis');
    }
}
