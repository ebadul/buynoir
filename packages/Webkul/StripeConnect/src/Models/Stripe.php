<?php

namespace Webkul\StripeConnect\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\StripeConnect\Contracts\Stripe as StripeContract;

class Stripe extends Model implements StripeContract
{
    protected $table = 'stripe_cards';

    protected $fillable = ['token', 'customer_id','last_four','fingerprint', 'misc'];
}