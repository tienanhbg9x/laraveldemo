@extends('admin.layout.index')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Slide
                        <small>{{$slide->Ten}}</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    {{--kiểm tra lỗi--}}
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

                    <form action="admin/slide/edit/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Tên</label>
                            <input class="form-control" name="Ten" placeholder="Nhập tên slide..." value="{{$slide->Ten}}"/>
                        </div>
                        <div class="form-group">
                            <label for="">Nội dung</label>
                            <textarea name="NoiDung" id="demo" cols="30" rows="3" class="ckeditor">
                                {{$slide->NoiDung}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input class="form-control" name="link" placeholder="Nhập tên link..." value=" {{$slide->link}}"/>
                        </div>
                        <div class="form-group">
                            <label for="">Hình ảnh</label>
                            <p>
                                <img src="upload/slide/{{$slide->Hinh}}" alt="">
                            </p>
                            <input type="file" name="Hinh" class="form-group">
                        </div>
                        <button type="submit" class="btn btn-default">Sửa</button>
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