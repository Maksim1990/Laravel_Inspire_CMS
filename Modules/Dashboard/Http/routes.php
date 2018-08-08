<?php
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function () {
        Route::get('/{id}/dashboard', 'DashboardController@index')->name('admin');
        Route::get('/about', 'DashboardController@aboutUs')->name('about_us');
        Route::get('/contacts', 'DashboardController@contacts')->name('contacts');
        Route::get('/{id}/languages', 'DashboardController@languages')->name('languages');
        Route::get('/{id}/menu', 'DashboardController@menu')->name('menu');

        //-- Website Settings
        Route::get('/{id}/website/settings', 'WebsiteSettingsController@index')->name('website_settings');
        Route::post('/ajax_website_name_update', 'WebsiteSettingsController@updateWebsiteName')->name('ajax_website_name_update');
        Route::post('/ajax_website_email_form', 'WebsiteSettingsController@updateWebsiteEmailForm')->name('ajax_website_email_form');


        //-- Export functionality
        Route::get('/{id}/export', 'ExcelController@index')->name('export');
        Route::get('export/{type}/details', 'ExcelController@export')->name('export_file');


        //-- Mail functionality
        Route::resource('/{id}/mail', 'MailController');
        Route::get('/{id}/mail', 'MailController@index')->name('mail');
        Route::get('/{id}/mail/create', 'MailController@createEmail')->name('create_mail');
        Route::post('/{id}/add_mail_image_attachment', 'MailController@attachImages')->name('mail_image_attachments');

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
