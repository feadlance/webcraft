<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
* Homepage
*/

Route::get('/', [
  'uses' => '\Webcraft\Http\Controllers\HomeController@getIndex',
  'as' => 'home',
  'middleware' => ['auth', 'old_login']
]);

/*
* Authentication
*/

Route::get('/aramiza-katil', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@getIndex',
  'as' => 'auth.index',
  'middleware' => ['guest']
]);

Route::get('/yeni-email', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@getEmail',
  'as' => 'auth.email',
  'middleware' => ['auth', 'first_login']
]);

Route::post('/yeni-email', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@postEmail',
  'middleware' => ['auth', 'first_login']
]);

Route::get('/kaydi-onayla/{email}', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@getVerify',
  'as' => 'auth.verify'
]);

Route::get('/hos-geldin', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@getWelcome',
  'as' => 'auth.welcome'
]);

Route::post('/signup', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@postSignup',
  'as' => 'auth.signup',
  'middleware' => ['guest']
]);

Route::post('/signin', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@postSignin',
  'as' => 'auth.signin',
  'middleware' => ['guest']
]);

Route::get('/cikis-yap', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@getSignout',
  'as' => 'auth.signout',
  'middleware' => ['auth']
]);

/*
* Profile
*/

Route::get('/oyuncu/{player}', [
  'uses' => '\Webcraft\Http\Controllers\ProfileController@getIndex',
  'as' => 'profile',
  'middleware' => ['auth', 'old_login']
]);

Route::get('/oyuncu/{player}/oldurme-detaylari', [
  'uses' => '\Webcraft\Http\Controllers\ProfileController@getDetailKill',
  'as' => 'profile.killed',
  'middleware' => ['auth', 'old_login']
]);

Route::get('/oyuncu/{player}/olum-detaylari', [
  'uses' => '\Webcraft\Http\Controllers\ProfileController@getDetailDeath',
  'as' => 'profile.death',
  'middleware' => ['auth', 'old_login']
]);

/*
* Friend
*/

Route::post('/oyuncu/arkadas/ekle', [
  'uses' => '\Webcraft\Http\Controllers\FriendController@postAddFriend',
  'as' => 'friend.add',
  'middleware' => ['auth', 'old_login']
]);

Route::post('/oyuncu/arkadas/kabul-et', [
  'uses' => '\Webcraft\Http\Controllers\FriendController@postAcceptFriend',
  'as' => 'friend.accept',
  'middleware' => ['auth', 'old_login']
]);

Route::post('/oyuncu/arkadas/sil', [
  'uses' => '\Webcraft\Http\Controllers\FriendController@postDeleteFriend',
  'as' => 'friend.delete',
  'middleware' => ['auth', 'old_login']
]);

/*
* Credit
*/

Route::get('/kredi-yukle', [
  'uses' => '\Webcraft\Http\Controllers\PaymentController@getIndex',
  'as' => 'payment',
  'middleware' => ['auth', 'old_login']
]);

Route::get('/payment/listener', [
  'uses' => '\Webcraft\Http\Controllers\PaymentController@getListener',
  'as' => 'payment.listener'
]);

Route::post('/payment/listener', [
  'uses' => '\Webcraft\Http\Controllers\PaymentController@postListener'
]);

Route::get('/odeme/basarili', [
  'uses' => '\Webcraft\Http\Controllers\PaymentController@getSuccess',
  'as' => 'payment.success',
  'middleware' => ['auth', 'old_login']
]);

Route::get('/odeme/basarisiz', [
  'uses' => '\Webcraft\Http\Controllers\PaymentController@getError',
  'as' => 'payment.error',
  'middleware' => ['auth', 'old_login']
]);

/*
* Market
*/

/*Route::get('/market', [
  'uses' => '\Webcraft\Http\Controllers\MarketController@getIndex',
  'as' => 'market',
  'middleware' => ['auth']
]);*/

/*
* Upgrade Account
*/

Route::get('/hesabimi-yukselt', [
  'uses' => '\Webcraft\Http\Controllers\UpgradeController@getIndex',
  'as' => 'upgrade',
  'middleware' => ['auth', 'old_login']
]);

/*
* Groups
*/

Route::post('/group/new', [
  'uses' => '\Webcraft\Http\Controllers\GroupController@postNew',
  'as' => 'group.new',
  'middleware' => ['auth', 'admin', 'old_login']
]);

Route::get('/group/delete/{id}', [
  'uses' => '\Webcraft\Http\Controllers\GroupController@getDelete',
  'as' => 'group.delete',
  'middleware' => ['auth', 'admin', 'old_login']
]);

Route::post('/group/new/feature', [
  'uses' => '\Webcraft\Http\Controllers\GroupController@postNewFeature',
  'as' => 'group.new_feature',
  'middleware' => ['auth', 'admin', 'old_login']
]);

Route::get('/group/delete/feature/{id}', [
  'uses' => '\Webcraft\Http\Controllers\GroupController@getDeleteFeature',
  'as' => 'group.delete.feature',
  'middleware' => ['auth', 'admin', 'old_login']
]);

/*
* Users
*/

Route::get('/oyuncular', [
  'uses' => '\Webcraft\Http\Controllers\UserController@getUsers',
  'as' => 'users',
  'middleware' => ['auth', 'old_login']
]);

/*
* Top 100
*/

Route::get('/hit/en-iyiler', [
  'uses' => '\Webcraft\Http\Controllers\HitController@getBest100',
  'as' => 'top.best',
  'middleware' => ['auth', 'old_login']
]);

/*
* Statuses
*/

Route::post('/status', [
  'uses' => '\Webcraft\Http\Controllers\StatusController@postStatus',
  'as' => 'status.post',
  'middleware' => ['auth', 'old_login']
]);

Route::post('/status/delete', [
  'uses' => '\Webcraft\Http\Controllers\StatusController@postDelete',
  'as' => 'status.delete',
  'middleware' => ['auth', 'old_login']
]);

Route::post('/status/like', [
  'uses' => '\Webcraft\Http\Controllers\StatusController@postLike',
  'as' => 'status.like',
  'middleware' => ['auth', 'old_login']
]);



/*
* Comments
*/

Route::post('/status/comment', [
  'uses' => '\Webcraft\Http\Controllers\CommentController@postComment',
  'as' => 'status.comment',
  'middleware' => ['auth', 'old_login']
]);

Route::post('/status/comment/like', [
  'uses' => '\Webcraft\Http\Controllers\CommentController@postLike',
  'as' => 'status.comment.like',
  'middleware' => ['auth', 'old_login']
]);