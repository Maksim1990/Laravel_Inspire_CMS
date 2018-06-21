<?php

Route::group(['middleware' => 'web', 'prefix' => 'website', 'namespace' => 'Modules\Website\Http\Controllers'], function()
{
    Route::get('/', 'WebsiteController@index')->name('website');

        //Route::get('/404', 'WebsiteController@pageNotFound')->name('website_page_not_found')->middleware("login");
        Route::get('/404', 'WebsiteController@pageNotFound')->name('website_page_not_found');
});
