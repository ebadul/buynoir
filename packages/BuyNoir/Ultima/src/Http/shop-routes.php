<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {

    Route::get('/ultima', 'BuyNoir\Ultima\Http\Controllers\Shop\UltimaController@index')->defaults('_config', [
        'view' => 'ultima::shop.index',
    ])->name('ultima.shop.index');

});