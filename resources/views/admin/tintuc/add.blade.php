@extends('admin.layout.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tức
                    <small>Thêm</small>
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

                <form action="admin/tintuc/add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Thể loại</label>
                        <select class="form-control" name="TheLoai" id="TheLoai">
                            @foreach($theloai as $tl )
                            <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại tin</label>
                        <select class="form-control" name="LoaiTin" id="LoaiTin">
                            @foreach($loaitin as $lt )
                                <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề..." />
                    </div>
                    <div class="form-group">
                        <label for="">Tóm tắt</label>
                        <textarea name="TomTat" id="demo" cols="30" rows="3" class="ckeditor"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Nội dung</label>
                        <textarea name="NoiDung" id="demo" cols="30" rows="4" class="ckeditor"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <input type="file" name="Hinh" >
                    </div>
                    <div class="form-group">
                        <label for="">Nổi bật</label>
                        <label class="radio-inline">
                            <input type="radio" name="NoiBat" value="1">Có
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="NoiBat" value="0">Không
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Thêm tin</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                    </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#TheLoai").change(function () {
                var idTheLoai = $(this).val(); //lấy id thể loại = chính nó
                $.get("admin/ajax/loaitin/"+idTheLoai,function (data) {
                    $("#LoaiTin").html(data);
                });//dữ liệu truyền vào data
            });
        });
    </script>
    {{--//đổ dữ liệu từ thể loại vào loại tin--}}
@endsection