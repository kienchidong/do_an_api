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

/* $router->get('/', function () use ($router) {
     return view('welcome');
 });*/


$router->get('test', 'TestController@test');
$router->post('/upload', 'TestController@upload');
$router->get('deleteCate/{id}', 'Admin\CateNewsController@destroy');
$router->prefix('tests')->group(function () use ($router){
    $router->get('getList', 'Admin\Test\TestController@getList');

    $router->get('createSimple', 'Admin\Test\TestController@createSimpleTest');
});

$router->group(['middleware' => 'locale'], function () use ($router) {
    $router->get('change-language/{language}', 'LanguageController@changeLanguage')->name(change_language);
    Auth::routes();
    /* Route cho admin */

    $router->prefix('/')->group(function () use ($router) {
        /**
         *middleware Login admin
         * */
        $router->get('loginAdmin.html', 'Auth\Admin\AdminLoginController@index')->name('admin.login');
        $router->post('loginAdmin', 'Auth\Admin\AdminLoginController@login')->name('admin.login.post');

        /**
         * Logout admin
         * */
        $router->get('logoutAdmin', 'Auth\Admin\AdminLoginController@logout')->name('admin.logout');

        $router->prefix('/')->middleware('auth:admin')->group(function () use ($router) {

            $router->prefix('home')->group(function () use ($router) {
                $router->post('getHome', 'Auth\Admin\HomeAdminController@getHome');
            });

            $router->prefix('adminAccount')->group(function () use ($router) {
                $router->post('getlist', 'Admin\AdminAccountController@getList');
                $router->post('createAdmin', 'Admin\AdminAccountController@store');
                $router->post('createUser', 'Admin\UserAccountController@store');

                /**
                 * userAccount
                 * */
                $router->post('getListUser', 'Admin\UserAccountController@getList');
                $router->get('lockUser/{user_id}/{status}', 'Admin\UserAccountController@lockUser');


                /*role and permission*/
                $router->get('getRoles', 'Admin\AdminAccountController@getRoles');
                $router->get('getPermissions/{role_id}', 'Admin\AdminAccountController@getPermissions');

                $router->get('adminHasPermission/{id}', 'Admin\AdminAccountController@adminHasPermission');
                $router->post('setPermission', 'Admin\AdminAccountController@setPermission');
            });

            /**
             * Bài Viết
             * */
            $router->prefix('news')->group(function () use ($router) {
                $router->post('getListCate', 'Admin\CateNewsController@getList');
                $router->post('createCate', 'Admin\CateNewsController@store');
                $router->post('editCate/{id}', 'Admin\CateNewsController@update');
                $router->post('deleteCate/{id}', 'Admin\CateNewsController@destroy');

                $router->post('createNews', 'Admin\NewsController@store');
                $router->post('getListNews', 'Admin\NewsController@getList');
                $router->get('EditNews/{id}', 'Admin\NewsController@edit');
                $router->post('Update/{id}', 'Admin\NewsController@update');
                $router->delete('DeleteNews/{id}', 'Admin\NewsController@destroy');
            });

            /** câu hỏi
             *
             * */
            $router->prefix('question')->group(function () use ($router) {
                $router->get('getLevel', 'Admin\Questions\LevelController@getList');
                $router->get('getDetailLevel', 'Admin\Questions\LevelController@getDetail');

                $router->post('createGroupQuestions', 'Admin\Questions\GroupQuestionsController@store');

                $router->post('createQuestions', 'Admin\Questions\QuestionsController@store');
                $router->post('updateQuestions/{id}', 'Admin\Questions\QuestionsController@update');
                $router->prefix('simple')->group(function () use ($router) {
                    $router->post('getList', 'Admin\Questions\QuestionsController@getList');
                    $router->delete('delete/{id}', 'Admin\Questions\QuestionsController@destroy');

                    $router->post('import', 'Admin\Questions\QuestionsController@import');
                });

                $router->prefix('group')->group(function () use ($router) {
                    $router->post('getList', 'Admin\Questions\GroupQuestionsController@getList');

                    $router->get('edit/{id}', 'Admin\Questions\GroupQuestionsController@edit');
                    $router->put('edit/{id}', 'Admin\Questions\GroupQuestionsController@update');
                });
            });

            /** type of video */
            $router->prefix('typeVideo')->group(function () use ($router) {
                $router->post('getList', 'Video\TypeVideoController@getList');

                $router->post('store', 'Video\TypeVideoController@store');
                $router->post('edit/{id}', 'Video\TypeVideoController@update');
                $router->post('delete/{id}', 'Video\TypeVideoController@destroy');
            });
            $router->prefix('video')->group(function () use ($router) {
                $router->post('getList', 'Video\VideoController@getList');

                $router->post('store', 'Video\VideoController@store');
                $router->post('edit/{id}', 'Video\VideoController@update');
                $router->post('delete/{id}', 'Video\VideoController@destroy');
            });

            /**
             * feedback
             */
            $router->prefix('feedback')->group(function () use ($router){
                $router->post('getList', 'Feedback\FeedbackController@getList');
            });
            /**
             * route VueJs phải ở dưới cùng
             * */
            $router->any('{all}', 'Auth\Admin\HomeAdminController@index')->where(['all' => '.*'])->name('admin.index');
        });
    });
});

