<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/save-subscription/{id}',function($id, Request $request){
  $this->validate($request, ['endpoint' => 'required']);

  $request->user()->updatePushSubscription(
      $request->endpoint,
      $request->key,
      $request->token
  );
  // $user = \App\User::findOrFail($id);
  //
  // $user->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
  $user->notify(new \App\Notifications\GenericNotification("Welcome To CVMS", "You will now get all of our event's notifications"));
  return response()->json([
    'success' => true
  ]);
})->name('push.save');

Route::post('/send-notification/{id}', function($id, Request $request){
  $user = \App\User::findOrFail($id);
  $user->notify(new \App\Notifications\GenericNotification($request->title, $request->body));
  return response()->json([
    'success' => true
  ]);
})->name('push.send');
