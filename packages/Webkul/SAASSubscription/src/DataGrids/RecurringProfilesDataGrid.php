<?php

namespace Webkul\SAASSubscription\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class RecurringProfilesDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('saas_subscription_recurring_profiles')
            ->addSelect('saas_subscription_recurring_profiles.*', 'companies.name')
            ->leftJoin('companies', 'saas_subscription_recurring_profiles.company_id', '=', 'companies.id');

        $this->addFilter('id', 'saas_subscription_recurring_profiles.id');

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
            'index'      => 'name',
            'label'      => trans('saassubscription::app.super-user.datagrid.company-name'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'schedule_description',
            'label'      => trans('saassubscription::app.super-user.datagrid.plan-name'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
            'wrapper'    => function($value) {
                if ($value->type != 'trial') {
                    return $value->schedule_description;
                } 
                
                return $value->schedule_description . ' - Trial';
            }
        ]);

        $this->addColumn([
            'index'      => 'amount',
            'label'      => trans('saassubscription::app.super-user.datagrid.amount'),
            'type'       => 'price',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'period_unit',
            'label'      => trans('saassubscription::app.super-user.datagrid.period-unit'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'state',
            'label'      => trans('saassubscription::app.super-user.datagrid.profile-state'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
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
            'route'  => 'super.subscription.recurring_profile.view',
            'icon'   => 'icon eye-icon',
        ]);
    }
}