<?php


    Route::group(['middleware' => ['web', 'company-locale']], function () {
        
        Route::get('/shop', 'Webkul\Shop\Http\Controllers\HomeController@index')->defaults('_config', [
        'view' => 'shop::home.index'])
                    ->name('buynoir.home.index');

        // company registration routes
        Route::prefix('company')->group(function() {
            //Store front home
            // Route::get('/landingpage', 'BuyNoir\LandingPage\Http\Controllers\LandingPageController@index')
            //         ->defaults('_config', [
            //                     'view' => 'landingpage_view::landingpage.index'
            //                 ])->name('buynoir.landingpage.index');
    
          });
    });

