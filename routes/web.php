<?php


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/404', function () {
        return view('errors.404_g');
    });
    Route::get('/admin', function () {
        $arrTabs = ['General', 'Profile', 'Messages', 'Settings'];
        $active = "active";
        return view('admin.index', compact('arrTabs', 'active'));
    })->name("admins");

    Auth::routes();

    Route::group(['middleware' => ['web', 'login']], function () {

        Route::post('show_left_sidebar/', 'SettingController@showSidebar')->name("show_left_sidebar");

        Route::get('/home', 'HomeController@index')->name('home');

        //Bugsnag example
        Route::get('/bugsnag', 'HomeController@bugsnag')->name('bugsnag');
    });
});




