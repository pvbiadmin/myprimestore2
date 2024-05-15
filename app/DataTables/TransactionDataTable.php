<?php

namespace App\DataTables;

use App\Models\GeneralSetting;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransactionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $currency_name_base = GeneralSetting::query()->first()->currency_name ?? '';

        return (new EloquentDataTable($query))
            ->addColumn('invoice_id', function ($query) {
                return $query->order->invoice_id;
            })
            ->addColumn('payment_method', function ($query) {
                return ucfirst($query->payment_method);
            })
            ->addColumn('ordered_amount', function ($query) use ($currency_name_base) {
                return  number_format($query->amount_base_currency, 2) . ' ' . $currency_name_base;
            })
            ->addColumn('paid_amount', function ($query) {
                return  number_format($query->amount_used_currency, 2) . ' ' . $query->name_used_currency;
            })
            ->filterColumn('invoice_id', function ($query, $keyword) {
                $query->whereHas('order', function ($query) use ($keyword) {
                    $query->where('invoice_id', 'like', "%$keyword%");
                });
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('transaction-table')
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
            Column::make('transaction_id'),
            Column::make('payment_method'),
            Column::make('ordered_amount'),
            Column::make('paid_amount'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Transaction_' . date('YmdHis');
    }
}
