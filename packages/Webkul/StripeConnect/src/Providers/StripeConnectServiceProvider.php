<?php

namespace Webkul\StripeConnect\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class StripeConnectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        include __DIR__ . '/../Http/routes.php';
        
        $this->app->register(EventServiceProvider::class);
        
        $this->app->register(ModuleServiceProvider::class);

        
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'stripe_saas');
        
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'stripe_saas');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/webkul/stripe/assets'),
        ], 'public');
        
        $this->publishes([
            dirname(__DIR__) . '/Resources/views/shop/default/checkout/total' => resource_path('themes/default/views/checkout/total')
        ]);
        
        $this->publishes([
            dirname(__DIR__) . '/Resources/views/shop/velocity/checkout/total' => resource_path('themes/velocity/views/checkout/total')
        ]);

        $this->publishes([
            dirname(__DIR__) . '/Resources/views/shop/velocity/customers/account/orders' => resource_path('themes/velocity/views/customers/account/orders')
        ]);

        $this->publishes([
            dirname(__DIR__) . '/Resources/views/shop/default/customers/account/orders' => resource_path('themes/default/views/customers/account/orders')
        ]);

        \Webkul\StripeConnect\Models\StripeConnect::observe(\Webkul\StripeConnect\Observers\StripeConnectObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Merge the stripe connect's configuration with the admin panel
     */
    public function registerConfig()
    {
        
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/super-system.php', 'company'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
        
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php', 'paymentmethods'
        );
    }
}