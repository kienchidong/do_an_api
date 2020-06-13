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
Route::middleware('jwt.auth')->group(function (){
    Route::get('test', 'Client\ClientController@test');
    Route::post('logout', 'Client\ClientController@logout');

    Route::post('likeNews', 'Client\NewsController@likeNews');

});

Route::middleware('guest:api')->post('login', 'Client\ClientController@login');

Route::get('/searchWord', 'Dictionary\DictionaryController@search');
Route::get('/searchList', 'Dictionary\DictionaryController@searchList');

/*news*/
Route::post('GetCateNews', 'Client\CateNewsController@getList');
Route::middleware('auth:api')->post('getListNews', 'Client\CateNewsController@getListNews');

Route::post('/getNews', 'Client\NewsController@getNews');


