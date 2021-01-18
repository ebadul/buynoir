<?php

namespace Webkul\SAASSubscription\Repositories;

use Webkul\Core\Eloquent\Repository;

class PurchasedPlanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'Webkul\SAASSubscription\Contracts\PurchasedPlan';
    }
}