<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin/pagebuilder', 'namespace' => 'Modules\Pagebuilder\Http\Controllers'], function()
{
    Route::get('/', 'PagebuilderController@index');
    Route::get('/editor', 'PagebuilderController@editor')->name("editor");



});
