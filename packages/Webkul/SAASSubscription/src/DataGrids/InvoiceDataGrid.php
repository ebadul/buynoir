<?php

namespace Webkul\SAASSubscription\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class InvoiceDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('saas_subscription_invoices')
            ->addSelect('saas_subscription_invoices.*');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('saassubscription::app.super-user.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index'      => 'customer_email',
            'label'      => trans('saassubscription::app.super-user.datagrid.customer-email'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'customer_name',
            'label'      => trans('saassubscription::app.super-user.datagrid.customer-name'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'grand_total',
            'label'      => trans('saassubscription::app.super-user.datagrid.total'),
            'type'       => 'price',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'cycle_expired_on',
            'label'      => trans('saassubscription::app.super-user.datagrid.expired-on'),
            'type'       => 'datetime',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('saassubscription::app.super-user.datagrid.created-at'),
            'type'       => 'datetime',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('saassubscription::app.super-user.datagrid.view'),
            'method' => 'GET',
            'route'  => 'super.subscription.invoice.view',
            'icon'   => 'icon eye-icon',
        ]);
    }
}