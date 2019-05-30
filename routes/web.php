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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/send_mail', function () {
//    Mail::to(['lahirukk01@gmail.com'])
//        ->cc('lahiru.k.k@icloud.com')
//        ->send(new \App\Mail\BrandRegistered(\App\Brand::first()));
//
//    return 'Email was sent';
//});


Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'admin'], function () {

        Route::get('/admin', 'AdminController@index')->name('admin.index');

        Route::get('/admin/categories', 'AdminController@categories')->name('categories.show_all');

        Route::resource('/admin/clients', 'AdminClientController')->except(['create', 'store']);

        Route::resource('/admin/brands', 'AdminBrandController', ['as' => 'admin'])->except(['create', 'store']);

        Route::patch('/admin/clients/{client}/password', 'AdminClientController@updatePassword')
            ->name('clients.update.password');
    });




    Route::group(['middleware' => 'super'], function () {

        Route::resource('/super/admins', 'SuperUserAdminController');
        Route::resource('/super/categories', 'SuperUserCategoryController')->except(['show']);

        Route::patch('/super/admins/{admin}/password', 'SuperUserAdminController@updatePassword')
            ->name('admins.update.password');
    });



    Route::group(['middleware' => 'client'], function () {

        Route::resource('/client/brands', 'ClientBrandController');

        Route::get('/client/brands/{brand}/entry_kit', 'ClientBrandController@showEntryKit')
            ->name('brands.show.entrykit');

        Route::get('/client/brands/{brand}/logo', 'ClientBrandController@showLogo')
            ->name('brands.show.logo');

        Route::resource('/client', 'ClientController')->only(['index', 'edit', 'update']);

        Route::patch('/client/{client}/password', 'ClientController@updatePassword')->name('client.update.password');

    });



});


