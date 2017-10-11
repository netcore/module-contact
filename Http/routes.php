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
});