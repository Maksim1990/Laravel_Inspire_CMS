<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['middleware' => ['web', 'login'], 'prefix' => 'admin/pagebuilder', 'namespace' => 'Modules\Pagebuilder\Http\Controllers'], function () {
        Route::get('/{id}', 'PagebuilderController@index')->name("pagebuilder_index");
        Route::get('/{id}/order', 'PagebuilderController@blockOrderAndNew')->name("pagebuilder_order");
        Route::get('/content/editor', 'PagebuilderController@editor')->name("editor");
        Route::get('code_editor/{block_id?}', 'PagebuilderController@code_editor')->name("code_editor");
        Route::get('/{id}/css', 'PagebuilderController@css')->name("css");
        Route::get('/background/{id?}', 'PagebuilderController@background')->name("background");
        Route::get('/block/info/{id?}', 'PagebuilderController@blockInfo')->name("block_info");
        Route::get('/{id}/codeeditor/setting', 'PagebuilderController@codeeditorSetting')->name("codeeditor_setting");


        //--- Ajax routes
        Route::post('/editor_upload_image', 'PagebuilderController@editorUploadImage')->name("editor_upload_image");
        Route::post('/codeeditor_update', 'PagebuilderController@codeEditorUpdate')->name("ajax_codeeditor_update");
        Route::post('/codeeditor_theme_update', 'PagebuilderController@codeEditorThemeUpdate')->name("ajax_codeeditor_theme_update");
        Route::post('/content_editor_update', 'PagebuilderController@contentEditorUpdate')->name("ajax_content_editor_update");
        Route::post('/custom_css_update', 'PagebuilderController@customCssUpdate')->name("ajax_custom_css_update");
        Route::post('/ajax_bg_color_update', 'PagebuilderController@blockBackgroundUpdate')->name("ajax_bg_color_update");
        Route::post('/ajax_bg_type_update', 'PagebuilderController@blockBackgroundTypeUpdate')->name("ajax_bg_type_update");
        Route::post('/ajax_bg_image_update', 'PagebuilderController@blockBackgroundImageUpdate')->name("ajax_bg_image_update");
        Route::delete('/{id}/delete_background_image', 'PagebuilderController@deleteBackgroundImage')->name("delete_background_image");
        Route::patch('/{id}/upload_background_image', 'PagebuilderController@storeBackgroundImage')->name("upload_background_image");

        Route::post('/blocks_sortorder_update', 'PagebuilderController@blocksSortOrderUpdate')->name("ajax_blocks_sortorder_update");

    });
});
