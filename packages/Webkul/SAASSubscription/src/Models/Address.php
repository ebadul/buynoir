<?php

namespace Webkul\SAASSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\SAASSubscription\Contracts\Address as AddressContract;

class Address extends Model implements AddressContract
{
    protected $table = 'saas_subscription_billing_addresses';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'city',
        'state',
        'postcode',
        'country',
        'phone',
        'saas_subscription_recurring_profile_id',
        'saas_subscription_invoice_id',
        'company_id',
    ];

    /**
     * Get of the customer fullname.
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the recurring profile that owns the purchased plan.
     */
    public function recurring_profile()
    {
        return $this->belongsTo(RecurringProfileProxy::modelClass(), 'saas_subscription_recurring_profile_id');
    }
}