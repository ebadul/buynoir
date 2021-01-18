<?php

namespace Webkul\SAASSubscription\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class PlanDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('saas_subscription_plans')
            ->addSelect('saas_subscription_plans.*');

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
            'index'      => 'code',
            'label'      => trans('saassubscription::app.super-user.datagrid.code'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('saassubscription::app.super-user.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index'      => 'monthly_amount',
            'label'      => trans('saassubscription::app.super-user.datagrid.monthly-amount'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'wrapper'    => function($value) {
                return core()->formatPrice($value->monthly_amount, config('app.currency'));
            },
        ]);

        $this->addColumn([
            'index'      => 'yearly_amount',
            'label'      => trans('saassubscription::app.super-user.datagrid.yearly-amount'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'wrapper'    => function($value) {
                return core()->formatPrice($value->yearly_amount, config('app.currency'));
            },
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('saassubscription::app.super-user.datagrid.status'),
            'type'       => 'boolean',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function($value) {
                if ($value->status == 1) {
                    return '<span class="badge badge-md badge-success">' . trans('saassubscription::app.super-user.datagrid.active') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">' . trans('saassubscription::app.super-user.datagrid.inactive') . '</span>';
                }
            }
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('saassubscription::app.super-user.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'super.subscription.plan.edit',
            'icon'   => 'icon pencil-lg-icon'
        ]);

        $this->addAction([
            'title'  => trans('saassubscription::app.super-user.datagrid.delete'),
            'method' => 'POST',
            'route'  => 'super.subscription.plan.delete',
            'icon'   => 'icon trash-icon'
        ]);
    }
}