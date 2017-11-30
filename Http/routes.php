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

    Route::get('/item/{item}/edit', [
        'uses' => 'ContactItemController@edit',
        'as'   => 'item.edit'
    ]);

    Route::put('/item/{item}/update', [
        'uses' => 'ContactItemController@updateItem',
        'as'   => 'custom.item.update'
    ]);

    Route::put('/item/update', [
        'uses' => 'ContactItemController@update',
        'as'   => 'item.update'
    ]);

    Route::put('/content/update', [
        'uses' => 'ContactController@updateContent',
        'as'   => 'content.update'
    ]);

    Route::put('/map/update', [
        'uses' => 'ContactController@updateMap',
        'as'   => 'map.update'
    ]);
});