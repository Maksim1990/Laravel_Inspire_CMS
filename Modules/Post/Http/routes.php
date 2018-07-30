<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Post\Http\Controllers'], function () {

        Route::resource('/{userId}/posts', 'PostController');
        Route::get('/posts/all/{id}', 'PostController@index')->name('posts');
    });
});
