<?php

namespace Webkul\SAASSubscription\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\SAASSubscription\Models\Plan::class,
        \Webkul\SAASSubscription\Models\RecurringProfile::class,
        \Webkul\SAASSubscription\Models\Invoice::class,
        \Webkul\SAASSubscription\Models\PurchasedPlan::class,
        \Webkul\SAASSubscription\Models\Address::class,
    ];
}