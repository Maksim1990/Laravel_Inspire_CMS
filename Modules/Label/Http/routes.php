<?php

Route::group(['middleware' => ['web','login'], 'prefix' => 'admin/label', 'namespace' => 'Modules\Label\Http\Controllers'], function()
{
    Route::get('/', 'LabelController@index')->name("label");
    Route::post('/ajax_update', 'LabelController@ajaxUpdate')->name("ajax_update_label");
});
