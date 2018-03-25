<?php

use Illuminate\Http\Request;


Route::group(['prefix' => 'manuser'], function()
{

    Route::post('authenticate', '\Lameck\Manuser\ManuserController@authenticate');
    Route::middleware('jwt.auth','throttle:1,1')->get('users','\Lameck\Manuser\ManuserController@users');

});