<?php
       

    
        Route::get('/index', 'BuyNoir\SuperFront\Http\Controllers\SuperFrontController@index')
        ->defaults('_config', ['view' => 'superfront_view::superfront.index'])
        ->name('buynoir.home.index');

    Route::group(['middleware' => ['web', 'company-locale']], function () {
        
    

        // Route::any('/index', 'BuyNoir\SuperFront\Http\Controllers\SuperFrontController@index')
        //             ->defaults('_config', ['view' => 'superfront_view::superfront.shop-index'])
        //             ->name('saas.home.index');

        // Route::any('/', 'BuyNoir\LandingPage\Http\Controllers\SuperFrontController@index')->defaults('_config', [
        //     'view' => 'landingpage_view::landingpage.index'
        // ])->name('saas.home.index');

        // Route::get('/landingpages', 'Webkul\Shop\Http\Controllers\HomeController@index')->defaults('_config', [
        //     'view' => 'shop::home.index'
        // ])->name('shop.home.index');

        // company registration routes
        Route::prefix('company')->group(function() {

            Route::get('/register', 'Webkul\SAASCustomizer\Http\Controllers\Company\CompanyController@create')->defaults('_config', [
                'view' => 'superfront_view::superfront.registration'
            ])->name('company.create.index');

            //Store front home
            // Route::get('/landingpage', 'BuyNoir\LandingPage\Http\Controllers\LandingPageController@index')
            //         ->defaults('_config', [
            //                     'view' => 'landingpage_view::landingpage.index'
            //                 ])->name('buynoir.landingpage.index');
    
          });
    });

