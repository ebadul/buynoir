<?php

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::get('stripe/connect', 'Webkul\StripeConnect\Http\Controllers\SellerRegistrationController@index')->name('admin.stripe.seller');

        Route::get('stripe/connect/retrieve/token', 'Webkul\StripeConnect\Http\Controllers\SellerRegistrationController@retrieveToken')->name('admin.stripe.retrieve-grant');

        Route::get('stripe/connect/revoke', 'Webkul\StripeConnect\Http\Controllers\SellerRegistrationController@revokeAccess')->name('admin.stripe.revoke-access');
    });
});

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
    Route::prefix('checkout')->group(function () {

        Route::get('/redirect/stripe', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@redirect')->name('stripe.standard.redirect');

        Route::post('/save/card', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@saveCard')->name('stripe.save.card');

        Route::get('/sendtoken', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@collectToken')->name('stripe.get.token');

        Route::get('/create/charge', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@createCharge')->name('stripe.make.payment');

        Route::get('/stripe', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@collectCard')->defaults('_config', [
            'view' => 'stripe_saas::checkout.card'
        ])->name('stripe.cardcollect');

        Route::get('/stripe/card/check', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@checkCard')->name('stripe.check.card.unique');

        Route::get('/stripe/card/delete', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@deleteCard')->name('stripe.delete.saved.cart');

        Route::post('/saved/card/payment', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@savedCardPayment')->name('stripe.saved.card.payment');

        Route::get('/payment/cancel', 'Webkul\StripeConnect\Http\Controllers\StripeConnectController@paymentCancel')->name('stripe.payment.cancel');
    });
});