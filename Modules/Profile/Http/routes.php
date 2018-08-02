<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin/profile', 'namespace' => 'Modules\Profile\Http\Controllers'], function () {

        Route::get('/{id}', 'ProfileController@index')->name('profile');
        Route::get('/{id}/settings', 'ProfileController@settings')->name('profile_settings');
        //Route::get('/{id}/settings', 'ProfileController@settings')->name('profile_settings');


        Route::get('/{id}/change_password', function ($id) {
            $arrTabs = ['General'];
            $active = "active";
            $user = \App\User::find($id);
            return view('profile::change_password', compact('arrTabs', 'active', 'user'));
        })->name("change_password");
        Route::patch('/update_profile/{id}', 'ProfileController@updateProfile');
        Route::patch('/update_password/{id}', 'ProfileController@updatePassword');
        Route::delete('/delete_profile/{id}', 'ProfileController@deleteProfile')->name('delete_profile');

    });
});
