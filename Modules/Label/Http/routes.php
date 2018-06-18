<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin/label', 'namespace' => 'Modules\Label\Http\Controllers'], function()
{
    Route::get('/', 'LabelController@index');
});
