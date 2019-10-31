<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Slide;


class SlideController extends Controller
{
    //
    public function getList(){
        $slide = Slide::all();
        return view('admin.slide.list',['slide'=>$slide]);
    }
    public function getAdd(){
        return view('admin.slide.add');
    }
    public function postAdd(Request $request)
    {
        $this->validate($request,
            [
                'Ten'=> 'required',
                'NoiDung' => 'required',
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
            ]);
        //lưu vào model thể loại
        $slide = new Slide();
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;

        if ($request->has('link'))
            $slide->link = $request->link;

        if($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();//kiểm tra đuôi
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/add')->with('thongbao','file bạn chọn không phải ảnh');
            }

            $name = $file->getClientOriginalName();//lấy tên hình
            $Hinh = $name;

            while (file_exists("upload/slide/".$Hinh)){
                $Hinh = $name;
            }
            $file->move("upload/slide",$Hinh);
            $slide->Hinh = $Hinh;

        }else{
            $slide->Hinh = "";
        }
        $slide->save();
        //dùng request phải khởi tạo
        return redirect('admin/slide/add')->with('thongbao','Thêm thành công');//sử dụng session thongbao
    }

    public function getEdit($id){
        $slide = Slide::find($id);
        return view('admin.slide.edit',['slide'=>$slide]);
    }

    public function postEdit(Request $request,$id){
        $slide = Slide::find($id);
        $this->validate($request,  //validate lấy dữ liệu từ form
            [
                'Ten'=> 'required',
                'NoiDung' => 'required',
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
            ]);
        $slide = new Slide();
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;

        if ($request->has('link'))
            $slide->link = $request->link;

        if($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();//kiểm tra đuôi
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/add')->with('thongbao','file bạn chọn không phải ảnh');
            }

            $name = $file->getClientOriginalName();//lấy tên hình
            $Hinh = $name;

            while (file_exists("upload/slide/".$Hinh)){
                $Hinh = $name;
            }
            $file->move("upload/slide",$Hinh);
            $slide->Hinh = $Hinh;

        }else{
            $slide->Hinh = "";
        }
        $slide->save();

        return redirect('admin/slide/edit/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getDelete($id){
        $slide = Slide::find($id);
        $slide->delete();

        return redirect('admin/slide/list')->with('thongbao','Xóa Thành Công');
    }
}

