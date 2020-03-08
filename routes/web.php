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

use function foo\func;

Route::get('/', function () {
    return view('auth.login');
})->middleware(['guest']);

Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::resources([
        'accounts' => 'AccountController',
        'orders' => 'OrderController',
    ]);
    Route::get('/accounts/{id}/delete', 'AccountController@deleteAccount');
    Route::get('/orders/{id}/delete', 'OrderController@deleteAccount');

});

Route::middleware(['admin'])->group(function () {

    Route::resources([
        'users' => 'UserController',
    ]);
    Route::get('/users/{id}/delete', 'UserController@deleteAccount');

});
