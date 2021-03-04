<?php

 
Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
    Route::prefix('checkout')->group(function () {
 
        Route::get('/sendtoken', 'BuyNoir\StripeConnect\Http\Controllers\ExtendStripeConnectController@collectToken')->name('stripe.get.token');
        // Route::post('/saved/card/payment', 'BuyNoir\StripeConnect\Http\Controllers\ExtendStripeConnectController@savedCardPayment')->name('stripe.saved.card.payment');

       
    });
});