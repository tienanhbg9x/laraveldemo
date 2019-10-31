<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\TheLoai;
use Illuminate\Support\Facades\View;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    //
    public function __construct()
    {
        $slide = Slide::all();
        $theloai = TheLoai::all();
        view::share(['theloai'=>$theloai,'slide'=>$slide]);  //tất cả các view đều có biến thể loại

        if (Auth::check())
            View::share('nguoidung',Auth::user());
    }

    public function trangchu()
    {
        return view('pages.trangchu');
    }

    public function lienhe()
    {

        return view('pages.lienhe');
    }

    public function loaitin($id)
    {
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
}
    public function tintuc($id)
    {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc' => $tintuc,'tinnoibat' => $tinnoibat,'tinlienquan' => $tinlienquan]);
    }

    public function getDangNhap()
    {
        return view('pages.dangnhap');
    }

    public function postDangNhap(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required|min:6|max:32'
        ],[
            'email.required'=>'Bạn chưa nhập email',
            'password.required'=>'Bạn chưa nhập password',
            'password.min'=>'Password không nhỏ hơn 6 kí tự',
            'password.max'=>'Password không quá 32 kí tự',
        ]);
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('trangchu');
        }else{
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }

    public function dangxuat()
    {
        Auth::logout(); //dùng logout để bảo mật
        return redirect('trangchu');
    }

    public function getNguoiDung()
    {
        $user = Auth::user();
        return view('pages.nguoidung',['nguoidung'=>$user]);
    }

    public function postNguoiDung(Request $request)
    {
        $this->validate($request,  //validate lấy dữ liệu từ form
            [
                'name' => 'required|min:6|max:32',
            ],
            [
                'name.required' => 'Bạn chưa nhập tên',
                'name.min' => 'Tên người dùng ít nhất 6 kí tự',
                'name.max' => 'Tên người dùng nhiều nhất 32 kí tự',
            ]);
        $user = Auth::user();
        $user->name = $request->name;
        if ($request->chagePassword == "on") {
            $this->validate($request,
                [
                    'password' => 'required|min:6|max:32',
                    'passwordAgain' => 'required|same:Password'
                ],[
                    'password.required' => 'Bạn chưa nhập password',
                    'password.min' => 'Mật khẩu tối thiểu  6 kí tự',
                    'password.max' => 'Mật khẩu tối đa 32 kí tự',
                    'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                    'passwordAgain.same' => 'Bạn nhập lại mật khẩu chưa khớp'
                ]);
            if(Auth::user()->password == bcypt($request->password))
                return redirect('nguoidung')->with('thongbao','Mật khẩu mới trùng với mật khẩu cũ');
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('nguoidung')->with('thongbao', 'Thay đổi mật khẩu thành công');
    }
    public function getDangKy()
    {
        return \view('pages.dangky');
    }
    public function postDangKy(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|min:6|max:32',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:32',
                'passwordAgain' => 'required|same:password'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên',
                'name.min' => 'Tên người dùng ít nhất 6 kí tự',
                'name.max' => 'Tên người dùng nhiều nhất 32 kí tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Chưa nhập đúng định dạng email',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Bạn chưa nhập password',
                'password.min' => 'Mật khẩu tối thiểu  6 kí tự',
                'password.max' => 'Mật khẩu tối đa 32 kí tự',
                'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same' => 'Bạn nhập lại mật khẩu chưa khớp'
            ]);
        //lưu vào model thể loại
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;

        $user->save();
        //dùng request phải khởi tạo
        return redirect('dangky')->with('thongbao', 'Đăng ký thành công');
    }
    function getTimKiem(Request $request)
    {
        //$tukhoa = $request->tukhoa;
        $tukhoa=$request->get('tukhoa');
        $tintuc = TinTuc::where('TieuDe','like','%'.$tukhoa.'%')->orWhere('TomTat','like','%'.$tukhoa.'%')
            ->orWhere('NoiDung','like','%'.$tukhoa.'%')->paginate(5);
        return view('pages.timkiem',['tukhoa'=>$tukhoa,'tintuc'=>$tintuc]);
    }
}
