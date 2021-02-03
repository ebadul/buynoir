<?php
namespace Webkul\StripeConnect\Helpers;

use Webkul\Checkout\Facades\Cart;
use Webkul\StripeConnect\Repositories\StripeRepository;
use Stripe\PaymentIntent as PaymentIntent;

class Helper {

    /**
     * StripeRepository object
     *
     * @var array
     */
    protected $stripeRepository;


    public function __construct(stripeRepository $stripeRepository)
    {
        $this->stripeRepository = $stripeRepository;

        if (core()->getConfigData('sales.paymentmethods.stripe.statement_descriptor')) {
            $this->statementDescriptor = core()->getConfigData('sales.paymentmethods.stripe.statement_descriptor');
        } else {
            $this->statementDescriptor = 'Stripe Connect';
        }


    }

    /**
     * Seperate seller according to their product
     *
     *
     * @return array
     */
    public function productDetail()
    {
        return null;
    }

     /**
     * Create payment for stripe
     *
     *
     * @return boolean
     */
    public function stripePayment($payment='', $stripeId = '', $paymentMethodId='', $customerId = '', $sellerUserId = '')
    {
        $cart   = Cart::getCart();

        if ( core()->getConfigData('sales.paymentmethods.stripe.fees') == 'customer' && isset($cart->payment) && $cart->payment->method == 'stripe' ) {
            
            try {
                $applicationFee = $cart->base_grand_total;
                $applicationFee = (0.029 * $applicationFee) + (0.02 * $applicationFee) + 0.3;

                $cart->update([
                    'base_grand_total'  => $cart->base_grand_total + $applicationFee,
                    'grand_total'       => $cart->grand_total + core()->convertPrice($applicationFee),
                ]);    

                if  ( $customerId != '' ) {
                    $result = PaymentIntent::create([
                        'amount'               => round($cart->grand_total, 2) * 100,
                        'customer'             => $customerId,
                        'currency'             => $cart->cart_currency_code,
                        'statement_descriptor' => $this->statementDescriptor,
                        "description"          => "Cart Id ".Cart::getCart()->id,
                        'receipt_email'        => $cart->customer_email,
                        'transfer_data'        => [
                                  'destination'    => $sellerUserId,
                        ],
                    ]);
                } else {
                    $result = PaymentIntent::create([
                        'amount'                => round($cart->grand_total, 2) * 100,
                        'currency'              => $cart->cart_currency_code,
                        'payment_method_types'  => ['card'],
                        'statement_descriptor'  => $this->statementDescriptor,
                        "description"           => "Cart Id ".Cart::getCart()->id,
                        'receipt_email'         => $cart->customer_email,
                        'transfer_data'         => [
                                    'destination'   => $sellerUserId,
                                ],
                    ]);
                }
            } catch (Exception $e) {
                return $e;
            }
        } else {
            try {
                if  ( $customerId != '' ) {
                    $result = PaymentIntent::create([
                        'amount'               => round($cart->grand_total, 2) * 100,
                        'customer'             => $customerId,
                        'statement_descriptor' => $this->statementDescriptor,
                        "description"          => "Cart Id ".Cart::getCart()->id,
                        'currency'             => $cart->cart_currency_code,
                        'receipt_email'        => $cart->customer_email,
                        'transfer_data'        => [
                                  'destination'    => $sellerUserId,
                        ],
                    ]);
                } else {
                    $result = PaymentIntent::create([
                        'amount'                => round($cart->grand_total, 2) * 100,
                        'currency'              => $cart->cart_currency_code,
                        'payment_method_types'  => ['card'],
                        'statement_descriptor'  => $this->statementDescriptor,
                        "description"           => "Cart Id ".Cart::getCart()->id,
                        'receipt_email'         => $cart->customer_email,
                        'transfer_data'         => [
                                    'destination'   => $sellerUserId,
                                ],
                    ]);
                }
            } catch (\Exception $e) {
                return $e;
            }   
        }
        
        return $result;
    }

    public function deleteCardIfPaymentNotDone($getCartDecode)
    {
        if ( isset($getCartDecode->stripeReturn->last4) ) {
            $this->stripeRepository->deleteWhere([
                'last_four' => $getCartDecode->stripeReturn->last4
            ]);
        }
    }
}