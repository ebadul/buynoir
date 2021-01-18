<?php

Route::group(['middleware' => ['web', 'super-locale']], function () {
    
    Route::prefix('super')->group(function() {

        Route::any('/paypal/ipn', 'Webkul\SAASSubscription\Http\Controllers\Super\IpnController@paypalIpnListener')->name('super.subscription.paypal.ipn');

        Route::group(['middleware' => ['super-admin']], function () {

            Route::prefix('subscription')->group(function() {
                //Plan routes
                Route::get('/plans', 'Webkul\SAASSubscription\Http\Controllers\Super\PlanController@index')->defaults('_config', [
                    'view' => 'saassubscription::super.plans.index'
                ])->name('super.subscription.plan.index');
                
                Route::get('/plans/create', 'Webkul\SAASSubscription\Http\Controllers\Super\PlanController@create')->defaults('_config', [
                    'view' => 'saassubscription::super.plans.create'
                ])->name('super.subscription.plan.create');
                
                Route::post('/plans/create', 'Webkul\SAASSubscription\Http\Controllers\Super\PlanController@store')->defaults('_config', [
                    'redirect' => 'super.subscription.plan.index'
                ])->name('super.subscription.plan.store');
                
                Route::get('/plans/edit/{id}', 'Webkul\SAASSubscription\Http\Controllers\Super\PlanController@edit')->defaults('_config', [
                    'view' => 'saassubscription::super.plans.edit'
                ])->name('super.subscription.plan.edit');
                
                Route::post('/plans/edit/{id}', 'Webkul\SAASSubscription\Http\Controllers\Super\PlanController@update')->defaults('_config', [
                    'redirect' => 'super.subscription.plan.index'
                ])->name('super.subscription.plan.update');

                Route::post('/plans/delete/{id}', 'Webkul\SAASSubscription\Http\Controllers\Super\PlanController@destroy')->name('super.subscription.plan.delete');


                //Invoice routes
                Route::get('/invoices', 'Webkul\SAASSubscription\Http\Controllers\Super\InvoiceController@index')->defaults('_config', [
                    'view' => 'saassubscription::super.invoices.index'
                ])->name('super.subscription.invoice.index');

                Route::get('/invoices/view/{id}', 'Webkul\SAASSubscription\Http\Controllers\Super\InvoiceController@view')->defaults('_config', [
                    'view' => 'saassubscription::super.invoices.view'
                ])->name('super.subscription.invoice.view');


                //Recurring profile routes
                Route::get('/purchased-plans', 'Webkul\SAASSubscription\Http\Controllers\Super\RecurringProfileController@index')->defaults('_config', [
                    'view' => 'saassubscription::super.recurring-profiles.index'
                ])->name('super.subscription.recurring_profile.index');

                Route::get('/purchased-plans/view/{id}', 'Webkul\SAASSubscription\Http\Controllers\Super\RecurringProfileController@view')->defaults('_config', [
                    'view' => 'saassubscription::super.recurring-profiles.view'
                ])->name('super.subscription.recurring_profile.view');
                
                Route::post('/plan/assign/{id}', 'Webkul\SAASSubscription\Http\Controllers\Super\RecurringProfileController@assign')->name('super.subscription.plan.assign');
                
                Route::get('/plan/cancel/{id}', 'Webkul\SAASSubscription\Http\Controllers\Super\RecurringProfileController@cancel')->name('super.subscription.plan.cancel');
            });

        });
        
    });

    Route::prefix('admin')->group(function() {

        Route::group(['middleware' => ['admin']], function () {

            Route::prefix('subscription')->group(function() {

                Route::get('/overview', 'Webkul\SAASSubscription\Http\Controllers\Admin\SubscriptionController@overview')->defaults('_config', [
                    'view' => 'saassubscription::admin.plans.overview'
                ])->name('admin.subscription.plan.overview');


                Route::get('/plans', 'Webkul\SAASSubscription\Http\Controllers\Admin\SubscriptionController@index')->defaults('_config', [
                    'view' => 'saassubscription::admin.plans.index'
                ])->name('admin.subscription.plan.index');

                Route::post('/plans/{id}', 'Webkul\SAASSubscription\Http\Controllers\Admin\SubscriptionController@addToCart')->defaults('_config', [
                    'redirect' => 'admin.subscription.checkout.index'
                ])->name('admin.subscription.plan.add-to-cart');
                

                Route::get('/checkout', 'Webkul\SAASSubscription\Http\Controllers\Admin\CheckoutController@index')->defaults('_config', [
                    'view' => 'saassubscription::admin.checkout.index'
                ])->name('admin.subscription.checkout.index');

                Route::post('/checkout/purchase', 'Webkul\SAASSubscription\Http\Controllers\Admin\CheckoutController@purchase')->defaults('_config', [
                    'redirect' => 'admin.subscription.plan.index'
                ])->name('admin.subscription.checkout.purchase');


                Route::get('/paypal/start', 'Webkul\SAASSubscription\Http\Controllers\Admin\PaypalController@start')->defaults('_config', [
                    'redirect' => 'admin.subscription.plan.index'
                ])->name('admin.subscription.paypal.start');

                Route::get('/paypal/cancel', 'Webkul\SAASSubscription\Http\Controllers\Admin\PaypalController@cancel')->defaults('_config', [
                    'redirect' => 'admin.subscription.plan.index'
                ])->name('admin.subscription.paypal.cancel');

                Route::get('/paypal/review', 'Webkul\SAASSubscription\Http\Controllers\Admin\PaypalController@review')->defaults('_config', [
                    'redirect' => 'admin.subscription.plan.index'
                ])->name('admin.subscription.paypal.review');

                Route::get('/paypal/payment', 'Webkul\SAASSubscription\Http\Controllers\Admin\PaypalController@createProfile')->defaults('_config', [
                    'redirect' => 'admin.subscription.plan.index'
                ])->name('admin.subscription.paypal.payment');


                Route::get('/invoices', 'Webkul\SAASSubscription\Http\Controllers\Admin\InvoiceController@index')->defaults('_config', [
                    'view' => 'saassubscription::admin.invoices.index'
                ])->name('admin.subscription.invoice.index');

                Route::get('/invoices/view/{id}', 'Webkul\SAASSubscription\Http\Controllers\Admin\InvoiceController@view')->defaults('_config', [
                    'view' => 'saassubscription::admin.invoices.view'
                ])->name('admin.subscription.invoice.view');
            });

        });
    });

});