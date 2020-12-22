<?php
    Route::group(['middleware' => ['web', 'company-locale']], function () {
        
        Route::get('/', 'BuyNoir\LandingPage\Http\Controllers\LandingPageController@index')
                    ->defaults('_config', ['view' => '::landingpage.index'])
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

