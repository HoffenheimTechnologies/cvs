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
Route::match(['get', 'post'], '/profile', 'HomeController@profile')->name('profile');
Route::get('/profile/edit', 'HomeController@profileEdit')->name('profile.edit');
Route::post('/attendance/mark', 'HomeController@mark')->name('mark');
Route::get('/event', 'AdminController@event')->name('event');
Route::get('/event/get', 'HomeController@getevent')->name('getevent');
Route::post('/event/create', 'AdminController@eventCreate')->name('event.create');
Route::get('/report', 'AdminController@report')->name('report');
Route::get('/attendances', 'HomeController@at')->name('at');
Route::get('/event/report', 'AdminController@eventReport')->name('event.report');
//service
Route::post('/service/create', 'AdminController@createService')->name('service.create');
//
Route::get('/weerrr', function () {
    return view('welcome');
});
Route::get('/serverSide',  function () {
        $users = App\User::all();
        return Datatables::of($users)->make();
    }
)->name('serverSide');
//shared server clear cache
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});
//push admin
Route::get('/sub', function () {
    return view('sub');
});
