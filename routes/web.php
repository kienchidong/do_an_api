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

/* Route::get('/', function () {
     return view('welcome');
 });*/

Route::get('test', 'TestController@test');
Route::get('deleteCate/{id}', 'Admin\CateNewsController@destroy');

Route::group(['middleware' => 'locale'], function () {
    Route::get('change-language/{language}', 'LanguageController@changeLanguage')->name(change_language);
    Auth::routes();
    /* Route cho admin */

    Route::prefix('/')->group(function () {
        /**
         *middleware Login admin
         * */
        Route::get('loginAdmin.html', 'Auth\Admin\AdminLoginController@index')->name('admin.login');
        Route::post('loginAdmin', 'Auth\Admin\AdminLoginController@login')->name('admin.login.post');

        /**
         * Logout admin
         * */
        Route::get('logoutAdmin', 'Auth\Admin\AdminLoginController@logout')->name('admin.logout');

        Route::prefix('/')->middleware('auth:admin')->group(function () {
            Route::prefix('adminAccount')->group(function () {
                Route::post('getlist', 'Admin\AdminAccountController@getList');
                Route::post('createAdmin', 'Admin\AdminAccountController@store');
                Route::post('createUser', 'Admin\UserAccountController@store');

                /**
                 * userAccount
                 * */
                Route::post('getListUser', 'Admin\UserAccountController@getList');
                Route::get('lockUser/{user_id}/{status}', 'Admin\UserAccountController@lockUser');


                /*role and permission*/
                Route::get('getRoles', 'Admin\AdminAccountController@getRoles');
                Route::get('getPermissions/{role_id}', 'Admin\AdminAccountController@getPermissions');

                Route::get('adminHasPermission/{id}', 'Admin\AdminAccountController@adminHasPermission');
                Route::post('setPermission', 'Admin\AdminAccountController@setPermission');
            });

            /**
             * Bài Viết
             * */
            Route::prefix('news')->group(function () {
                Route::post('getListCate', 'Admin\CateNewsController@getList');
                Route::post('createCate', 'Admin\CateNewsController@store');
                Route::post('editCate/{id}', 'Admin\CateNewsController@update');
                Route::post('deleteCate/{id}', 'Admin\CateNewsController@destroy');

                Route::post('createNews', 'Admin\NewsController@store');
                Route::post('getListNews', 'Admin\NewsController@getList');
                Route::get('EditNews/{id}', 'Admin\NewsController@edit');
                Route::post('Update/{id}', 'Admin\NewsController@update');
                Route::delete('DeleteNews/{id}', 'Admin\NewsController@destroy');
            });

            /** câu hỏi
             *
             * */
            Route::prefix('question')->group(function () {
                Route::get('getLevel', 'Admin\Questions\LevelController@getList');
                Route::get('getDetailLevel', 'Admin\Questions\LevelController@getDetail');

                Route::post('createGroupQuestions', 'Admin\Questions\GroupQuestionsController@store');

                Route::post('createQuestions', 'Admin\Questions\QuestionsController@store');
                Route::post('updateQuestions/{id}', 'Admin\Questions\QuestionsController@update');
                Route::prefix('simple')->group(function () {
                    Route::post('getList', 'Admin\Questions\QuestionsController@getList');
                    Route::delete('delete/{id}', 'Admin\Questions\QuestionsController@destroy');

                    Route::post('import', 'Admin\Questions\QuestionsController@import');
                });

                Route::prefix('group')->group(function () {
                    Route::post('getList', 'Admin\Questions\GroupQuestionsController@getList');

                    Route::get('edit/{id}', 'Admin\Questions\GroupQuestionsController@edit');
                    Route::put('edit/{id}', 'Admin\Questions\GroupQuestionsController@update');
                });
            });

            /**
             * route VueJs phải ở dưới cùng
             * */
            Route::any('{all}', 'Auth\Admin\HomeAdminController@index')->where(['all' => '.*'])->name('admin.index');
        });
    });
});

