<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Post\Http\Controllers'], function () {

        Route::resource('/{userId}/posts', 'PostController');
        Route::patch('/posts/{id}', 'PostController@update')->name('post_update');
        Route::delete('/posts/{id}', 'PostController@destroy')->name('post_delete');
        Route::get('/posts/all/{id}', 'PostController@index')->name('posts');
    });
});
