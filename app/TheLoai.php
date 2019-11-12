<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    //
    protected $table = "theloai";

    public function loaitin(){
        return $this->hasMany('App\LoaiTin','idTheLoai','id');//1 loaiTin có nhiều thể loại
    }
    public function tintuc(){
        return $this->hasManyThrough('App\TinTuc','App\LoaiTin','idTheLoai','idLoaiTin','id');
    }// tin tức lk qua loại tin,loại tin lk qua thể loại

}
