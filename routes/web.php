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

    Route::get('show_password_reset_form', 'AdminController@showInsidePasswordResetForm')
        ->name('show_password_reset_form');
    Route::patch('self_update_password', 'AdminController@selfUpdatePassword')
        ->name('self_update_password');

    Route::get('categories', 'AdminController@categories')->name('categories');
    Route::get('industry_categories', 'AdminController@industryCategories')
        ->name('industry_categories');

    Route::get('benchmark/index', 'AdminBenchmarkController@index')->name('benchmark.index');
    Route::get('benchmark/get_brands', 'AdminBenchmarkController@getBrands')
        ->name('benchmark.get_brands');
    Route::post('benchmark/pass_brands_category', 'AdminBenchmarkController@passBrandsAndCategory')
        ->name('benchmark.pass_brands_category');

    Route::get('winner/index', 'AdminWinnerController@index')->name('winner.index');
    Route::get('winner/show_category_results/{category}', 'AdminWinnerController@showCategoryResults')
        ->name('winner.show_category_results');
    Route::post('winner/set_winners', 'AdminWinnerController@setWinners')
        ->name('winner.set_winners');

    Route::resource('client', 'AdminClientController')->except(['create', 'store'])
        ->names([
            'index' => 'client.index',
            'show' => 'client.show',
            'edit' => 'client.edit',
            'update' => 'client.update',
            'destroy' => 'client.destroy',
        ]);

    Route::get('client/toggle_status/{client}', 'AdminClientController@toggleStatus')
        ->name('client.toggle_status');

    Route::patch('client/{client}/password', 'AdminClientController@updatePassword')
        ->name('client.update_password');

    Route::resource('brand', 'AdminBrandController')->except(['create', 'store'])
        ->names([
            'create' => 'brand.create',
            'index' => 'brand.index',
            'show' => 'brand.show',
            'edit' => 'brand.edit',
            'update' => 'brand.update',
            'destroy' => 'brand.destroy',
        ]);

    Route::post('brand/set_options', 'AdminBrandController@setOptions')
        ->name('brand.set_options');

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

    Route::resource('auditor', 'AdminAuditorController')->except('show')
        ->names([
            'create' => 'auditor.create',
            'store' => 'auditor.store',
            'index' => 'auditor.index',
            'edit' => 'auditor.edit',
            'update' => 'auditor.update',
            'destroy' => 'auditor.destroy',
        ]);

    Route::get('auditor/toggle_status/{auditor}', 'AdminAuditorController@toggleStatus')
        ->name('auditor.toggle_status');
    Route::patch('auditor/{auditor}/password', 'AdminAuditorController@updatePassword')
        ->name('auditor.update_password');
    Route::get('auditor/get_entries', 'AdminAuditorController@getEntries')
        ->name('auditor.get_entries');

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

    Route::get('judge/allow_all_judges', 'AdminJudgeController@allowAllJudges')->name('judge.allow_all_judges');
    Route::get('judge/block_all_judges', 'AdminJudgeController@blockAllJudges')->name('judge.block_all_judges');

    Route::get('judge/toggle_status/{judge}', 'AdminJudgeController@toggleStatus')->name('judge.toggle_status');

    Route::patch('judge/{judge}/password', 'AdminJudgeController@updatePassword')
        ->name('judge.update_password');

    Route::post('judge/set_blocked', 'AdminJudgeController@setBlocked')
        ->name('judge.set_blocked');

    Route::post('judge/unlock', 'AdminJudgeController@unlock')
        ->name('judge.unlock');

    Route::resource('sme', 'AdminSmeController')->except(['show'])
        ->names([
            'create' => 'sme.create',
            'store' => 'sme.store',
            'index' => 'sme.index',
            'edit' => 'sme.edit',
            'update' => 'sme.update',
            'destroy' => 'sme.destroy',
        ]);

    Route::post('sme/set_judges', 'AdminSmeController@setJudges')
        ->name('sme.set_judges');

    ////////////////////////////////// Round 1 Scores ////////////////////////////////////////
    Route::get('score/judge_wise', 'AdminScoreController@judgeWise')->name('score.judge_wise');
    Route::get('score/entry_wise', 'AdminScoreController@entryWise')->name('score.entry_wise');

    Route::get('score/judge_wise_entries/{judge}', 'AdminScoreController@judgeWiseEntries')
        ->name('score.judge_wise_entries');

    Route::get('score/entry_wise_judges/{brand}', 'AdminScoreController@entryWiseJudges')
        ->name('score.entry_wise_judges');

    Route::get('score/show/{judge}/{brand}/{direction}', 'AdminScoreController@show')
        ->name('score.show');
    //////////////////////////////////  Round 1 Scores end ///////////////////////////////////

    ////////////////////////////////// Round 1 SME Scores ////////////////////////////////////////

    Route::prefix('sme')->name('sme.')->group(function () {
        Route::get('score/judge_wise', 'AdminSmeScoreController@judgeWise')->name('score.judge_wise');
        Route::get('score/entry_wise', 'AdminSmeScoreController@entryWise')->name('score.entry_wise');

        Route::get('score/judge_wise_entries/{judge}', 'AdminSmeScoreController@judgeWiseEntries')
            ->name('score.judge_wise_entries');

        Route::get('score/entry_wise_judges/{sme}', 'AdminSmeScoreController@entryWiseJudges')
            ->name('score.entry_wise_judges');

        Route::get('score/show/{judge}/{sme}/{direction}', 'AdminSmeScoreController@show')
            ->name('score.show');
    });

    //////////////////////////////////  Round 1 SME Scores end ///////////////////////////////////

    ////////////////////////////////// Round 2 Scores ////////////////////////////////////////
    Route::get('score/judge_wise2', 'AdminScoreR2Controller@judgeWise')->name('score.judge_wise2');
    Route::get('score/entry_wise2', 'AdminScoreR2Controller@entryWise')->name('score.entry_wise2');

    Route::get('score/judge_wise_entries2/{judge}', 'AdminScoreR2Controller@judgeWiseEntries')
        ->name('score.judge_wise_entries2');

    Route::get('score/entry_wise_judges2/{brand}', 'AdminScoreR2Controller@entryWiseJudges')
        ->name('score.entry_wise_judges2');

    Route::get('score/show2/{judge}/{brand}/{direction}', 'AdminScoreR2Controller@show')
        ->name('score.show2');
    //////////////////////////////////  Round 2 Scores end //////////////////////////////////////////

    ////////////////////////////////// Round 2 SME Scores ////////////////////////////////////////

    Route::prefix('sme')->name('sme.')->group(function () {
        Route::get('score/judge_wise_r2', 'AdminSmeScoreR2Controller@judgeWise')->name('score.judge_wise_r2');
        Route::get('score/entry_wise_r2', 'AdminSmeScoreR2Controller@entryWise')->name('score.entry_wise_r2');

        Route::get('score/judge_wise_entries_r2/{judge}', 'AdminSmeScoreController@judgeWiseEntries')
            ->name('score.judge_wise_entries_r2');

        Route::get('score/entry_wise_judges_r2/{sme}', 'AdminSmeScoreR2Controller@entryWiseJudges')
            ->name('score.entry_wise_judges_r2');

        Route::get('score/show_r2/{judge}/{sme}/{direction}', 'AdminSmeScoreR2Controller@show')
            ->name('score.show_r2');
    });

    //////////////////////////////////  Round 2 SME Scores end ///////////////////////////////////
});


Route::prefix('super')->name('super.')->middleware(['verified', 'auth:admin', 'is_super',])
    ->group(function () {

    Route::get('go_to_round_two', 'SuController@goToRoundTwo')->name('go_to_round_two');
    Route::get('go_back_to_round_one', 'SuController@goBackToRoundOne')->name('go_back_to_round_one');

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



Route::prefix('client')->name('client.')->middleware(['verified', 'auth:client', 'allowed'])->group(function () {

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

Route::prefix('home')->name('client.')->middleware(['verified', 'auth:client', 'allowed'])->group(function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('{client}/edit', 'HomeController@edit')->name('edit');
    Route::patch('update/{client}', 'HomeController@update')->name('update');

    Route::patch('self_update_password', 'HomeController@selfUpdatePassword')
        ->name('self_update_password');
    Route::get('show_password_reset_form', 'HomeController@showInsidePasswordResetForm')
        ->name('show_password_reset_form');
});



Route::prefix('judge')->middleware(['verified', 'auth:judge', 'allowed', 'judge_status'])
    ->name('judge.')->group(function () {

    Route::middleware(['judge_first_pw_reset'])->group(function () {

        ///////////////////////////////// JudgeController Start ////////////////////////////////////////

        Route::get('/', 'JudgeController@index')->name('index');
        Route::get('my_scores', 'JudgeController@myScores')->name('my_scores');
        Route::get('score_pattern', 'JudgeController@scorePattern')->name('score_pattern');
        Route::get('score/{brand}', 'JudgeController@score')->name('score');
        Route::post('store/{brand}', 'JudgeController@store')->name('store');
        Route::post('store_csr/{brand}', 'JudgeController@storeCsr')->name('store_csr');
        Route::get('edit/{brand}', 'JudgeController@edit')->name('edit');
        Route::get('show_score/{brand}', 'JudgeController@showScore')->name('show_score');
        Route::patch('update/{brand}', 'JudgeController@update')->name('update');
        Route::patch('update_csr/{brand}', 'JudgeController@updateCsr')->name('update_csr');
        Route::post('finalize', 'JudgeController@finalize')->name('finalize');
        Route::post('recuse', 'JudgeController@recuse')->name('recuse');

        ///////////////////////////////// JudgeController Ends ///////////////////////////////////////////

        ///////////////////////////////// JudgeR2Controller Start ////////////////////////////////////////

        Route::get('index2', 'JudgeR2Controller@index')->name('index2');
        Route::get('my_scores2', 'JudgeR2Controller@myScores')->name('my_scores2');
        Route::get('score_pattern2', 'JudgeR2Controller@scorePattern')->name('score_pattern2');
        Route::get('score2/{brand}', 'JudgeR2Controller@score')->name('score2');
        Route::post('store2/{brand}', 'JudgeR2Controller@store')->name('store2');
        Route::post('store2_csr/{brand}', 'JudgeR2Controller@storeCsr')->name('store2_csr');
        Route::get('edit2/{brand}', 'JudgeR2Controller@edit')->name('edit2');
        Route::get('show_score2/{brand}', 'JudgeR2Controller@showScore')->name('show_score2');
        Route::patch('update2/{brand}', 'JudgeR2Controller@update')->name('update2');
        Route::patch('update2_csr/{brand}', 'JudgeR2Controller@updateCsr')->name('update2_csr');
        Route::post('finalize2', 'JudgeR2Controller@finalize')->name('finalize2');

        ///////////////////////////////// JudgeR2Controller Ends ////////////////////////////////////////


        ///////////////////////////////// JudgeSmeController Starts ////////////////////////////////////////

        Route::prefix('sme')->name('sme.')->group(function () {
            Route::get('index_r1', 'JudgeSmeController@indexR1')->name('index_r1');
            Route::get('my_scores_r1', 'JudgeSmeController@myScoresR1')->name('my_scores_r1');
            Route::get('show_score_r1/{sme}', 'JudgeSmeController@showScoreR1')->name('show_score_r1');
            Route::get('score_pattern_r1', 'JudgeSmeController@scorePatternR1')->name('score_pattern_r1');
            Route::get('score_r1/{sme}', 'JudgeSmeController@scoreR1')->name('score_r1');
            Route::post('store_r1/{sme}', 'JudgeSmeController@storeR1')->name('store_r1');
            Route::get('edit_r1/{sme}', 'JudgeSmeController@editR1')->name('edit_r1');
            Route::post('update_r1/{sme}', 'JudgeSmeController@updateR1')->name('update_r1');
            Route::post('finalize_r1', 'JudgeSmeController@finalizeR1')->name('finalize_r1');


            Route::get('index_r2', 'JudgeSmeController@indexR2')->name('index_r2');
            Route::get('my_scores_r2', 'JudgeSmeController@myScoresR2')->name('my_scores_r2');
            Route::get('show_score_r2/{sme}', 'JudgeSmeController@showScoreR2')->name('show_score_r2');
            Route::get('score_pattern_r2', 'JudgeSmeController@scorePatternR2')->name('score_pattern_r2');
            Route::get('score_r2/{sme}', 'JudgeSmeController@scoreR2')->name('score_r2');
            Route::post('store_r2/{sme}', 'JudgeSmeController@storeR2')->name('store_r2');
            Route::get('edit_r2/{sme}', 'JudgeSmeController@editR2')->name('edit_r2');
            Route::post('update_r2/{sme}', 'JudgeSmeController@updateR2')->name('update_r2');
            Route::post('finalize_r2', 'JudgeSmeController@finalizeR2')->name('finalize_r2');

        });
        ///////////////////////////////// JudgeSmeController Starts ////////////////////////////////////////

    });

    Route::patch('self_update_password', 'JudgeController@selfUpdatePassword')
        ->name('self_update_password');
    Route::get('show_password_reset_form', 'JudgeController@showInsidePasswordResetForm')
        ->name('show_password_reset_form');

});


Route::prefix('auditor')->middleware(['verified', 'auth:auditor', 'allowed'])
    ->name('auditor.')->group(function () {

    Route::get('/', 'AuditorController@index')->name('index');
    Route::patch('self_update_password', 'AuditorController@selfUpdatePassword')
        ->name('self_update_password');
    Route::get('show_password_reset_form', 'AuditorController@showInsidePasswordResetForm')
        ->name('show_password_reset_form');
    Route::get('get_summary', 'AuditorController@getSummary')
        ->name('get_summary');
    Route::post('finalize_selected_entries', 'AuditorController@finalizeSelectedEntries')
        ->name('finalize_selected_entries');
});



