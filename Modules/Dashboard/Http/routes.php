<?php
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function () {
        Route::get('/{id}/dashboard', 'DashboardController@index')->name('admin');
        Route::get('/about', 'DashboardController@aboutUs')->name('about_us');
        Route::get('/contacts', 'DashboardController@contacts')->name('contacts');
        Route::get('/{id}/languages', 'DashboardController@languages')->name('languages');
        Route::get('/{id}/menu', 'DashboardController@menu')->name('menu');
        Route::get('/{id}/website/settings', 'DashboardController@websiteSettings')->name('website_settings');


        Route::get('/{id}/export', 'ExcelController@index')->name('export');
        Route::get('export/{type}/details', 'ExcelController@export')->name('export_file');


        Route::get('import_books_main', 'ExcelController@importBooksMain');
        Route::get('import_movies_main', 'ExcelController@importMoviesMain');
        Route::get('downloadExcel_books/{type}', 'ExcelController@downloadBooks');
        Route::get('downloadExcel_movies/{type}', 'ExcelController@downloadMovies');
        Route::post('import_books', 'ExcelController@importBooks');
        Route::post('import_movies', 'ExcelController@importMovies');



        Route::post('/ajax_update_menu', 'DashboardController@updateMenu')->name('ajax_update_menu');
        Route::post('/ajax_delete_menu', 'DashboardController@deleteMenu')->name('ajax_delete_menu');
        Route::post('/ajax_update_languages', 'DashboardController@updateLanguages')->name('ajax_update_languages');


    });
});
