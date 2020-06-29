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

$router->middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** bắt buộc phải đăng nhập*/
$router->middleware('jwt.auth')->group(function () use ($router){
    $router->get('test', 'Client\ClientController@test');
    $router->post('logout', 'Client\ClientController@logout');

    $router->prefix('news')->group(function () use ($router){
        $router->post('likeNews', 'Client\News\NewsController@likeNews');
        $router->post('createComment', 'Client\News\CommentController@createComment');
    });
});

$router->middleware('guest:api')->post('login', 'Client\ClientController@login');

$router->get('/searchWord', 'Dictionary\DictionaryController@search');
$router->get('/searchList', 'Dictionary\DictionaryController@searchList');

$router->prefix('users')->group(function () use ($router) {
    $router->post('register', 'Client\Users\UsersController@register');
});


/** có thể không đăng nhập */
$router->middleware('loginOrNot')->group(function () use ($router){
    $router->prefix('home')->group(function () use ($router) {
       $router->post('getHotNews', 'Client\HomeController@getHotNews');
    });


    /** news*/
    $router->prefix('news')->group(function () use ($router) {
        $router->post('GetCateNews', 'Client\News\CateNewsController@getList');
        $router->post('getListNews', 'Client\News\CateNewsController@getListNews');
        $router->post('getNews', 'Client\News\NewsController@getNews');

        $router->post('getCommentByNews', 'Client\News\CommentController@getComment');
        $router->post('getHotNews', 'Client\News\NewsController@getHotNews');
    });

    /** test */
    $router->prefix('tests')->group(function () use ($router) {
        $router->post('GetListByLevel', 'Client\Tests\TestController@getList');
        $router->post('getDetail', 'Client\Tests\TestController@getDetail');
    });

    /** videos */
    $router->prefix('video')->group(function () use ($router) {
        $router->post('GetListByType', 'Video\TypeVideoController@getListVideo');
        $router->post('getDetail', 'Client\Tests\TestController@getDetail');
    });


});


