<?php
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function () {
        Route::get('/{id}/dashboard', 'DashboardController@index')->name('admin');
        Route::get('/about', 'DashboardController@aboutUs')->name('about_us');
        Route::get('/contacts', 'DashboardController@contacts')->name('contacts');
        Route::get('/{id}/languages', 'DashboardController@languages')->name('languages');
        Route::get('/{id}/menu', 'DashboardController@menu')->name('menu');


        //-- ADMIN SETTINGS BLOCK
        Route::get('/{id}/settings', 'AdminSettingsController@index')->name('admin_settings');
        Route::get('/{id}/reset_cache', 'AdminSettingsController@resetCache')->name('reset_cache');
        Route::post('/ajax_admin_settings_reset_cache', 'AdminSettingsController@ajaxResetCache')->name('ajax_admin_settings_reset_cache');
        Route::post('/ajax_admin_settings_app_version', 'AdminSettingsController@ajaxUpdateAppVersion')->name('ajax_admin_settings_app_version');
        Route::post('/ajax_admin_elasticsearch_update', 'AdminSettingsController@ajaxUpdateElasticSearch')->name('ajax_admin_elasticsearch_update');
        Route::post('/ajax_admin_elasticsearch_truncate', 'AdminSettingsController@ajaxTruncateElasticSearch')->name('ajax_admin_elasticsearch_truncate');

        //-- ELASTIC SEARCH functionality
        Route::get('/{id}/search', 'AdminSettingsController@search')->name('elastic_search');

        //-- Website Settings
        Route::get('/{id}/website/settings', 'WebsiteSettingsController@index')->name('website_settings');
        Route::post('/ajax_website_name_update', 'WebsiteSettingsController@updateWebsiteName')->name('ajax_website_name_update');
        Route::post('/ajax_website_email_form', 'WebsiteSettingsController@updateWebsiteEmailForm')->name('ajax_website_email_form');
        Route::post('/ajax_website_go_to_the_top', 'WebsiteSettingsController@updateWebsiteGoToTheTopButton')->name('ajax_website_go_to_the_top');
        Route::post('/ajax_website_posts_page', 'WebsiteSettingsController@updateWebsitePostsPage')->name('ajax_website_posts_page');
        Route::post('/ajax_website_google_map', 'WebsiteSettingsController@updateWebsiteGoogleMap')->name('ajax_website_google_map');
        Route::post('/ajax_website_google_map_key', 'WebsiteSettingsController@updateWebsiteGoogleMapKey')->name('ajax_website_google_map_key');
        Route::post('/ajax_admin_frp_credentials', 'AdminSettingsController@updateAdminFtpCredentials')->name('ajax_admin_frp_credentials');

        Route::post('/ajax_website_settings_twitter', 'WebsiteSettingsController@updateWebsiteTwitter')->name('ajax_website_settings_twitter');
        Route::post('/ajax_website_settings_github', 'WebsiteSettingsController@updateWebsiteGithub')->name('ajax_website_settings_github');
        Route::post('/ajax_website_settings_vk', 'WebsiteSettingsController@updateWebsiteVk')->name('ajax_website_settings_vk');
        Route::post('/ajax_website_settings_facebook', 'WebsiteSettingsController@updateWebsiteFacebook')->name('ajax_website_settings_facebook');
        Route::post('/ajax_website_settings_linkedin', 'WebsiteSettingsController@updateWebsiteLinkedin')->name('ajax_website_settings_linkedin');
        Route::post('/ajax_website_settings_line', 'WebsiteSettingsController@updateWebsiteLine')->name('ajax_website_settings_line');
        Route::post('/ajax_website_settings_instagram', 'WebsiteSettingsController@updateWebsiteInstagram')->name('ajax_website_settings_instagram');
        Route::post('/ajax_website_settings_pinterest', 'WebsiteSettingsController@updateWebsitePinterest')->name('ajax_website_settings_pinterest');
        Route::post('/ajax_website_settings_google', 'WebsiteSettingsController@updateWebsiteGoogle')->name('ajax_website_settings_google');


        //-- Export functionality
        Route::get('/{id}/export', 'ExcelController@index')->name('export');
        Route::get('export/{type}/details', 'ExcelController@export')->name('export_file');


        Route::get('/{id}/export/langs', 'ExcelController@exportLangs')->name('export_langs');
        Route::post('export/{type}/langs', 'ExcelController@exportLangsFile')->name('export_langs_file');

        Route::get('/{id}/export/menus', 'ExcelController@exportMenus')->name('export_menus');
        Route::post('export/{type}/menus', 'ExcelController@exportMenusFile')->name('export_menus_file');

        Route::get('/{id}/export/labels', 'ExcelController@exportLabels')->name('export_labels');
        Route::post('export/{type}/labels', 'ExcelController@exportLabelsFile')->name('export_labels_file');

        Route::get('/{id}/export/posts', 'ExcelController@exportPosts')->name('export_posts');
        Route::post('export/{type}/posts', 'ExcelController@exportPostsFile')->name('export_posts_file');


        //-- Mail functionality
        Route::resource('/{id}/mail', 'MailController');
        Route::get('/{id}/mail', 'MailController@index')->name('mail');
        Route::get('/{id}/mail/create', 'MailController@createEmail')->name('create_mail');
        Route::post('/{id}/add_mail_image_attachment', 'MailController@attachImages')->name('mail_image_attachments');

        Route::post('/ajax_get_mail_data', 'MailController@ajaxGetMailData')->name('ajax_get_mail_data');
        Route::post('/ajax_delete_mail', 'MailController@ajaxDeleteMailData')->name('ajax_delete_mail');

        //-- Inspire office functionality
        Route::get('/{id}/office', 'OfficeController@index')->name('office');
        Route::get('/{id}/ftp/content', 'OfficeController@ftpContent')->name('office_ftp_content');
        Route::get('/{id}/ftp/credentials/admin', 'OfficeController@setFTPCredentialsAdmin')->name('office_ftp_connection_admin');
        Route::get('/{id}/ftp/credentials', 'OfficeController@setFTPCredentials')->name('office_ftp_connection');
        Route::get('/{id}/ftp/manager', 'OfficeController@ftpManager')->name('office_ftp_manager');
        Route::post('/{id}/ftp_store', 'OfficeController@storeFTPCredentials')->name('office_ftp_store');
        Route::post('/{id}/ftp_store_admin', 'OfficeController@storeFTPCredentialsAdmin')->name('office_ftp_store_admin');
        Route::post('/ajax_get_folder_content', 'OfficeController@ajaxGetFolderContent')->name('ajax_get_folder_content');

        Route::get('/{id}/read_file', 'OfficeController@readFile')->name('office_read_file');
        Route::get('/{id}/docs', 'OfficeController@docs')->name('office_docs');
        Route::get('/{id}/docs/upload', 'OfficeController@uploadDoc')->name('upload_document');
        Route::post('/{id}/docs/store', 'OfficeController@storeDocs')->name('upload_document');


        Route::post('/ajax_update_menu', 'DashboardController@updateMenu')->name('ajax_update_menu');
        Route::post('/ajax_delete_menu', 'DashboardController@deleteMenu')->name('ajax_delete_menu');
        Route::post('/ajax_update_languages', 'DashboardController@updateLanguages')->name('ajax_update_languages');




        //-- SEARCH FUNCTIONALITY
        Route::post('/ajax_search_bar', 'SearchController@ajaxSearchBar')->name('ajax_search_bar');





    });
});
