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
Route::group(['prefix'=>'admin'],function (){
    Route::group(['prefix'=>'theloai'],function(){
        //admin/theloai/list
        Route::get('list','TheLoaiController@getList');
        Route::get('edit/{id}','TheLoaiController@getEdit');
        Route::post('edit/{id}','TheLoaiController@postEdit');
        Route::get('add','TheLoaiController@getAdd');
        Route::post('add','TheLoaiController@postAdd');
    });
    Route::group(['prefix'=>'loaitin'],function(){
        //admin/theloai/list
        Route::get('list','LoaiTinController@getList');
        Route::get('add','LoaiTinController@getAdd');
        Route::get('edit','LoaiTinController@getEdit');
    });
    Route::group(['prefix'=>'tintuc'],function(){
        //admin/theloai/list
        Route::get('list','TinTucController@getList');
        Route::get('add','TinTucController@getAdd');
        Route::get('edit','TinTucController@getEdit');
    });
    Route::group(['prefix'=>'slide'],function(){
        //admin/theloai/list
        Route::get('list','SlideController@getList');
        Route::get('add','SlideController@getAdd');
        Route::get('edit','SlideController@getEdit');
    });
    Route::group(['prefix'=>'user'],function(){
        //admin/theloai/list
        Route::get('list','UserController@getList');
        Route::get('add','UserController@getAdd');
        Route::get('edit','UserController@getEdit');
    });
});