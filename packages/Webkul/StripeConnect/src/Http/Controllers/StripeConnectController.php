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
use Company;

/**
 * StripeConnect Controller
 *
 * @author  Vivek Sharma <viveksh047@webkul.com> @vivek-webkul
 * @author  shaiv roy <shaiv.roy361@webkul.com>
 * @copyright 2019 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class StripeConnectController extends Controller
{
    protected $cart;

    protected $order;

    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    /**
     * StripeRepository object
     *
     * @var array
     */
    protected $stripeRepository;

    /**
     * To hold the Test stripe secret key
     */
    protected $stripeSecretKey = null;

    /**
     * Determine test mode
     */
    protected $testMode;

    /**
     * Determine if Stripe is active or Not
     */
    protected $active;

    /**
     * Statement descriptor string
     */
    protected $statementDescriptor;

    /**
     * Stripe Cart Repository Instance holder
     */
    protected $stripeCart;

     /**
     * InvoiceRepository object
     *
     * @var object
     */
    protected $invoiceRepository;

    /**
     * Helper object
     *
     * @var object
     */
    protected $helper;

    /**
     * Stripe Connect Repository Instance holder
    */
    protected $stripeConnect;


    protected $appName;

    /**
     * Create a new controller instance.
     *
     * @param  Webkul\Attribute\Repositories\OrderRepository  $orderRepository
     * @param  Webkul\StripeConnect\Repositories\StripeCartRepository  $stripeCart
     * @param  Webkul\StripeConnect\Repositories\StripeRepository  $stripeRepository
     * @param  Webkul\StripeConnect\Helpers\Helper  $helper
     * 
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        StripeCart $stripeCart,
        stripeRepository $stripeRepository,
        Helper $helper,
        StripeConnect $stripeConnect
    )
    {
        $this->helper = $helper;

        $this->orderRepository = $orderRepository;

        $this->stripeRepository = $stripeRepository;

        $this->stripeCart = $stripeCart;

        $this->stripeConnect = $stripeConnect;

        if ( company()->getSuperConfigData('sales.paymentmethods.stripe.active') == 1 ) {
            $this->appName      = 'Webkul Bagisto Stripe Payment Gateway';
            $this->partner_Id   = 'pp_partner_FLJSvfbQDaJTyY';

            Stripe::setApiVersion("2019-12-03");

            Stripe::setAppInfo(
                $this->appName,
                env('APP_VERSION'),
                env('APP_URL'),
                $this->partner_Id
            );

            if ( company()->getSuperConfigData('sales.paymentmethods.stripe.mode') == 1 ) {
                $this->stripeSecretKey = company()->getSuperConfigData('sales.paymentmethods.stripe.live_secret_key');
            } else {
                $this->stripeSecretKey = company()->getSuperConfigData('sales.paymentmethods.stripe.test_secret_key');
            }

            stripe::setApiKey($this->stripeSecretKey);
        }
    }

    /**
     * Redirects to the stripe.
     *
     * @return \Illuminate\View\View
    */
    public function redirect()
    {
        if ( empty($this->stripeSecretKey)) {
            session()->flash('error', trans('stripe_saas::app.shop.checkout.total.provide-api-key'));

            return redirect()->route('shop.checkout.cart.index');
        } else {
            if ( (core()->getCurrentChannel() && core()->getCurrentChannel()->theme == "velocity")) {
                return view('stripe_saas::shop.velocity.checkout.card');
            } else {
                return view('stripe_saas::shop.default.checkout.card');
            }
        }
    }

    /**
     * Save card after payment using new card.
     *
     * @return Json
    */
    public function saveCard()
    {
        try {
            $customerResponse = \Stripe\Customer::create([
                'description'   => 'Customer for ' . Cart::getCart()->customer_email,
                'source'        => request()->stripetoken, // obtained with Stripe.js
            ]);

            $payment_method     = \Stripe\PaymentMethod::retrieve(request()->paymentMethodId);
            $attachedCustomer   = $payment_method->attach(['customer' => $customerResponse->id]);
            $last4              = request()->result['paymentMethod']['card']['last4'];

            $response = [
                'customerResponse'  => $customerResponse,
                'attachedCustomer'  => $attachedCustomer,
            ];

            if ( auth()->guard('customer')->check() ) {
                $getStripeRepository = $this->stripeRepository->findOneWhere([
                    'last_four'     => $last4,
                    'customer_id'   => auth()->guard('customer')->user()->id,
                ]);

                if ( isset($getStripeRepository) ) {
                    $getStripeRepository->update(['misc'=> json_encode($response)]);
                } else {
                    $result = $this->stripeRepository->create([
                        'customer_id'   => auth()->guard('customer')->user()->id,
                        'token'         => request()->stripetoken,
                        'last_four'     => $last4,
                        'misc'          => json_encode($response),
                    ]);
                }

                $this->stripeCart->create([
                    'cart_id'       => Cart::getCart()->id,
                    'stripe_token'  => json_encode($response),
                ]);
            } else {
                $this->stripeCart->create([
                    'cart_id'       => Cart::getCart()->id,
                    'stripe_token'  => json_encode($response),
                ]);
            }

            return response()->json([
                'customerId'        => $customerResponse->id,
                'paymentMethodId'   => request()->paymentMethodId,
            ]);
        
        } catch(\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            session()->flash('error', $e->getError()->message);
            
            return response()->json([
                'message' => $e->getError()->message,
            ]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            session()->flash('error', $e->getError()->message);

            return response()->json([
                'message' => $e->getError()->message,
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            session()->flash('error', $e->getError()->message);
        
            return response()->json([
                'message' => $e->getError()->message,
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            session()->flash('error', $e->getError()->message);

            return response()->json([
                'message' => $e->getError()->message,
            ]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            session()->flash('error', $e->getError()->message);

            return response()->json([
                'message' => $e->getError()->message,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            session()->flash('error', $e->getError()->message);

            return response()->json([
                'message' => $e->getError()->message,
            ]);
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            session()->flash('error', $e->getError()->message);

            return response()->json([
                'message' => trans('stripe_saas::app.shop.checkout.total.something-went-wrong'),
            ]);
        }
    }

    /**
     * Generate payment using saved card
     *
     * @return Json
    */
    public function savedCardPayment()
    {
        $company = Company::getCurrent();

        try {
            $stripeConnect = $this->stripeConnect->findOneWhere([
                'company_id' => $company->id
            ]);
    
            if ( isset($stripeConnect->id) ) {
                $sellerUserId = $stripeConnect->stripe_user_id;
            } else {
                session()->flash('warning', 'Stripe unavailable for this seller');
    
                return redirect()->route('shop.checkout.success');
            }

            $selectedId = request()->savedCardSelectedId;

            $savedCard = $this->stripeRepository->findOneWhere([
                'id' => $selectedId,
            ]);

            $miscDecoded = json_decode($savedCard->misc);

            $stripeId           = '';
            $payment            = $this->helper->productDetail();
            $customerId         = $miscDecoded->customerResponse->id;
            $paymentMethodId    = $miscDecoded->attachedCustomer->id;

            $savedCardPayment = $this->helper->stripePayment($payment, $stripeId, $paymentMethodId, $customerId, $sellerUserId);

            if ($savedCard) {
                return response()->json([
                    'customer_id'       => $miscDecoded->customerResponse->id,
                    'payment_method_id' => $miscDecoded->attachedCustomer->id,
                    'savedCardPayment'  => $savedCardPayment,
                    ]);
            } else {
                return response()->json(['sucess' => 'false'],404);
            }
        } catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * Collect stripe token from client side
     *
     * @return json
    */
    public function collectToken()
    {
        $company    = Company::getCurrent();
        
        $stripeConnect = $this->stripeConnect->findOneWhere([
            'company_id' => $company->id
            ]);

        if ( isset($stripeConnect->id) ) {
            $sellerUserId = $stripeConnect->stripe_user_id;
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

        $intent = $this->helper->stripePayment($payment, $stripeId, $paymentMethodId, $customerId, $sellerUserId);

        if ( $intent ) {
            return response()->json(['client_secret' => $intent->client_secret]);
        } else {
            return response()->json(['success' => 'false'], 400);
        }
    }

    /**
     * Prepares order's
     *
     * @return json
    */
    public function createCharge()
    {      
        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        $this->order = $this->orderRepository->findOneWhere([
            'cart_id' => Cart::getCart()->id
        ]);

        $this->orderRepository->update(['status' => 'processing'], $this->order->id);

        
        $this->invoiceRepository = app('Webkul\Sales\Repositories\InvoiceRepository');

        if ($this->order->canInvoice()) {
            $invoice = $this->invoiceRepository->create($this->prepareInvoiceData());

            $this->invoiceRepository->update([
                    'grand_total' => $this->order->grand_total,
                    'base_grand_total' => $this->order->base_grand_total
            ], $invoice->id);

            $this->orderRepository->update([
                    'grand_total_invoiced' => $this->order->grand_total,
                    'base_grand_total_invoiced' => $this->order->base_grand_total
            ], $this->order->id);
        }

        Cart::deActivateCart();

        session()->flash('order', $order);

        return response()->json([
            'data' => [
                'route' => route("shop.checkout.success"),
                'success' => true
            ]
        ]);
    }

     /**
     * Prepares order's invoice data for creation
     *
     * @return array
     */
    public function prepareInvoiceData()
    {
        $invoiceData = [
            "order_id" => $this->order->id
        ];

        foreach ($this->order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    /**
     * Delete the selected stripe card
     *
     * @return string
    */
    public function deleteCard()
    {
        $deleteIfFound = $this->stripeRepository->findOneWhere(['id' => request()->input('id'), 'customer_id' => auth()->guard('customer')->user()->id]);

        $result = $deleteIfFound->delete();

        return (string)$result;
    }

    /**
     * On payment cancel
     *
     * @return response
    */
    public function paymentCancel()
    {
        session()->flash('error', trans('stripe_saas::app.shop.checkout.total.payment-failed'));

        return response()->json([
            'data' => [
                'route' => route("shop.checkout.cart.index"),
                'success' => true
            ]
        ]);
    }
}
