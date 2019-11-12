<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth; //phải có thư viện này để sử dụng auth để đăng nhập

class UserController extends Controller
{
    public function getList()
    {
        $user = User::all();
        return view('admin.user.list', ['user' => $user]);
    }

    public function getAdd()
    {
        return view('admin.user.add');
    }

    public function postAdd(Request $request)
    {
        $this->validate($request,
            [
                'Name' => 'required|min:6|max:32',
                'Email' => 'required|email|unique:users,email',
                'Password' => 'required|min:6|max:32',
                'PasswordAgain' => 'required|same:Password'
            ],
            [
                'Name.required' => 'Bạn chưa nhập tên',
                'Name.min' => 'Tên người dùng ít nhất 6 kí tự',
                'Name.max' => 'Tên người dùng nhiều nhất 32 kí tự',
                'Email.required' => 'Bạn chưa nhập email',
                'Email.email' => 'Chưa nhập đúng định dạng email',
                'Email.unique' => 'Email đã tồn tại',
                'Password.required' => 'Bạn chưa nhập password',
                'Password.min' => 'Mật khẩu tối thiểu  6 kí tự',
                'Password.max' => 'Mật khẩu tối đa 32 kí tự',
                'PasswordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'PasswordAgain.same' => 'Bạn nhập lại mật khẩu chưa khớp'
            ]);
        //lưu vào model thể loại
        $user = new User;
        $user->name = $request->Name;
        $user->email = $request->Email;
        $user->password = bcrypt($request->Password);
        $user->quyen = $request->Quyen;

        $user->save();
        //dùng request phải khởi tạo
        return redirect('admin/user/add')->with('thongbao', 'Thêm thành công');//sử dụng session thongbao
    }

    public function getEdit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', ['user' => $user]);
    }

    public function postEdit(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request,  //validate lấy dữ liệu từ form
            [
                'Name' => 'required|min:6|max:32',
            ],
            [
                'Name.required' => 'Bạn chưa nhập tên',
                'Name.min' => 'Tên người dùng ít nhất 6 kí tự',
                'Name.max' => 'Tên người dùng nhiều nhất 32 kí tự',
            ]);
        $user->name = $request->Name;
        $user->email = $request->Email;
        $user->quyen = $request->Quyen;

        if ($request->chagePassword == "on") {
            $this->validate($request,
            [
                'Password' => 'required|min:6|max:32',
                'PasswordAgain' => 'required|same:Password'
            ],[
                'Password.required' => 'Bạn chưa nhập password',
                'Password.min' => 'Mật khẩu tối thiểu  6 kí tự',
                'Password.max' => 'Mật khẩu tối đa 32 kí tự',
                'PasswordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'PasswordAgain.same' => 'Bạn nhập lại mật khẩu chưa khớp'
            ]);
            $user->password = bcrypt($request->Password);
        }
        $user->save();

        return redirect('admin/user/edit/' . $id)->with('thongbao', 'Sửa thành công');
    }

    public function getDelete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('admin/user/list')->with('thongbao', 'Xóa Thành Công');
    }

    public function getLoginAdmin(){
        return view('admin.login');
    }

    public function postLoginAdmin(Request $request){
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
            return redirect('admin/theloai/list');
        }else{
            return redirect('admin/login')->with('thongbao','Đăng nhập không thành công');
        }
    }
    public function getLogoutAdmin(){
        Auth::logout();
        return redirect('admin/login');
    }
}
