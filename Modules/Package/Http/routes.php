<?php

Route::group(['namespace' => 'Modules\Package\Http\Controllers'], function()
{
    Route::group(['middleware' => 'jwt.verify'], function()
    {
        Route::get('packages/{user_id?}', 'PackageController@index');
        Route::get('package/{id}', 'PackageController@show');
        Route::post('package', 'PackageController@store');
        Route::put('package/{id}', 'PackageController@update');
        Route::delete('package/{id}', 'PackageController@destroy');

        Route::get('sessions/{package_id?}', 'SessionController@index');
        Route::get('session/{id}', 'SessionController@show');
        Route::post('session', 'SessionController@store');
        Route::put('session/{id}', 'SessionController@update');
        Route::delete('session/{id}', 'SessionController@destroy');
    });
});