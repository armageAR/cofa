<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Files'], function () {
        // views
        Route::group(['prefix' => 'files'], function () {
            Route::view('/', 'files.index')->middleware('permission:read-files');
            Route::view('/create', 'files.create')->middleware('permission:create-files');
            Route::view('/{file}/edit', 'files.edit')->middleware('permission:update-files');
        });

        // api
        Route::group(['prefix' => 'api/files'], function () {
            Route::get('/getFile/{file}', 'FileController@getFile');
            Route::get('/count', 'FileController@count');
            Route::post('/filter', 'FileController@filter')->middleware('permission:read-files');

            Route::get('/{file}', 'FileController@show')->middleware('permission:read-files');
            Route::post('/store', 'FileController@store')->middleware('permission:create-files');
            Route::put('/update/{file}', 'FileController@update')->middleware('permission:update-files');
            Route::delete('/{file}', 'FileController@destroy'); //->middleware('permission:delete-files');
        });
    });
});
