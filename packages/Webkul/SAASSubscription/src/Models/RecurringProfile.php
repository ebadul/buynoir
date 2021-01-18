<?php

namespace Webkul\SAASSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\SAASCustomizer\Models\CompanyProxy;
use Webkul\SAASSubscription\Contracts\RecurringProfile as RecurringProfileContract;

class RecurringProfile extends Model implements RecurringProfileContract
{
    protected $table = 'saas_subscription_recurring_profiles';

    protected $fillable = [
        'reference_id',
        'state',
        'type',
        'payment_status',
        'schedule_description',
        'period_unit',
        'tin',
        'amount',
        'payment_method',
        'cycle_expired_on',
        'next_due_date',
        'saas_subscription_invoice_id',
        'company_id'
    ];

    protected $casts = [
        'next_due_date'    => 'date',
        'cycle_expired_on' => 'date',
    ];

    /**
     * Get the purchased plan for this recurring profile.
    */
    public function purchased_plan()
    {
        return $this->hasOne(PurchasedPlanProxy::modelClass(), 'saas_subscription_recurring_profile_id');
    }

    /**
     * Get the billing address for this recurring profile.
    */
    public function billing_address()
    {
        return $this->hasOne(AddressProxy::modelClass(), 'saas_subscription_recurring_profile_id');
    }

    /**
     * Get the invoice that owns the recurring profile.
     */
    public function invoice()
    {
        return $this->belongsTo(InvoiceProxy::modelClass(), 'saas_subscription_invoice_id');
    }

    /**
     * Get the company that owns the recurring profile.
     */
    public function company()
    {
        return $this->belongsTo(CompanyProxy::modelClass(), 'company_id');
    }
}