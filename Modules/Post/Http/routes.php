<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin', 'namespace' => 'Modules\Post\Http\Controllers'], function () {


        Route::patch('/posts/{id}', 'PostController@updatePost')->name('post_update');
        Route::delete('/posts/{id}', 'PostController@destroyPost')->name('post_delete');
        Route::get('/posts/all/{id}', 'PostController@index')->name('posts');
        Route::post('/{id}/update_post_image', 'PostController@updatePostImage');
       Route::resource('/{userId}/posts', 'PostController');
    });
});
