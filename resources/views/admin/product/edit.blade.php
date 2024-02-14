
@extends('admin.layouts.admin')
 
@section('title')
<title>Sửa sản phẩm</title>
 
@endsection

@section('css')
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/product/add/add.css') }}"  rel="stylesheet" />
    <link  href="{{ asset('backend/css/product/index/list.css') }}" rel="stylesheet"/>
@endsection


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header',['name'=>'Product','key'=>'edit'])
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action = "{{ route('product.update',['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-8">
                        <div class="form-group">
                            <label >Tên Sản phẩm</label>
                            <input type="text" 
                              class="form-control" 
                              name = "name"
                              placeholder="Nhập tên danh mục muốn thêm"
                              value="{{ $product-> name }}">
                        </div>
                        <div class="form-group">
                            <label >Giá sản phẩm</label>
                            <input type="text" 
                              class="form-control" 
                              name = "price"
                              placeholder="Nhập giá sản phẩm"
                              value="{{ $product-> price }}">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label >Chọn ảnh đại diện</label>
                            <input class="form-control-file" type="file" name="feature_image_path">
                            <div class="col-md-12">
                                <img class="product_image" src="{{ $product -> feature_image_path }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 ">
                        <div class="form-group">
                            <label >Chọn ảnh chi tiết</label>
                            <input class="form-control-file" type="file" multiple name="image_path[]" >
                            <div class="col-md-12">
                                <div class=row>
                                    @foreach($product->productImages as $productImageItem)
                                        <div class="col-md-3">
                                            <img class="product_image" src="{{ $productImageItem-> image_path }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label >Chọn danh mục</label>
                            <select class="form-control" name="category_id" > 
                                <option value="0">Chọn danh mục cha</option>
                                {!! $addOption !!}
                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label >Nhập tags cho sản phẩm</label>
                            <select name = "tags[]" class="form-control tags_select_choose" multiple ="multiple" >
                                @foreach($product->tags as $tagItem)
                                    <option value ="{{ $tagItem-> id }}"selected>{{ $tagItem->name}}</option>
                                @endforeach
                            </select> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Nhập nội dung sản phẩm</label>
                            <textarea name="content" class="form-control my-editor" rows="8">{{ $product->content }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                </form>
            </div>
       </div>

      </div>
    </div>

</div>

@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/7s9qu3p6fgmlnmqmlc2zfjkd8b56s3awj8qq4df93xx3w8cy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/js/product/add/add.js') }}"></script>
@endsection