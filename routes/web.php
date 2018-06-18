<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin',function(){
    $arrTabs=['General','Profile','Messages','Settings'];
    $active="active";
    return view('admin.index',compact('arrTabs', 'active'));
});


Auth::routes();
Route::post('show_left_sidebar/','SettingController@showSidebar')->name("show_left_sidebar");
Route::get('/home', 'HomeController@index')->name('home');
