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
  'middleware' => ['auth']
]);

/*
* Authentication
*/

Route::get('/aramiza-katil', [
  'uses' => '\Webcraft\Http\Controllers\AuthController@getIndex',
  'as' => 'auth.index',
  'middleware' => ['guest']
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
  'middleware' => ['auth']
]);

Route::get('/oyuncu/{player}/oldurme-detaylari', [
  'uses' => '\Webcraft\Http\Controllers\ProfileController@getDetailKill',
  'as' => 'profile.killed',
  'middleware' => ['auth']
]);

Route::get('/oyuncu/{player}/olum-detaylari', [
  'uses' => '\Webcraft\Http\Controllers\ProfileController@getDetailDeath',
  'as' => 'profile.death',
  'middleware' => ['auth']
]);

/*
* Friend
*/

Route::put('/oyuncu/{player}/add', [
  'uses' => '\Webcraft\Http\Controllers\FriendController@putAddFriend',
  'as' => 'friend.add',
  'middleware' => ['auth']
]);

Route::put('/oyuncu/{player}/accept', [
  'uses' => '\Webcraft\Http\Controllers\FriendController@putAcceptFriend',
  'as' => 'friend.accept',
  'middleware' => ['auth']
]);

Route::put('/oyuncu/{player}/delete', [
  'uses' => '\Webcraft\Http\Controllers\FriendController@putDeleteFriend',
  'as' => 'friend.delete',
  'middleware' => ['auth']
]);

/*
* Market
*/

Route::get('/market', [
  'uses' => '\Webcraft\Http\Controllers\MarketController@getIndex',
  'as' => 'market',
  'middleware' => ['auth']
]);

Route::get('/market/esyalar', [
	'uses' => '\Webcraft\Http\Controllers\MarketController@getProducts',
	'as' => 'market.products',
	'middleware' => ['auth']
]);

Route::post('/market/esyalar/buy', [
	'uses' => '\Webcraft\Http\Controllers\MarketController@postBuyProduct',
  'as' => 'market.products.buy',
	'middleware' => ['auth']
]);

Route::get('/market/gruplar', [
  'uses' => '\Webcraft\Http\Controllers\MarketController@getGroups',
  'as' => 'market.groups',
  'middleware' => ['auth']
]);

Route::post('/market/gruplar/buy', [
  'uses' => '\Webcraft\Http\Controllers\MarketController@postBuyGroup',
  'as' => 'market.groups.buy',
  'middleware' => ['auth']
]);

/*
* Products
*/

Route::post('/product/new/ajax', [
  'uses' => '\Webcraft\Http\Controllers\ProductController@postNewAjax',
  'as' => 'product.new.ajax',
  'middleware' => ['auth', 'admin']
]);

/*
* Groups
*/

Route::post('/group/new/ajax', [
  'uses' => '\Webcraft\Http\Controllers\GroupController@postNewAjax',
  'as' => 'group.new.ajax',
  'middleware' => ['auth', 'admin']
]);

/*
* Users
*/

Route::get('/oyuncular', [
  'uses' => '\Webcraft\Http\Controllers\UserController@getUsers',
  'as' => 'users',
  'middleware' => ['auth']
]);

/*
* Statuses
*/

Route::post('/status', [
  'uses' => '\Webcraft\Http\Controllers\StatusController@postStatus',
  'as' => 'status.post',
  'middleware' => ['auth']
]);

Route::put('/status/{id}/delete', [
  'uses' => '\Webcraft\Http\Controllers\StatusController@putDelete',
  'as' => 'status.delete',
  'middleware' => ['auth']
]);

Route::put('/status/{id}/like', [
  'uses' => '\Webcraft\Http\Controllers\StatusController@putLikeStatus',
  'as' => 'status.like',
  'middleware' => ['auth']
]);

Route::put('/status/{id}/comment', [
  'uses' => '\Webcraft\Http\Controllers\StatusController@putCommentStatus',
  'as' => 'status.comment',
  'middleware' => ['auth']
]);

/*
* Comments
*/

Route::put('/comment/{id}/like', [
  'uses' => '\Webcraft\Http\Controllers\CommentController@putLike',
  'as' => 'comment.like',
  'middleware' => ['auth']
]);