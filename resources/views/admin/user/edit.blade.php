@extends('admin.layout.index')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User
                        <small>{{$user->name}}</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            {{$err}}."<br>
                        @endforeach
                    </div>
                @endif

                @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}
                    </div>
                @endif
                <div class="col-lg-7" style="padding-bottom:120px">
                    <form action="admin/user/edit/{{$user->id}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Họ Tên</label>
                            <input class="form-control" name="Name" placeholder="Nhập tên người dùng..." value="{{$user->name}}"/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="Email" placeholder="Nhập địa chỉ email..."
                                   type="email" value="{{$user->email}}" readonly=""/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="changePassword" name="changePassword">
                            <label>Đổi mật khẩu</label>
                            <input class="form-control password" name="Password" placeholder="Nhập password..." type="password" disabled="" />
                        </div>
                        <div class="form-group">
                            <label>Nhập lại mật khẩu</label>
                            <input class="form-control password" name="PasswordAgain" placeholder="Nhập password..." type="password" disabled=""  />
                        </div>
                        <div class="form-group">
                            <label>Quyền người dùng</label><br>
                            <label class="radio-inline">
                                <input name="Quyen" value="0"
                                       @if($user->quyen == 0)
                                               {{"checked"}}
                                        @endif
                                       type="radio" checked="">Thường
                            </label>
                            <label class="radio-inline">
                                <input name="Quyen" value="1"
                                       @if($user->quyen == 1)
                                       {{"checked"}}
                                       @endif
                                       type="radio">Admin
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Thêm</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                        </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop()
@section('script')
    <script>
        $(document).ready(function () {
            $("#changePassword").change(function () {
                if($(this).is(":checked")) {
                    $(".password").removeAttr('disabled');
                }else{
                    $(".password").attr('disabled','');
                }
            });
        });
    </script>
    @endsection