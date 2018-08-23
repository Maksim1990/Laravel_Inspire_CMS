<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'website', 'namespace' => 'Modules\Website\Http\Controllers'], function () {

        Route::get('/{id}/{sitename}', 'WebsiteController@index')->name('website');
        Route::get('/{id}/{sitename}/posts', 'WebsiteController@posts')->name('website_posts');
        Route::get('/{id}/{sitename}/posts/{post_id}', 'WebsiteController@showPost')->name('website_post');

        //Route::get('/404', 'WebsiteController@pageNotFound')->name('website_page_not_found')->middleware("login");
        Route::get('/404', 'WebsiteController@pageNotFound')->name('website_page_not_found');
    });
});
