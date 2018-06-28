<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin/pagebuilder', 'namespace' => 'Modules\Pagebuilder\Http\Controllers'], function()
{
    Route::get('/{id}', 'PagebuilderController@index')->name("pagebuilder_index");
    Route::get('/content/editor', 'PagebuilderController@editor')->name("editor");
    Route::get('code_editor/{block_id?}', 'PagebuilderController@code_editor')->name("code_editor");





    //--- Ajax routes
    Route::post('/editor_upload_image', 'PagebuilderController@editorUploadImage')->name("editor_upload_image");
    Route::post('/codeeditor_update', 'PagebuilderController@codeEditorUpdate')->name("ajax_codeeditor_update");
    Route::post('/content_editor_update', 'PagebuilderController@contentEditorUpdate')->name("ajax_content_editor_update");

});
