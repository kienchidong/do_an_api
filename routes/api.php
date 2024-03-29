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

$router->post('test', 'Result\ResultController@getList');
$router->middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$router->post('uploadFile', 'TestController@upload');

$router->middleware('guest:api')->post('login', 'Client\ClientController@login');

$router->get('/searchWord', 'Dictionary\DictionaryController@search');
$router->get('/searchList', 'Dictionary\DictionaryController@searchList');

$router->prefix('users')->group(function () use ($router) {
    $router->post('register', 'Client\Users\UsersController@register');
});

/** bắt buộc phải đăng nhập*/
$router->middleware('jwt.auth')->group(function () use ($router){
    $router->get('test', 'Client\ClientController@test');
    $router->post('logout', 'Client\ClientController@logout');

    $router->prefix('news')->group(function () use ($router){
        $router->post('likeNews', 'Client\News\NewsController@likeNews');
        $router->post('createComment', 'Client\News\CommentController@createComment');
    });

    $router->prefix('result')->group(function () use ($router){
       $router->post('store', 'Result\ResultController@store');
    });

    /** feedback */
    $router->prefix('feedback')->group(function () use ($router){
        $router->post('store', 'Feedback\FeedbackController@store');

    });

    $router->prefix('tests')->group(function () use ($router) {
        $router->post('answerWriting', 'Client\Tests\TestController@answerWriting');
    });
});


/** có thể không đăng nhập */
$router->middleware('loginOrNot')->group(function () use ($router){
    $router->prefix('home')->group(function () use ($router) {
       $router->post('getHotNews', 'Client\HomeController@getHotNews');
       $router->post('getListNewsUser', 'Client\HomeController@getListNewsUser');
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

        $router->post('getListReading', 'Client\Tests\TestController@getListReading');
        $router->post('getListListening', 'Client\Tests\TestController@getListListening');

        $router->post('getDetailReading', 'Client\Tests\TestController@getDetailReading');

        $router->post('createResult', 'Result\ResultController@store');
    });

    /** videos */
    $router->prefix('video')->group(function () use ($router) {
        $router->post('getListType', 'Video\TypeVideoController@getListMenu');

        $router->post('GetListByType', 'Video\TypeVideoController@getListVideo');

        $router->post('GetListVideo', 'Video\VideoController@getList');
        $router->post('getDetail', 'Client\Tests\TestController@getDetail');
    });

    /** User */
    $router->prefix('users')->group(function () use ($router) {
        $router->post('profile', 'Client\Users\UsersController@getProfile');
    });

    /** feedback */
    $router->prefix('feedback')->group(function () use ($router) {
        $router->post('getList', 'Client\HomeController@getFeedback');
    });

    $router->prefix('result')->group(function () use ($router){
        $router->post('getListByUser', 'Result\ResultController@getListByUser');
    });

    $router->prefix('synthetic')->group(function () use ($router){
        $router->post('getList', 'Admin\SyntheticModel\SyntheticController@getList');
        $router->post('detail', 'Admin\SyntheticModel\SyntheticController@getDetail');
    });
});


