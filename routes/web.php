<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', function () {
    return view('subscriptions.about');
})->name('about');

Route::get('/subscriptions/create', 'SubscriptionController@create')->name('create');
Route::post('/home', 'SubscriptionController@store');
Route::get('/subscriptions/{subscription}/edit', 'SubscriptionController@edit')->name('edit');
Route::put('/subscriptions/{subscription}', 'SubscriptionController@update')->name('update');
Route::delete('/subscriptions/{subscription}', 'SubscriptionController@destroy')->name('delete');

Route::get('/subscriptions/stats', 'StatisticsController@index')->name('stats');
