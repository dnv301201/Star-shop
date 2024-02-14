@extends('admin.layouts.admin')

@section('title')
    <title>Xem thông tin sản phẩm</title>
@endsection

@section('css')
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/product/add/add.css') }}"  rel="stylesheet" />
    <link  href="{{ asset('backend/css/product/index/list.css') }}" rel="stylesheet"/>
    <link  href="{{ asset('backend/css/product/view.css') }}" rel="stylesheet"/>

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    @include('admin.partials.content-header', ['name' => 'Product', 'key' => 'view'])



    <div class="content-body">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
              <div class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('product.addProductVersion',['id'=>$product->id]) }}" class="btn btn-success">Thêm phiên bản</a></li>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <p><strong>Mã sản phẩm:</strong> {{ $product->id }}</p>
                        <p><strong>Tên Sản phẩm:</strong> {{ $product->name }}</p>
                        <p><strong>Giá sản phẩm:</strong>{{ number_format($product->price, 0, '', ',') }}đ</p>
                        
                    </div>
                    <div class="col-md-8">
                        <p><strong>Ảnh đại diện:</strong></p>
                        <div class="col-md-12">
                            <img class="product_image" src="{{ $product->feature_image_path }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-8 ">
                        <p><strong> Ảnh chi tiết:</strong></p>
                        <div class="col-md-12">
                            <div class=row>
                                @foreach($product->productImages as $productImageItem)
                                    <div class="col-md-3">
                                        <img class="product_image" src="{{ $productImageItem->image_path }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p><strong> Danh mục thuộc về: </strong>{{ $product->category->name }}</p>
                    </div>
                    <div class="col-md-8">
                        <p><strong>Tags:</strong></p>
                        @foreach($product->tags as $tagItem)
                            <p>{{ $tagItem->name }}</p>
                        @endforeach
                    </div>
                    <div class="col-md-12">
                        <p><strong>Nội dung sản phẩm:</strong></p>
                        {!! $product->content !!}
                    </div>
                </div>
            </div>
            <br>

        </div>
        <div class="content-body-low">
            <div class="row">
                <div class="col-md-12">
                    <h5>Các phiên bản sản phẩm của {{ $product->name }}</h5>
                    <div class="table-responsive">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th scope="col">Màu sắc</th>
                                    <th scope="col" colspan="2">Kích cỡ và Số lượng</th>
                                    <th scope="col" colspan="2">Kích cỡ và Số lượng</th>
                                    <th scope="col" colspan="2">Kích cỡ và Số lượng</th>
                                    <th scope="col" colspan="2">Kích cỡ và Số lượng</th>
                                    <th scope="col" colspan="2">Kích cỡ và Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productVersions as $version)
                                    <tr>
                                        <td>{{ $version->color }}</td>
                                        @foreach ($version->quantities as $quantity)
                                            <td>{{ $quantity->size }}</td>
                                            <td>{{ $quantity->quantity }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination justify-content-center">
                        {{ $productVersions->links() }}
                    </div>
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