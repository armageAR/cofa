<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::view('/', 'welcome');
Route::view('/info', 'info');

// Route::get('/pp', function () {
//     $supplier = App\Supplier::find(1);
//     return $supplier;
// });

Auth::routes();

Route::get('/home', function () {
    return redirect('dashboard');
});

Route::get('/dashboard', 'DashboardController@index')->name('home');

require __DIR__ . '/profile/profile.php';
require __DIR__ . '/users/users.php';
require __DIR__ . '/suppliers/suppliers.php';
require __DIR__ . '/roles/roles.php';
require __DIR__ . '/roles/permissions.php';
require __DIR__ . '/modules/modules.php';

//Route::resource('api/data', 'DataFileController');
Route::get('api/data/{id}', 'DataFileController@index');