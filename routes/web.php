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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
//Auth::routes();



///////////////////// These are routes for login pages /////////////////////////

Route::get('/judge/login', 'Auth\JudgeLoginController@showLoginForm')->name('judge.login');
Route::post('/judge/login', 'Auth\JudgeLoginController@login')->name('judge.login.submit');
Route::get('/judge', 'JudgeController@index')->name('judge.dashboard');

Route::get('/auditor/login', 'Auth\AuditorLoginController@showLoginForm')->name('auditor.login');
Route::post('/auditor/login', 'Auth\AuditorLoginController@login')->name('auditor.login.submit');
Route::get('/auditor', 'AuditorController@index')->name('auditor.dashboard');


Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin', 'AdminController@index')->name('admin.dashboard');

////////////////////// Routes for login pages end //////////////////////////////////



////////////////////// These are routes for password reset relevant pages of login pages //////////////////

Route::prefix('admin')->group(function () {
    Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');

    Route::post('password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');;
    Route::get('password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});

Route::prefix('auditor')->group(function () {
    Route::post('password/email', 'Auth\AuditorForgotPasswordController@sendResetLinkEmail')->name('auditor.password.email');
    Route::get('password/reset', 'Auth\AuditorForgotPasswordController@showLinkRequestForm')->name('auditor.password.request');

    Route::post('password/reset', 'Auth\AuditorResetPasswordController@reset')->name('auditor.password.update');;
    Route::get('password/reset/{token}', 'Auth\AuditorResetPasswordController@showResetForm')->name('auditor.password.reset');
});

Route::prefix('judge')->group(function () {
    Route::post('password/email', 'Auth\JudgeForgotPasswordController@sendResetLinkEmail')->name('judge.password.email');
    Route::get('password/reset', 'Auth\JudgeForgotPasswordController@showLinkRequestForm')->name('judge.password.request');

    Route::post('password/reset', 'Auth\JudgeResetPasswordController@reset')->name('judge.password.update');;
    Route::get('password/reset/{token}', 'Auth\JudgeResetPasswordController@showResetForm')->name('judge.password.reset');
});

/////////////////////////////// Routes for password reset relevant pages end ///////////////////////////////


Route::prefix('admin')->name('admin.')->middleware(['verified', 'auth:admin', ])->group(function () {

    Route::get('/', 'AdminController@index')->name('index');

    Route::get('benchmark/index', 'AdminBenchmarkController@index')->name('benchmark.index');
    Route::get('benchmark/get_brands', 'AdminBenchmarkController@getBrands')->name('benchmark.get_brands');
    Route::post('benchmark/pass_brands_category', 'AdminBenchmarkController@passBrandsAndCategory')
        ->name('benchmark.pass_brands_category');

    Route::get('show_password_reset_form', 'AdminController@showInsidePasswordResetForm')->name('show_password_reset_form');
    Route::patch('self_update_password', 'AdminController@selfUpdatePassword')->name('self_update_password');

    Route::get('categories', 'AdminController@categories')->name('categories');
    Route::get('industry_categories', 'AdminController@industryCategories')
        ->name('industry_categories');

    Route::get('go_to_round_two', 'AdminController@goToRoundTwo')->name('go_to_round_two');

    Route::resource('client', 'AdminClientController')->except(['create', 'store'])
        ->names([
            'index' => 'client.index',
            'show' => 'client.show',
            'edit' => 'client.edit',
            'update' => 'client.update',
            'destroy' => 'client.destroy',
        ]);

    Route::get('client/toggle_status/{client}', 'AdminClientController@toggleStatus')->name('client.toggle_status');

    Route::resource('brand', 'AdminBrandController')->except(['create', 'store'])
        ->names([
            'create' => 'brand.create',
            'index' => 'brand.index',
            'show' => 'brand.show',
            'edit' => 'brand.edit',
            'update' => 'brand.update',
            'destroy' => 'brand.destroy',
        ]);

    Route::resource('panel', 'AdminPanelController')
        ->names([
            'create' => 'panel.create',
            'store' => 'panel.store',
            'index' => 'panel.index',
            'show' => 'panel.show',
            'edit' => 'panel.edit',
            'update' => 'panel.update',
            'destroy' => 'panel.destroy',
        ]);

    Route::resource('auditor', 'AdminAuditorController')
        ->names([
            'create' => 'auditor.create',
            'store' => 'auditor.store',
            'index' => 'auditor.index',
            'edit' => 'auditor.edit',
            'update' => 'auditor.update',
            'destroy' => 'auditor.destroy',
        ]);

    Route::get('auditor/toggle_status/{auditor}', 'AdminAuditorController@toggleStatus')->name('auditor.toggle_status');
    Route::patch('auditor/{auditor}/password', 'AdminAuditorController@updatePassword')
        ->name('auditor.update_password');

    Route::resource('judge', 'AdminJudgeController')
        ->names([
            'create' => 'judge.create',
            'store' => 'judge.store',
            'index' => 'judge.index',
            'show' => 'judge.show',
            'edit' => 'judge.edit',
            'update' => 'judge.update',
            'destroy' => 'judge.destroy',
        ]);

    Route::get('judge/toggle_status/{judge}', 'AdminJudgeController@toggleStatus')->name('judge.toggle_status');

    Route::patch('judge/{judge}/password', 'AdminJudgeController@updatePassword')
        ->name('judge.update_password');

    Route::post('judge/set_blocked', 'AdminJudgeController@setBlocked')
        ->name('judge.set_blocked');

    Route::post('judge/unlock', 'AdminJudgeController@unlock')
        ->name('judge.unlock');

    Route::post('brand/set_options', 'AdminBrandController@setOptions')
        ->name('brand.set_options');

    Route::patch('client/{client}/password', 'AdminClientController@updatePassword')
        ->name('client.update_password');

    Route::get('score/judge_wise', 'AdminScoreController@judgeWise')->name('score.judge_wise');
    Route::get('score/entry_wise', 'AdminScoreController@entryWise')->name('score.entry_wise');

    Route::get('score/judge_wise_entries/{judge}', 'AdminScoreController@judgeWiseEntries')
        ->name('score.judge_wise_entries');

    Route::get('score/entry_wise_judges/{brand}', 'AdminScoreController@entryWiseJudges')
        ->name('score.entry_wise_judges');

    Route::get('score/show/{judge}/{brand}/{direction}', 'AdminScoreController@show')
        ->name('score.show');

});



Route::prefix('super')->name('super.')->middleware(['verified', 'auth:admin', ])->group(function () {

    Route::resource('admin', 'SuAdminController')->names([
        'create' => 'admin.create',
        'store' => 'admin.store',
        'index' => 'admin.index',
        'show' => 'admin.show',
        'edit' => 'admin.edit',
        'update' => 'admin.update',
        'destroy' => 'admin.destroy',
    ]);

    Route::resource('category', 'SuCategoryController')->except(['show'])->names([
        'create' => 'category.create',
        'store' => 'category.store',
        'index' => 'category.index',
        'edit' => 'category.edit',
        'update' => 'category.update',
        'destroy' => 'category.destroy',
    ]);

    Route::resource('industry_category', 'SuIndustryCategoryController')->except(['show'])
        ->names([
        'create' => 'industry_category.create',
        'store' => 'industry_category.store',
        'index' => 'industry_category.index',
        'edit' => 'industry_category.edit',
        'update' => 'industry_category.update',
        'destroy' => 'industry_category.destroy',
    ]);

    Route::patch('admin/{admin}/password', 'SuAdminController@updatePassword')
        ->name('admin.update_password');
});



Route::prefix('client')->name('client.')->middleware(['verified', 'auth:client',])->group(function () {

    Route::get('brand/send_invoice', 'ClientBrandController@sendInvoice')
        ->name('brand.send_invoice');

    Route::resource('brand', 'ClientBrandController')->names([
        'create' => 'brand.create',
        'store' => 'brand.store',
        'index' => 'brand.index',
        'show' => 'brand.show',
        'edit' => 'brand.edit',
        'update' => 'brand.update',
        'destroy' => 'brand.destroy',
    ]);

    Route::post('brand/get_number_of_entries', 'ClientBrandController@getNumberOfEntries')
        ->name('brand.get_number_of_entries');

    Route::get('brand/{brand}/entry_kit', 'ClientBrandController@showEntryKit')
        ->name('brand.show_entry_kit');

    Route::get('brand/{brand}/logo', 'ClientBrandController@showLogo')
        ->name('brand.show_logo');

});



Route::prefix('home')->name('client.')->middleware(['verified', 'auth:client',])->group(function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('{client}/edit', 'HomeController@edit')->name('edit');
    Route::patch('update/{client}', 'HomeController@update')->name('update');

    Route::patch('self_update_password', 'HomeController@selfUpdatePassword')
        ->name('self_update_password');
    Route::get('show_password_reset_form', 'HomeController@showInsidePasswordResetForm')
        ->name('show_password_reset_form');
});


Route::prefix('judge')->middleware(['verified', 'auth:judge',])->name('judge.')->group(function () {

    Route::get('/', 'JudgeController@index')->name('index');
    Route::get('my_scores', 'JudgeController@myScores')->name('my_scores');
    Route::get('score_pattern', 'JudgeController@scorePattern')->name('score_pattern');
    Route::get('score/{brand}', 'JudgeController@score')->name('score');
    Route::post('store/{brand}', 'JudgeController@store')->name('store');
    Route::get('edit/{brand}', 'JudgeController@edit')->name('edit');
    Route::get('show_score/{brand}', 'JudgeController@showScore')->name('show_score');
    Route::patch('update/{brand}', 'JudgeController@update')->name('update');
    Route::post('finalize', 'JudgeController@finalize')->name('finalize');

    Route::get('index2', 'JudgeR2Controller@index')->name('index2');
    Route::get('my_scores2', 'JudgeR2Controller@myScores')->name('my_scores2');
    Route::get('score_pattern2', 'JudgeR2Controller@scorePattern')->name('score_pattern2');
    Route::get('score2/{brand}', 'JudgeR2Controller@score')->name('score2');
    Route::post('store2/{brand}', 'JudgeR2Controller@store')->name('store2');
    Route::get('edit2/{brand}', 'JudgeR2Controller@edit')->name('edit2');
    Route::get('show_score2/{brand}', 'JudgeR2Controller@showScore')->name('show_score2');
    Route::patch('update2/{brand}', 'JudgeR2Controller@update')->name('update2');
    Route::post('finalize2', 'JudgeR2Controller@finalize')->name('finalize2');

    Route::patch('self_update_password', 'JudgeController@selfUpdatePassword')
        ->name('self_update_password');
    Route::get('show_password_reset_form', 'JudgeController@showInsidePasswordResetForm')
        ->name('show_password_reset_form');

});



