<?php

Route::group(['prefix' => 'auth', 'namespace' => 'Modules\Auth\Http\Controllers'], function()
{
    Route::post('login', 'LoginController@authenticate');
});

Route::group(['middleware' => 'web', 'prefix' => 'auth', 'namespace' => 'Modules\Auth\Http\Controllers'], function()
{
    Route::get('/', 'AuthController@index');
});
