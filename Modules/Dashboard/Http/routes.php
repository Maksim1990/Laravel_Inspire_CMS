<?php

Route::group(['middleware' => ['web','login'], 'prefix' => 'admin', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function()
{
    Route::get('/{id}/dashboard', 'DashboardController@index')->name('admin');

});
