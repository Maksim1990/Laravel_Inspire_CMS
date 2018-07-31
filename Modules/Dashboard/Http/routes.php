<?php
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function () {
        Route::get('/{id}/dashboard', 'DashboardController@index')->name('admin');
        Route::get('/about', 'DashboardController@aboutUs')->name('about_us');
        Route::get('/contacts', 'DashboardController@contacts')->name('contacts');
        Route::get('/{id}/languages', 'DashboardController@languages')->name('languages');
        Route::get('/{id}/menu', 'DashboardController@menu')->name('menu');
        Route::get('/{id}/website/settings', 'DashboardController@websiteSettings')->name('website_settings');


        //-- Export functionality
        Route::get('/{id}/export', 'ExcelController@index')->name('export');
        Route::get('export/{type}/details', 'ExcelController@export')->name('export_file');


        //-- Mail functionality
        Route::get('/{id}/mail', 'MailController@index')->name('mail');
        Route::get('/{id}/send_mail', 'MailController@sendEmail')->name('send_mail');

        //-- Inspire office functionality
        Route::get('/{id}/office', 'OfficeController@index')->name('office');
        Route::get('/{id}/read_file', 'OfficeController@readFile')->name('office_read_file');
        Route::get('/{id}/ftp', 'OfficeController@setFTPCredentials')->name('office_ftp_connection');
        Route::post('/{id}/ftp_store', 'OfficeController@storeFTPCredentials')->name('office_ftp_store');


        Route::post('/ajax_update_menu', 'DashboardController@updateMenu')->name('ajax_update_menu');
        Route::post('/ajax_delete_menu', 'DashboardController@deleteMenu')->name('ajax_delete_menu');
        Route::post('/ajax_update_languages', 'DashboardController@updateLanguages')->name('ajax_update_languages');


    });
});
