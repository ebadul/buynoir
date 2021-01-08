<?php 

namespace BuyNoir\SuperFront\Providers;

 use Illuminate\Support\ServiceProvider;
 use Illuminate\Support\Facades\Event;

 
 class SuperFrontServiceProvider extends ServiceProvider
 {
     /**
     * Bootstrap services.
     *
     * @return void
     */
     public function boot()
     {
		  $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
          $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'superfront_view');
          $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'superfront_lang');
          $this->publishes([
            __DIR__ . '/../Resources/public/superfront/assets' => public_path('buynoir/superfront/assets'),
        ], 'public');

          //$this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');

     }

     /**
     * Register services.
     *
     * @return void
     */
     public function register()
     {
        //   $this->mergeConfigFrom(dirname(__DIR__) . '/Config/menu.php', 'menu.admin');
        //   $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
     }
 }