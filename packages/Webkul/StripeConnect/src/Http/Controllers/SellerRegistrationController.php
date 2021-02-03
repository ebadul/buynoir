<?php

namespace Webkul\StripeConnect\Http\Controllers;

use Webkul\StripeConnect\Http\Controllers\Controller;
use Webkul\StripeConnect\Repositories\StripeConnectRepository;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Stripe\Stripe;
use Company;

/**
 * Seller Registration controller
 *
 * @author  Vivek Sharma <viveksh047@webkul.com> @vivek-webkul
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class SellerRegistrationController extends Controller
{
    /**
     * StripeConnectRepository Instance
     */
    protected $stripeConnectRepository;

    public function __construct(StripeConnectRepository $stripeConnectRepository)
    {
        $this->stripeConnectRepository = $stripeConnectRepository;

        if ( company()->getSuperConfigData('sales.paymentmethods.stripe.active') == 1 ) {
            if ( company()->getSuperConfigData('sales.paymentmethods.stripe.mode') == 1 ) {
                Stripe::setApiKey(company()->getSuperConfigData('sales.paymentmethods.stripe.live_secret_key'));
            } else {
                Stripe::setApiKey(company()->getSuperConfigData('sales.paymentmethods.stripe.test_secret_key'));
            }
        }
    }

    public function index()
    {
        $company = Company::getCurrent();

        $stripeConnect = $this->stripeConnectRepository->findOneWhere([
            'company_id' => $company->id
            ]);
        
        $client_id = company()->getSuperConfigData('sales.paymentmethods.stripe.client_id');

        return view('stripe_saas::admin.connect', compact('stripeConnect', 'client_id'));
    }

    /**
     * To process the retrieved token after the seller's onboarding
     * on platform account
     */
    public function retrieveToken()
    {
        if (! request()->has('error')) {
            $code       = request()->input('code');
            $mode       = company()->getSuperConfigData('sales.paymentmethods.stripe.mode');
            $secret_key = company()->getSuperConfigData('sales.paymentmethods.stripe.test_secret_key');

            if ( $mode == 1 ) {
                $secret_key = company()->getSuperConfigData('sales.paymentmethods.stripe.live_secret_key');
            }

            $client = new Client(); //GuzzleHttp\Client
            $result = $client->post('https://connect.stripe.com/oauth/token', [
                'auth'          => [$secret_key, ''],
                'form_params'   => [
                    'code'          => $code,
                    'grant_type'    => 'authorization_code'
                ]
            ]);

            $decoded            = json_decode($result->getBody()->getContents());
            $access_token       = $decoded->access_token;
            $refresh_token      = $decoded->refresh_token;
            $publishable_key    = $decoded->stripe_publishable_key;
            $stripe_user_id     = $decoded->stripe_user_id;

            $result = $this->stripeConnectRepository->create([
                'access_token'              => $access_token,
                'refresh_token'             => $refresh_token,
                'stripe_publishable_key'    => $publishable_key,
                'stripe_user_id'            => $stripe_user_id
            ]);

            if ( $result ) {
                session()->flash('success', trans('stripe_saas::app.admin.stripe.account-connected'));
            } else {
                session()->flash('error', trans('stripe_saas::app.admin.stripe.problem-connecting'));
            }
        } else {
            session()->flash('error', request()->input('error_description'));
        }

        return redirect()->route('admin.stripe.seller');
    }

    public function revokeAccess()
    {
        $company    = Company::getCurrent();
        $client_id  = company()->getSuperConfigData('sales.paymentmethods.stripe.client_id');
        $mode       = company()->getSuperConfigData('sales.paymentmethods.stripe.mode');
        $secret_key = company()->getSuperConfigData('sales.paymentmethods.stripe.test_secret_key');

        if ( $mode == 1 ) {
            $secret_key = company()->getSuperConfigData('sales.paymentmethods.stripe.live_secret_key');
        }
        
        $stripeConnectDetails = $this->stripeConnectRepository->findOneWhere([
            'company_id' => $company->id
        ]);
        
        $client = new Client(); //GuzzleHttpq\Client
        try {
            $result = $client->post('https://connect.stripe.com/oauth/deauthorize', [
                'auth'          => [$secret_key, ''],
                'form_params'   => [
                    'client_id'         => $client_id,
                    'stripe_user_id'    => $stripeConnectDetails->stripe_user_id
                ]
            ]);

            if ($result->getStatusCode() == 200) {
                $stripeConnectDetails->delete();

                session()->flash('success', trans('stripe_saas::app.admin.stripe.stripe-revoked'));
            } else {
                session()->flash('error', $result->getBody());
            }
        } catch (GuzzleException $e) {
            $stripeConnectDetails->delete();

            session()->flash('success', trans('stripe_saas::app.admin.stripe.stripe-revoked'));
            session()->flash('info', $e->getMessage());
        }

        return redirect()->route('admin.stripe.seller');
    }
}