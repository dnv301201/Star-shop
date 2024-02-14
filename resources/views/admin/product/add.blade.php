@extends('admin.layouts.admin')
 
@section('title')
<title>Thêm sản phẩm</title>
 
@endsection
 
@section('css')
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/product/add/add.css') }}"  rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/backend/css/notificate/message.css') }}">
@endsection


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header',['name'=>'Product','key'=>'add'])
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action = "{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-8">
                            <div class="form-group">
                                <label >Tên Sản phẩm</label>
                                <input type="text" 
                                class="form-control" 
                                name = "name"
                                placeholder="Nhập tên danh mục muốn thêm">
                            </div>
                            @error('name')
                                <span class="error-message">*{{
                                $errors -> first('name')  }}</span>
                            @enderror
                            <div class="form-group">
                                <label >Giá sản phẩm</label>
                                <input type="text" 
                                class="form-control" 
                                name = "price"
                                placeholder="Nhập giá sản phẩm">
                            </div>
                            @error('price')
                                <span class="error-message">*{{
                                $errors -> first('price')  }}</span>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label >Chọn ảnh đại diện</label>
                                <input class="form-control-file" type="file" name="feature_image_path">
                            </div>
                            @error('feature_image_path')
                                <span class="error-message">*{{
                                $errors -> first('feature_image_path')  }}</span>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label >Chọn ảnh chi tiết</label>
                                <input class="form-control-file" type="file" multiple name="image_path[]" >
                            </div>
                            @error('image_path')
                                <span class="error-message">*{{
                                $errors -> first('image_path')  }}</span>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label >Chọn danh mục</label>
                                <select class="form-control" name="category_id" > 
                                    <option value="0">Chọn danh mục cha</option>
                                    {!! $addOption !!}
                                </select>
                            </div>
                            @error('category_id')
                                <span class="error-message">*{{
                                $errors -> first('category_id')  }}</span>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label >Nhập tags cho sản phẩm</label>
                                <select name = "tags[]" class="form-control tags_select_choose" multiple ="multiple" ></select>
                            </div>
                            @error('tags')
                                <span class="error-message">*{{
                                $errors -> first('tags')  }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Nhập nội dung sản phẩm</label>
                                <textarea name="content" class="form-control my-editor" rows="8"></textarea>
                            </div>
                            @error('content')
                                <span class="error-message">*{{
                                $errors -> first('content')  }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/7s9qu3p6fgmlnmqmlc2zfjkd8b56s3awj8qq4df93xx3w8cy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('backend/js/product/add/add.js') }}"></script>
@endsection