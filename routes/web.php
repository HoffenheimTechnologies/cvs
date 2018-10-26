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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/history', 'HomeController@history')->name('attendance.history');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::get('/profile/edit', 'HomeController@profileEdit')->name('profile.edit');
Route::post('/attendance/mark', 'HomeController@mark')->name('mark');
Route::get('/event', 'HomeController@event')->name('event');
Route::post('/event/create', 'HomeController@eventCreate')->name('event.create');
Route::post('/report', 'HomeController@report')->name('report');
Route::get('/weerrr', function () {
    return view('welcome');
});
