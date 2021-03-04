<?php

namespace Webkul\StripeConnect\Http\Controllers;

use Webkul\StripeConnect\Http\Controllers\Controller;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\StripeConnect\Repositories\StripeCartRepository as StripeCart;
use Webkul\StripeConnect\Repositories\StripeRepository;
use Stripe\Stripe as Stripe;
use Webkul\StripeConnect\Helpers\Helper;
use Webkul\StripeConnect\Repositories\StripeConnectRepository as StripeConnect;
use Webkul\StripeConnect\Http\Controllers\StripeConnectController as WebkulStripeConnect;
use Company;

/**
 * StripeConnect Controller
 *
 * @author  Vivek Sharma <viveksh047@webkul.com> @vivek-webkul
 * @author  shaiv roy <shaiv.roy361@webkul.com>
 * @copyright 2019 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ExtendStripeConnectController extends WebkulStripeConnect
{
   
    public function collectToken()
    {
        $company    = Company::getCurrent();
        
        $stripeConnect = $this->stripeConnect->findOneWhere([
            'company_id' => $company->id
            ]);

        if ( isset($stripeConnect->id) ) {
            
            $sellerUser = (object) array_merge((array) $company, (array) $stripeConnect);
            
        } else {
            session()->flash('warning', 'Stripe unavailable for this tenant.');

            return redirect()->route('shop.checkout.success');
        }

        $stripeId   = '';
        $payment    = $this->helper->productDetail();

        $stripeToken = $this->stripeCart->findOneWhere([
            'cart_id'   => Cart::getCart()->id,
        ])->first()->stripe_token;  

        $decodeStripeToken = json_decode($stripeToken);

        $customerId =  NULL;

        $paymentMethodId = $decodeStripeToken->attachedCustomer->id;

        $intent = $this->helper->stripePayment($payment, $stripeId, $paymentMethodId, $customerId, $sellerUser);

        if ( $intent ) {
            return response()->json(['client_secret' => $intent->client_secret]);
        } else {
            return response()->json(['success' => 'false'], 400);
        }
    }

    
}
