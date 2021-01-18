<?php

namespace Webkul\SAASSubscription\Providers;

use Illuminate\Support\ServiceProvider;
use Webkul\SAASSubscription\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Webkul\SAASSubscription\Exceptions\Handler as SubscriptionHanlder;

class SAASSubscriptionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
        
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'saassubscription');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'saassubscription');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/webkul/saas-subscription/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views/admin/layouts/nav-top.blade.php' => resource_path('views/vendor/admin/layouts/nav-top.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/super/tenants/view.blade.php' => resource_path('views/vendor/saas/super/tenants/view.blade.php'),
        ]);

        $this->app->register(EventServiceProvider::class);

        $this->app->bind(
            ExceptionHandler::class,
            SubscriptionHanlder::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->registerConfig();
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/super-menu.php', 'menu.super-admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/super-system.php', 'company'
        );
    }
}