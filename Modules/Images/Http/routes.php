<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'images', 'namespace' => 'Modules\Images\Http\Controllers'], function () {
        Route::get('/', 'ImagesController@index');
    });
});
