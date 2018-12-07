<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Suppliers'], function () {
        // views
        Route::group(['prefix' => 'suppliers'], function () {
            Route::view('/', 'suppliers.index')->middleware('permission:read-suppliers');
            Route::view('/create', 'suppliers.create')->middleware('permission:create-suppliers');
            Route::view('/{supplier}/edit', 'suppliers.edit')->middleware('permission:update-suppliers');
        });

        // api
        Route::group(['prefix' => 'api/suppliers'], function () {
            Route::get('/getSupplierRoles/{supplier}', 'SupplierController@getSupplierRoles');
            Route::get('/count', 'SupplierController@count');
            Route::post('/filter', 'SupplierController@filter')->middleware('permission:read-suppliers');

            Route::get('/{supplier}', 'SupplierController@show')->middleware('permission:read-suppliers');
            Route::post('/store', 'SupplierController@store')->middleware('permission:create-suppliers');
            Route::put('/update/{supplier}', 'SupplierController@update')->middleware('permission:update-suppliers');
            Route::delete('/{supplier}', 'SupplierController@destroy')->middleware('permission:delete-suppliers');
        });
    });
});
