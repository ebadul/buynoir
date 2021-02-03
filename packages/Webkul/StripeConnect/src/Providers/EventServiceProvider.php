<?php

namespace Webkul\StripeConnect\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use View;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('stripe_saas::shop.default.checkout.style');
        });
        
        if ( (core()->getCurrentChannel() && core()->getCurrentChannel()->theme == "velocity")) {
            Event::listen('bagisto.shop.layout.head', function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('stripe_saas::shop.velocity.checkout.style');
            });

            Event::listen('bagisto.shop.checkout.payment-method.after', function($viewRenderEventManager){
                $viewRenderEventManager->addTemplate('stripe_saas::shop.velocity.checkout.card');
            });
        } else {
            Event::listen('bagisto.shop.layout.head', function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('stripe_saas::shop.default.checkout.style');
            });

            Event::listen('bagisto.shop.checkout.payment-method.after', function($viewRenderEventManager){
                $viewRenderEventManager->addTemplate('stripe_saas::shop.default.checkout.card');
            });
        }
    }
}