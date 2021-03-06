<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin/label', 'namespace' => 'Modules\Label\Http\Controllers'], function () {
        Route::get('/{id}', 'LabelController@index')->name("label");
        Route::post('/ajax_update', 'LabelController@ajaxUpdate')->name("ajax_update_label");
        Route::post('/ajax_delete', 'LabelController@ajaxDelete')->name("ajax_delete_label");
    });
});
