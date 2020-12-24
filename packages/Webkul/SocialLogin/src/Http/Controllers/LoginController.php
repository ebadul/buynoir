<?php

namespace Webkul\SocialLogin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository;

class LoginController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * CustomerSocialAccountRepository
     *
     * @var \Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository
     */
    protected $customerSocialAccountRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository  $customerSocialAccountRepository
     * @return void
     */
    public function __construct(CustomerSocialAccountRepository $customerSocialAccountRepository)
    {
        $this->customerSocialAccountRepository = $customerSocialAccountRepository;

        $this->_config = request('_config');
    }

    /**
     * Redirects to the social provider
     *
     * @param  string  $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        $client_id = core()->getConfigData('customer.social_login.' . $provider . '.' . strtoupper($provider) . '_CLIENT_ID');
        $redirect_uri = core()->getConfigData('customer.social_login.' . $provider . '.' . strtoupper($provider) . '_CALLBACK_URL');

        try {
            return Socialite::driver($provider)->with([
                'client_id' => $client_id ? $client_id : config('services.'.$provider.'.client_id'),
                'redirect_uri' => $redirect_uri ? $redirect_uri : config('services.'.$provider.'.redirect')
            ])->redirect();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->route('customer.session.index');
        }
    }

    /**
     * Handles callback
     *
     * @param  string  $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $client_id = core()->getConfigData('customer.social_login.' . $provider . '.' . strtoupper($provider) . '_CLIENT_ID');
        $client_secret = core()->getConfigData('customer.social_login.' . $provider . '.' . strtoupper($provider) . '_CLIENT_SECRET');
        $redirect = core()->getConfigData('customer.social_login.' . $provider . '.' . strtoupper($provider) . '_CALLBACK_URL');

        config(['services.'.$provider.'.client_id' => $client_id ? $client_id : config('services.'.$provider.'.client_id')]);
        config(['services.'.$provider.'.client_secret' => $client_secret ? $client_secret : config('services.'.$provider.'.client_secret')]);
        config(['services.'.$provider.'.redirect' => $redirect ? $redirect : config('services.'.$provider.'.redirect')]);

        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('customer.session.index');
        }

        $customer = $this->customerSocialAccountRepository->findOrCreateCustomer($user, $provider);

        auth()->guard('customer')->login($customer, true);

        // Event passed to prepare cart after login
        Event::dispatch('customer.after.login', $customer->email);

        return redirect()->intended(route($this->_config['redirect']));
    }
}