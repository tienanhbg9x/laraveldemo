<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getList(){
        $theloai = TheLoai::all();
        return view('admin.theloai.list',['theloai'=>$theloai]);
    }

    public function getAdd(){
        return view('admin.theloai.add');
    }
    public function postAdd(Request $request){
        $this->validate($request,
            [
                'Ten' => 'required|unique:TheLoai, Ten|min:3|max:100'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên thể loại',
                'Ten.unique' => 'Tên thể loại đã tồn tại',
                'Ten.min' => 'Tên thể loại có độ dài tối thiểu 6 kí tự',
                'Ten.max' => 'Tên thể loại có độ dài tối đa 100 kí tự',
            ]);
        //lưu vào model thể loại
        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        //dùng request phải khởi tạo
        return redirect('admin/theloai/add')->with('thongbao','Thêm thành công');//sử dụng session thongbao
    }

    public function getEdit($id){
        $theloai = TheLoai::find($id);
        return view('admin.theloai.edit',['theloai'=>$theloai]);
    }
    public function postEdit(Request $request,$id){
        $theloai = TheLoai::find($id);
        $this->validate($request,  //validate lấy dữ liệu từ form
            [
                'Ten'=>'required|unique:TheLoai, Ten|min:3|max:100' //kiểm tra các điều kiện
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên thể loại',
                'Ten.unique' => 'Tên thể loại đã tồn tại',
                'Ten.min' => 'Tên thể loại có độ dài tối thiểu 6 kí tự',
                'Ten.max' => 'Tên thể loại có độ dài tối đa 100 kí tự',     //các thông báo
            ]);
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/edit/'.$id)->with('message','edit success');
    }
}
