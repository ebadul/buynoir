<?php

namespace Webkul\SAASSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\SAASSubscription\Contracts\Plan as PlanContract;

class Plan extends Model implements PlanContract
{
    protected $table = 'saas_subscription_plans';

    protected $fillable = [
        'code',
        'name',
        'description',
        'monthly_amount',
        'yearly_amount',
        'allowed_products',
        'allowed_categories',
        'allowed_attributes',
        'allowed_attribute_families',
        'allowed_channels',
        'allowed_orders',
        'status',
    ];
}