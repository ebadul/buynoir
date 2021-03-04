<?php

namespace Webkul\StripeConnect\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\StripeConnect\Contracts\StripeConnect as StripeConnectContract;
use Webkul\StripeConnect\Models\StripeConnect as StripeConnectModel;
use Company;

class StripeConnect extends StripeConnectModel implements StripeConnectContract
{
  
}