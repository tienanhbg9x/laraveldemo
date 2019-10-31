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
Route::get('admin/login','UserController@getLoginAdmin');
Route::post('admin/login','UserController@postLoginAdmin');
Route::get('admin/logout','UserController@getLogoutAdmin');

Route::group(['prefix'=>'admin', 'middleware'=>'adminLogin'],function (){
    Route::group(['prefix'=>'theloai'],function(){
        //admin/theloai/list
        Route::get('list','TheLoaiController@getList');

        Route::get('edit/{id}','TheLoaiController@getEdit');
        Route::post('edit/{id}','TheLoaiController@postEdit');//truyền id để nó biết sửa thể loại nào

        Route::get('add','TheLoaiController@getAdd');
        Route::post('add','TheLoaiController@postAdd');

        Route::get('delete/{id}','TheLoaiController@getDelete');
    });

    Route::group(['prefix'=>'loaitin'],function(){
        //admin/theloai/list
        Route::get('list','LoaiTinController@getList');

        Route::get('edit/{id}','LoaiTinController@getEdit');
        Route::post('edit/{id}','LoaiTinController@postEdit');//truyền id để nó biết sửa thể loại nào

        Route::get('add','LoaiTinController@getAdd');
        Route::post('add','LoaiTinController@postAdd');

        Route::get('delete/{id}','LoaiTinController@getDelete');
    });

    Route::group(['prefix'=>'tintuc'],function(){
        //admin/theloai/list
        Route::get('list','TinTucController@getList');

        Route::get('add','TinTucController@getAdd');
        Route::post('add','TinTucController@postAdd');

        Route::get('edit/{id}','TinTucController@getEdit');
        Route::post('edit/{id}','TinTucController@postEdit');

        Route::get('delete/{id}','TinTucController@getDelete');
    });

    Route::group(['prefix'=>'comment'],function(){
        //admin/theloai/list
        Route::get('delete/{id}/{idTinTuc}','CommentController@getDelete');
    });

    Route::group(['prefix'=>'slide'],function(){
        //admin/theloai/list
        Route::get('list','SlideController@getList');

        Route::get('add','SlideController@getAdd');
        Route::post('add','SlideController@postAdd');

        Route::get('edit/{id}','SlideController@getEdit');
        Route::post('edit/{id}','SlideController@postEdit');

        Route::get('delete/{id}','SlideController@getDelete');
    });

    Route::group(['prefix'=>'user'],function(){
        //admin/theloai/list
        Route::get('list','UserController@getList');

        Route::get('add','UserController@getAdd');
        Route::post('add','UserController@postAdd');

        Route::get('edit/{id}','UserController@getEdit');
        Route::post('edit/{id}','UserController@postEdit');

        Route::get('delete/{id}','UserController@getDelete');
    });

    Route::group(['prefix'=>'ajax'], function(){
        Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
    });
});

Route::get('trangchu','PagesController@trangchu');
Route::get('lienhe','PagesController@lienhe');
Route::get('loaitin/{id}/{TenKhongDau}.html','PagesController@loaitin');
Route::get('tintuc/{id}/{TieuDeKhongDau}','PagesController@tintuc');
//Đăng nhập, đăng xuất
Route::get('dangnhap','PagesController@getDangNhap');
Route::post('dangnhap','PagesController@postDangNhap');

Route::get('dangxuat','PagesController@dangxuat');
Route::post('comment/{id}','CommentController@postComment');
Route::get('dangky','PagesController@getDangKy');
Route::post('dangky','PagesController@postDangKy');

Route::get('nguoidung','PagesController@getNguoiDung');
Route::post('nguoidung','PagesController@postNguoiDung');
//Tìm kiếm
Route::get('timkiem', 'PagesController@getTimKiem');


