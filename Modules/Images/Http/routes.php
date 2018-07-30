<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Images\Http\Controllers'], function () {

        Route::resource('/{userId}/images', 'ImagesController');
        Route::get('/images/all/{id}', 'ImagesController@index')->name('images');
    });
});
