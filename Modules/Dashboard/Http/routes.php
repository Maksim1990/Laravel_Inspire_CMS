<?php

Route::group(['middleware' => ['web','login'], 'prefix' => 'admin', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function()
{
    Route::get('/{id}/dashboard', 'DashboardController@index')->name('admin');
    Route::get('/about', 'DashboardController@aboutUs')->name('about_us');
    Route::get('/contacts', 'DashboardController@contacts')->name('contacts');
    Route::get('/{id}/menu', 'DashboardController@menu')->name('menu');

});
