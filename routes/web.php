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

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//Auth::routes(['verify' => true]);
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/reset_pw', 'Auth\ResetPasswordController@index')->name('reset_password');
    Route::patch('/update_pw', 'Auth\ResetPasswordController@update')->name('update_password');


    Route::group(['middleware' => 'admin'], function () {

        Route::get('/admin', 'AdminController@index')->name('admin.index');

        Route::get('/admin/categories', 'AdminController@categories')->name('categories.show_all');
        Route::get('/admin/industry_categories', 'AdminController@industryCategories')
            ->name('industry_categories.show_all');

        Route::resource('/admin/clients', 'AdminClientController')->except(['create', 'store']);

        Route::resource('/admin/brands', 'AdminBrandController', ['as' => 'admin'])->except(['create', 'store']);

        Route::resource('/admin/judges', 'AdminJudgeController', ['as' => 'admin']);

        Route::patch('/admin/judges/{judge}/password', 'AdminJudgeController@updatePassword')
            ->name('judges.update.password');

        Route::post('/admin/judges/set_blocked', 'AdminJudgeController@setBlocked')->name('judges.set_blocked');

        Route::post('/admin/brands/set_options', 'AdminBrandController@setOptions')->name('admin.brands.set_options');

        Route::patch('/admin/clients/{client}/password', 'AdminClientController@updatePassword')
            ->name('clients.update.password');

        Route::get('/admin/scores/judge_wise', 'AdminScoreController@judgeWise')->name('scores.judgeWise');
        Route::get('/admin/scores/entry_wise', 'AdminScoreController@entryWise')->name('scores.entryWise');

        Route::get('/admin/scores/judge_wise_entries/{judge}', 'AdminScoreController@judgeWiseEntries')
            ->name('scores.judgeWiseEntries');
        Route::get('/admin/scores/entry_wise_judges/{brand}', 'AdminScoreController@entryWiseJudges')
            ->name('scores.entryWiseJudges');
        Route::get('/admin/scores/show/{judge}/{brand}/{direction}', 'AdminScoreController@show')
            ->name('scores.show');

    });




    Route::group(['middleware' => 'super'], function () {

        Route::resource('/super/admins', 'SuperUserAdminController');
        Route::resource('/super/categories', 'SuperUserCategoryController')->except(['show']);
        Route::resource('/super/industry_categories', 'SuperUserIndustryCategoryController')->except(['show']);

        Route::patch('/super/admins/{admin}/password', 'SuperUserAdminController@updatePassword')
            ->name('admins.update.password');
    });



    Route::group(['middleware' => 'client'], function () {

        Route::get('/client/send_invoice', 'ClientBrandController@sendInvoice')
            ->name('client.send_invoice');

        Route::get('/client/session_test', function () {
            return view('client.session_test');
        })->name('client.session_test');

        Route::resource('/client/brands', 'ClientBrandController');

        Route::get('/client/brands/{brand}/entry_kit', 'ClientBrandController@showEntryKit')
            ->name('brands.show.entrykit');

        Route::get('/client/brands/{brand}/logo', 'ClientBrandController@showLogo')
            ->name('brands.show.logo');

        Route::resource('/client', 'ClientController')->only(['index', 'edit', 'update']);

        Route::patch('/client/{client}/password', 'ClientController@updatePassword')->name('client.update.password');

    });


    Route::group(['middleware' => 'judge'], function () {

        Route::get('/judge', 'JudgeController@index')->name('judge.index');
        Route::get('/judge/my_scores', 'JudgeController@myScores')->name('judge.my_scores');
        Route::get('/judge/score/{brand}', 'JudgeController@score')->name('judge.score');
        Route::post('/judge/store/{brand}', 'JudgeController@store')->name('judge.store');
        Route::get('/judge/edit/{brand}', 'JudgeController@edit')->name('judge.edit');
        Route::get('/judge/show_score/{brand}', 'JudgeController@showScore')->name('judge.showScore');
        Route::patch('/judge/update/{brand}', 'JudgeController@update')->name('judge.update');

    });

});


