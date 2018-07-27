<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'admin/posts', 'namespace' => 'Modules\Post\Http\Controllers'], function () {
        Route::get('/{id}', 'PostController@index')->name('posts');
    });
});
