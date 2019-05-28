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

    Route::resource('/client/brands', 'ClientBrandController');

    Route::get('/client/brands/{brand}/entry_kit', 'ClientBrandController@showEntryKit')
        ->name('brands.show.entrykit');

    Route::get('/client/brands/{brand}/logo', 'ClientBrandController@showLogo')
        ->name('brands.show.logo');

    Route::resource('/client', 'ClientController')->only(['index', 'edit', 'update']);

    Route::patch('/client/{client}/password', 'ClientController@updatePassword')->name('client.update.password');

});


