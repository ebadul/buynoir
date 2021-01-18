<?php

namespace Webkul\SAASSubscription\Http\Controllers\Super;

use Webkul\SAASSubscription\Http\Controllers\Controller;
use Webkul\SAASSubscription\Helpers\Ipn;

class IpnController extends Controller
{
    /**
     * Ipn object
     *
     * @var \Webkul\SAASSubscription\Helpers\Ipn
     */
    protected $ipnHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SAASSubscription\Helpers\Ipn  $ipnHelper
     * @return void
     */
    public function __construct(Ipn $ipnHelper)
    {
        $this->ipnHelper = $ipnHelper;
    }

    /**
     * Paypal ipn  review controller action
     *
     * @return \Illuminate\Http\Response
     */
    public function paypalIpnListener()
    {
        if (request()->isMethod('post')) {
            $this->ipnHelper->processIpnRequest($_POST);
        } else {
            return view('saassubscription::ipn-form');
        }
    }

    /**
     * Paypal ipn  review controller action
     *
     * @return \Illuminate\Http\Response
     */
    public function paypalIpnListenerTest()
    {
        $postString = "mc_gross=15.00&period_type= Regular&outstanding_balance=0.00&next_payment_date=03:00:00 May 04, 2020 PDT&protection_eligibility=Eligible&payment_cycle=Monthly&address_status=confirmed&tax=0.00&payer_id=A7DYX2C2G57NY&address_street=17 frater avenue&payment_date=04:55:58 Apr 04, 2020 PDT&payment_status=Completed&product_name=Pro&charset=windows-1252&recurring_payment_id=I-05576ATRPU51&address_zip=2323&first_name=Cody&mc_fee=1.12&address_country_code=AU&address_name=Oz Grade&notify_version=3.9&amount_per_cycle=15.00&payer_status=verified&currency_code=USD&business=pay@uvdesk.in&address_country=Australia&address_city=tenambit&verify_sign=AKK8lOPCmJkhmRjOUcdfUJ7Huhc5AzR4CwnB6l2k.xhBAIC2H-r3df72&payer_email=sales@ozgrade.com&initial_payment_amount=0.00&profile_status=Active&amount=15.00&txn_id=406158941P3731170D&payment_type=instant&payer_business_name=Oz Grade&last_name=James&address_state=NSW&receiver_email=pay@uvdesk.in&payment_fee=1.12&receiver_id=D2UEGTKPBHTLY&txn_type=recurring_payment&mc_currency=USD&residence_country=AU&transaction_subject=Pro&payment_gross=15.00&shipping=0.00&product_type=1&time_created=01:57:59 Mar 04, 2020 PST&ipn_track_id=d9eb61ddd87ce";

        $data = []; //$_POST;

        foreach (explode("&", $postString) as $key => $value) {
            $row = explode("=" ,$value);

            $data[$row[0]] = $row[1];
        }

        $this->ipnHelper->processIpnRequest($data);

        dd($data);
    }
}