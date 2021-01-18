<?php

namespace Webkul\SAASSubscription\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webkul\SAASSubscription\Http\Controllers\Controller;
use Webkul\SAASSubscription\Helpers\Subscription;
use Webkul\SAASSubscription\Helpers\Paypal;

class PaypalController extends Controller
{
    /**
     * Subscription object
     *
     * @var \Webkul\SAASSubscription\Helpers\Subscription
     */
    protected $subscriptionHelper;

    /**
     * Paypal object
     *
     * @var \Webkul\SAASSubscription\Helpers\Paypal
     */
    protected $paypalHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SAASSubscription\Helpers\Subscription  $subscriptionHelper
     * @param  \Webkul\SAASSubscription\Helpers\Paypal  $paypalHelper
     * @return void
     */
    public function __construct(
        Subscription $subscriptionHelper,
        Paypal $paypalHelper
    )
    {
        $this->subscriptionHelper = $subscriptionHelper;

        $this->paypalHelper = $paypalHelper;

        $this->_config = request('_config');
    }

    /**
     * Payment review controller action
     *
     * @return \Illuminate\Http\Response
     */
    public function review()
    {
        $data = request()->all();

        if (! session()->has('subscription_cart') && ! isset($data['token'])) {
            return redirect()->route($this->_config['redirect']);
        }

        $nvps = "&USER=" . company()->getSuperConfigData('subscription.payment.paypal.user_name')
                . "&PWD=" . company()->getSuperConfigData('subscription.payment.paypal.password')
                . "&SIGNATURE=" . company()->getSuperConfigData('subscription.payment.paypal.signature')
                . "&METHOD=GetExpressCheckoutDetails" 
                . "&VERSION=108" 
                . "&TOKEN=" . $data['token'];
        
        $getEC = $this->paypalHelper->request($nvps);

        if (isset($data['PayerID'])) {
            session()->put('PayerID', $data['PayerID']);
        } else {
            session()->put('PayerID', $getEC['PAYERID']);
        }

        session()->put('token', $data['token']);
        
        return redirect()->route('admin.subscription.paypal.payment');
    }

    /**
     * Payment cancel controller action
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('warning', trans('saassubscription::app.super-user.plans.payment-cancel'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * This action is responsible for praparing the SetExpressCheckout paypal method
     * 
     * @return \Illuminate\Http\Response
     */
    public function start()
    {
        $cart = session()->get('subscription_cart');

        $nvps = "&USER=" . company()->getSuperConfigData('subscription.payment.paypal.user_name')
                . "&PWD=" . company()->getSuperConfigData('subscription.payment.paypal.password')
                . "&SIGNATURE=" . company()->getSuperConfigData('subscription.payment.paypal.signature')
                . "&METHOD=SetExpressCheckout"
                . "&VERSION=108"
                . "&RETURNURL=" . urlencode(route('admin.subscription.paypal.review'))
                . "&CANCELURL=" . urlencode(route('admin.subscription.paypal.cancel'))
                . "&_CURRENCYCODE=" . config('app.currency')
                . "&PAYMENTACTION=Authorization"
                . "&L_BILLINGTYPE0=RecurringPayments"
                . "&L_BILLINGAGREEMENTDESCRIPTION0=" . $cart['plan']->name;
        
        $getEC = $this->paypalHelper->request($nvps);

        if ($getEC['ACK'] == 'Success') {
            $paypalmode = company()->getSuperConfigData('subscription.payment.paypal.sandbox_mode')
                          ? '.sandbox'
                          : '';
            
            return redirect("https://www" . $paypalmode . ".paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=" . $getEC['TOKEN']);
        } else {
            if (isset($getEC['L_LONGMESSAGE0'])) {
                session()->flash('warning', $getEC['L_LONGMESSAGE0']);
            } else {
                session()->flash('warning', trans('saassubscription::app.super-user.plans.generic-error'));
            }

            return redirect()->route($this->_config['redirect']);
        }
    }

    /**
     * This action is responsible for creating paypal recurring profile if success
     * 
     * @return \Illuminate\Http\Response
     */
    public function createProfile()
    {
        $cart = session()->get('subscription_cart');

        if (! $cart) {
            return redirect()->route('admin.subscription.plan.index');
        }

        $nvpdo = "&USER=" . company()->getSuperConfigData('subscription.payment.paypal.user_name')
                . "&PWD=" . company()->getSuperConfigData('subscription.payment.paypal.password')
                . "&SIGNATURE=" . company()->getSuperConfigData('subscription.payment.paypal.signature')
                . "&METHOD=CreateRecurringPaymentsProfile" 
                . "&VERSION=108" 
                . "&EMAIL=" . urlencode($cart['address']['email'])
                . "&FIRSTNAME=" . urlencode($cart['address']['first_name'])
                . "&LASTNAME=" . urlencode($cart['address']['last_name'])
                . "&STREET=" . urlencode($cart['address']['address1'])
                . "&CITY=" . urlencode($cart['address']['city'])
                . "&STATE=" . urlencode($cart['address']['state'])
                . "&ZIP=" . urlencode($cart['address']['postcode'])
                . "&COUNTRYCODE=" . urlencode($cart['address']['country'])
                . "&PAYMENTACTION=Sale"
                . "&TOKEN=" . session()->get('token')
                . "&PAYERID=" . session()->get('PayerID')
                . "&PROFILESTARTDATE=" . gmdate("Y-m-d\TH:i:s\Z")
                . "&DESC=" . $cart['plan']->name
                . "&BILLINGPERIOD=" . ucfirst($cart['period_unit'])
                . "&BILLINGFREQUENCY=1"
                . "&AUTOBILLOUTAMT=AddToNextBilling"
                . "&PROFILEREFERENCE=BookingCommerce"
                . "&AMT=" . round($cart['amount'], 2)
                . "&CURRENCYCODE=" . config('app.currency')
                . "&L_PAYMENTREQUEST_0_ITEMCATEGORYn=Digital" 
                . "&L_PAYMENTREQUEST_0_NAMEn=" . $cart['plan']->name 
                . "&L_PAYMENTREQUEST_0_AMTn=" . round($cart['amount'], 2)
                . "&L_PAYMENTREQUEST_0_QTYn=1"
                . "&MAXFAILEDPAYMENTS=2";
        
        $doEC = $this->paypalHelper->request($nvpdo);

        if ($doEC['ACK'] == "Success") {
            $this->subscriptionHelper->createRecurringProfile($doEC);

            session()->forget('subscription_cart');

            session()->flash('success', trans('saassubscription::app.super-user.plans.profile-created-success'));

            return redirect()->route($this->_config['redirect']);
        } else {
            session()->flash('error', $doEC['L_LONGMESSAGE0']);

            return redirect()->route('admin.subscription.plan.index');
        }
    }
}