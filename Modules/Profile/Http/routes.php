<?php

Route::group(['middleware' => ['web','login'], 'prefix' => 'admin/profile', 'namespace' => 'Modules\Profile\Http\Controllers'], function()
{
    Route::get('/{id}', 'ProfileController@index')->name('profile');
    Route::get('/{id}/upload', 'ProfileController@upload')->name('profile_upload');
    Route::get('/{id}/settings', 'ProfileController@settings')->name('profile_settings');
});
