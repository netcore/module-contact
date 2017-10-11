<?php

Route::group([
    'prefix'     => 'admin/contact',
    'as'         => 'admin::contact.',
    'middleware' => ['web', 'auth.admin'],
    'namespace'  => 'Modules\Contact\Http\Controllers\Admin'
], function () {
    Route::get('/', [
        'uses' => 'ContactController@index',
        'as'   => 'index'
    ]);

    Route::put('/item/update', [
        'uses' => 'ContactItemController@update',
        'as'   => 'item.update'
    ]);

    Route::put('/content/update', [
        'uses' => 'ContactController@updateContent',
        'as'   => 'content.update'
    ]);

    Route::post('/map/update', [
        'uses' => 'ContactController@map',
        'as'   => 'map.update'
    ]);
});