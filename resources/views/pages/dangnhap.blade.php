@extends('layout.index')
@section('title')
    Đăng nhập
@stop()
@section('content')
<!-- Page Content -->
<div class="container">

    <div class="row carousel-holder">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Đăng nhập</div>
                <div class="panel-body">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($error->all() as $err)
                                {{$err}}<br>
                                @endforeach
                        </div>
                    @endif
                    @if(session('thongbao'))
                        <div class="alert alert-danger">
                            {{session('thongbao')}}
                        </div>
                        @endif
                    <form action="dangnhap" method="post">
                        @csrf
                        <div>
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="email"
                            >
                        </div>
                        <br>
                        <div>
                            <label>Mật khẩu</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-default">Đăng nhập
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <!-- end slide -->
</div>

@stop()