<?php
       

    
        Route::get('/index', 'BuyNoir\SuperFront\Http\Controllers\SuperFrontController@index')
        ->defaults('_config', ['view' => 'superfront_view::superfront.index'])
        ->name('buynoir.home.index');
        Route::get('/privacy-policy', 'BuyNoir\SuperFront\Http\Controllers\SuperFrontController@privacyPolicy')
        ->defaults('_config', ['view' => 'superfront_view::superfront.privacy-policy'])
        ->name('buynoir.home.privacypolicy');
        Route::get('/contact-us', 'BuyNoir\SuperFront\Http\Controllers\SuperFrontController@contactUs')
        ->defaults('_config', ['view' => 'superfront_view::superfront.contact-us'])
        ->name('buynoir.home.contactus');

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

