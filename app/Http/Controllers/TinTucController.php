<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;


class TinTucController extends Controller
{
    //
    public function getList(){
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.list',['tintuc'=>$tintuc]);
    }

    public function getAdd(){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.add',['theloai'=>$theloai, 'loaitin' => $loaitin]);
    }
    public function postAdd(Request $request)
    {
        $this->validate($request,
            [
                'TieuDe'=> 'required|min:6|unique:TinTuc,TieuDe',
                'LoaiTin' => 'required',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa chọn loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.min' => 'Tên thể loại có độ dài tối thiểu 6 kí tự',
                'TieuDe.unique' => 'Tiêu đề đã tồn tại',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required' => 'Bạn chưa nhập nội dung'
            ]);
        //lưu vào model thể loại
        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;
        if($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();//kiểm tra đuôi
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/add')->with('thongbao','file bạn chọn không phải ảnh');
            }

            $name = $file->getClientOriginalName();//lấy tên hình
            $Hinh = $name;

            while (file_exists("upload/tintuc/".$Hinh)){
                $Hinh = $name;
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;

        }else{
            $tintuc->Hinh = "";
        }
        $tintuc->save();
        //dùng request phải khởi tạo
        return redirect('admin/tintuc/add')->with('thongbao','Thêm thành công');//sử dụng session thongbao
    }

    public function getEdit($id){
        $comment = Comment::all();
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.edit',['tintuc' => $tintuc, 'theloai' => $theloai, 'loaitin' => $loaitin,'comment'=>$comment]);
    }

    public function postEdit(Request $request,$id){
        $tintuc = TinTuc::find($id);
        $this->validate($request,  //validate lấy dữ liệu từ form
            [
                'TieuDe'=> 'required|min:6|unique:TinTuc,TieuDe',
                'LoaiTin' => 'required',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa chọn loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.min' => 'Tên thể loại có độ dài tối thiểu 6 kí tự',
                'TieuDe.unique' => 'Tiêu đề đã tồn tại',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required' => 'Bạn chưa nhập nội dung'
            ]);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;
        if($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();//kiểm tra đuôi
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/add')->with('thongbao','file bạn chọn không phải ảnh');
            }

            $name = $file->getClientOriginalName();//lấy tên hình
            $Hinh = $name;

            while (file_exists("upload/tintuc/".$Hinh)){
                $Hinh = $name;
            }
            $file->move("upload/tintuc",$Hinh);
            unlink('upload/tintuc/'.$tintuc->Hinh);//xóa hình cũ
            $tintuc->Hinh = $Hinh;

        }
        $tintuc->save();

        return redirect('admin/tintuc/edit/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getDelete($id){
        $tintuc = TinTuc::find($id);
        $tintuc->delete();

        return redirect('admin/tintuc/list')->with('thongbao','Xóa Thành Công');
    }
}

