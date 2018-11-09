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
//user
Route::match(['get', 'post'], '/profile', 'HomeController@profile')->name('profile');
Route::get('/profile/edit', 'HomeController@profileEdit')->name('profile.edit');
Route::post('/attendance/mark', 'HomeController@mark')->name('mark');
Route::get('/history', 'HomeController@history')->name('attendance.history');
Route::get('/event/get', 'HomeController@getevent')->name('getevent');
Route::get('/attendances', 'HomeController@at')->name('at');

//admin
Route::get('/event', 'AdminController@event')->name('event');
Route::post('/event/create', 'AdminController@eventCreate')->name('event.create');
Route::get('/report', 'AdminController@report')->name('report');
Route::get('/event/report', 'AdminController@eventReport')->name('event.report');
//event
Route::post('/event/able', 'AjaxController@toggleEventActivity')->name('event.able');
//service
Route::post('/service/create', 'AdminController@createService')->name('service.create');
//ajax
Route::get('/service/get', 'AjaxController@getServices')->name('services.get');
Route::post('/service/delete', 'AjaxController@deleteService')->name('service.delete');
Route::post('/service/update', 'AjaxController@updateService')->name('service.update');
//admin


//public
Route::get('/', 'HomeController@index')->name('home');
//
Route::get('/welcome', function () {
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

// Notifications
Route::post('notifications', 'NotificationController@store')->name('notification.store');
Route::get('notifications', 'NotificationController@index')->name('notification');

// Push Subscriptions
Route::post('subscriptions', 'PushSubscriptionController@update')->name('subscription.update');
Route::post('subscriptions/delete', 'PushSubscriptionController@destroy')->name('subscription.delete');

// Manifest file (optional if VAPID is used)
Route::get('manifest.json', function () {
    return [
        'name' => config('app.name'),
        'gcm_sender_id' => config('webpush.gcm.sender_id')
    ];
});
