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

Route::get('/', 'IndexController@index');

Route::get('/apart/search', 'ApartmentController@search')->name('search');

Route::get('/filter', 'ApartmentController@filter')->name('filter');

Route::get('/apart/{alias}', 'ApartmentController@show')->name('show.apart');
Route::post('/apart/{alias}/book', 'ApartmentController@createBook')->name('book.create');

Route::group(['prefix' => 'admin_area','middleware'=> 'admin'],function() {
    // update user status
    Route::post('/user/ups', 'Admin\UserController@updateStatus');
    // admin
    Route::get('/',['uses' => 'Admin\IndexController@index','as' => 'adminIndex']);

    // apartment
    Route::resource('/apartment','Admin\ApartmentController', [
        'names' => [
            'store' => 'admin.apartment.store',
            'update' => 'admin.apartment.update',
            'create' => 'admin.apartment.create',
            'show' => 'admin.apartment.show',
            'destroy' => 'admin.apartment.destroy',
            'edit' => 'admin.apartment.edit',
            'update_status' => 'admin.apartment.status',
        ]
    ])->except('index');

    // update apartment status
    Route::post('/apartment/ups/{apartment}', 'Admin\ApartmentController@updateStatus');

    // user
    Route::resource('/user','Admin\UserController');

    // filter
    Route::get('/filter', 'Admin\ApartmentController@filter')->name('admin.filter');

});


Auth::routes();

Route::group(['prefix' => 'cabinet','middleware'=> ['is-ban', 'auth']],function() {

    // cabinet
    Route::get('/',['uses' => 'Cabinet\IndexController@index','as' => 'cabinetIndex']);

    // apartment
    Route::resource('/apartment','Cabinet\ApartmentController')->except('index');

    // book
    Route::resource('/book','Cabinet\BookController')->only(['index', 'show', 'destroy']);

});