<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class AjaxController extends Controller
{
    //
    public function getLoaiTin($idTheLoai){
        $loaitin = LoaiTin::where('idTheLoai',$idTheLoai)->get();  //get()--hiển thị hết các loại tin
        foreach ($loaitin as $lt){
            echo "<option value='".$lt->id."'>".$lt->Ten."</option>";
        }

    }
}
