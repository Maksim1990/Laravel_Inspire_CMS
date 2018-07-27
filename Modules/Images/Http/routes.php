<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'admin/images', 'namespace' => 'Modules\Images\Http\Controllers'], function () {
        Route::get('/{id}', 'ImagesController@index')->name('images');
    });
});
