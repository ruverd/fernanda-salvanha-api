<?php
Route::group(['middleware' => 'web', 'namespace' => 'Modules\Event\Http\Controllers'], function()
{
    Route::get('events/{name?}', 'EventController@events');
    // Route::get('packages/{name?}', 'EventController@packages');
    // Route::get('sessions/{package}', 'EventController@sessions');
});