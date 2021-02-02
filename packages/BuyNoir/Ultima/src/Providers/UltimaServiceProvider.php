<?php

namespace BuyNoir\Ultima\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class UltimaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');
        
        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');
        
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'ultima');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'ultima');

        $this->loadGloableVariables();

        $this->loadPublishableAssets();
        
        $this->app->register(EventServiceProvider::class);
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
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
    }

    /**
     * this function will provide global variables shared by view (blade files)
     *
     * @return boolean
     */
    private function loadPublishableAssets()
    {
        $this->publishes([
            __DIR__ . '/../../publishable/assets/' => public_path('themes/ultima/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/ultima' => resource_path('themes/ultima/views'),
            __DIR__ . '/../Resources/views/admin/settings/sliders' => resource_path('views/vendor/admin/settings/sliders'),
        ]);

        return true;
    }


    /**
     * this function will provide global variables shared by view (blade files)
     *
     * @return boolean
     */
    private function loadGloableVariables()
    {
        $ultimaHelper = app('BuyNoir\Ultima\Helpers\UltimaAdminHelper');
        $ultimaMetaData = $ultimaHelper->getUltimaMetaData();

        view()->share('showRecentlyViewed', true);
        view()->share('ultimaMetaData', $ultimaMetaData);

        return true;
    }
}