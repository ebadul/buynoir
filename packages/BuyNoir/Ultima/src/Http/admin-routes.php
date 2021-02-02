<?php

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/ultima', 'namespace' => 'BuyNoir\Ultima\Http\Controllers\Admin'], function () {
    Route::get('/', 'UltimaController@index')
        ->name('admin.ultima.index')
        ->defaults('_config', [
            'view' => 'ultima::admin.index',
        ]);

    Route::get('/meta-data', 'UltimaController@renderMetaData')
        ->name('admin.ultima.meta-data')
        ->defaults('_config', [
            'view' => 'ultima::admin.meta-data',
        ]);

    Route::post('/meta-data/{id}', 'UltimaController@storeMetaData')
        ->name('admin.ultima.store.meta-data')
        ->defaults('_config', [
            'redirect' => 'admin.ultima.meta-data'
        ]);

    Route::get('/header-content', 'UltimaController@index')
        ->name('admin.ultima.header-content')
        ->defaults('_config', [
            'view' => 'ultima::admin.header-content',
        ]);

    Route::get('/slider', 'SliderController@index')
        ->name('admin.ultima.sliders')
        ->defaults('_config', [
            'view' => 'admin::settings.sliders.index',
        ]);

    Route::get('slider/create', 'SliderController@create')
        ->name('admin.ultima.sliders.create')
        ->defaults('_config', [
            'view' => 'admin::settings.sliders.create',
        ]);

    Route::post('slider/create', 'SliderController@store')
        ->name('admin.ultima.sliders.store')
        ->defaults('_config', [
            'redirect' => 'admin.ultima.sliders',
        ]);

    Route::get('slider/edit/{id}', 'SliderController@edit')
        ->name('admin.ultima.sliders.edit')
        ->defaults('_config', [
            'view' => 'admin::settings.sliders.edit',
        ]);

    Route::post('slider/edit/{id}', 'SliderController@update')
        ->name('admin.ultima.sliders.update')
        ->defaults('_config', [
            'redirect' => 'admin.ultima.sliders',
        ]);

    Route::post('slider/delete/{id}', 'SliderController@destroy')
        ->name('admin.ultima.sliders.delete');
});