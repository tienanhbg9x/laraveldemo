<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;

class LoaiTinController extends Controller
{
    //
    public function getList(){
        $loaitin = LoaiTin::all();
        return view('admin.loaitin.list',['loaitin'=>$loaitin]);
    }

    public function getAdd(){
        $theloai = TheLoai::all();
        return view('admin.loaitin.add',['theloai'=>$theloai]);
    }
    public function postAdd(Request $request)
    {
        $this->validate($request,
            [
                'Ten' => 'required|unique:LoaiTin,Ten|min:6|max:100',
                'TheLoai'=> 'required'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên thể loại',
                'Ten.unique' => 'Tên thể loại đã tồn tại',
                'Ten.min' => 'Tên thể loại có độ dài tối thiểu 6 kí tự',
                'Ten.max' => 'Tên thể loại có độ dài tối đa 100 kí tự',
                'TheLoai.required' => 'Bạn chưa chọn thể loại'
            ]);
        //lưu vào model thể loại
        $loaitin = new LoaiTin;
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        //dùng request phải khởi tạo
        return redirect('admin/loaitin/add')->with('thongbao','Thêm thành công');//sử dụng session thongbao
    }

    public function getEdit($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
        return view('admin.loaitin.edit',['loaitin' => $loaitin, 'theloai' => $theloai]);
    }

    public function postEdit(Request $request,$id){
        $loaitin = LoaiTin::find($id);
        $this->validate($request,  //validate lấy dữ liệu từ form
            [
                'Ten'=>'required|unique:LoaiTin,Ten|min:6|max:100' //kiểm tra các điều kiện
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên thể loại',
                'Ten.unique' => 'Tên thể loại đã tồn tại',
                'Ten.min' => 'Tên thể loại có độ dài tối thiểu 6 kí tự',
                'Ten.max' => 'Tên thể loại có độ dài tối đa 100 kí tự',     //các thông báo
            ]);
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/edit/'.$id)->with('message','edit success');
    }
    public function getDelete($id){
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();

        return redirect('admin/loaitin/list')->with('message','Xóa Thành Công');
    }
}

