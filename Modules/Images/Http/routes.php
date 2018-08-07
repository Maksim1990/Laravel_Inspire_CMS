<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin', 'namespace' => 'Modules\Images\Http\Controllers'], function () {

        Route::resource('/{userId}/images', 'ImagesController');
        Route::get('/images/all/{id}', 'ImagesController@index')->name('images');


        Route::post('/ajax_delete_image', 'ImagesController@deleteImage')->name('ajax_delete_image');


    });
});
