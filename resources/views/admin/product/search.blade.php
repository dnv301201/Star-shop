@extends('admin.layouts.admin')
 
@section('title')
  <title>Sản phẩm được tìm kiếm</title>
 
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('backend/css/product/index/list.css') }}">
@endsection

 
@section('content')

<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>'Product','key'=>'Search'])

    <div class="content-body">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <div class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('product.create') }}" class="btn btn-success">Thêm sản phẩm</a></li>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Mã sản phẩm</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($products as $productItem)
                          
                        <tr>
                          <th scope="row">{{ $productItem->id }}</th>
                          <td>{{ $productItem->name }}</td>
                          <td>{{ number_format($productItem->price) }}</td>
                          <td> 
                              <img class="product_image" src="{{ $productItem->feature_image_path }}" alt="">
                          </td>
                          <td>{{ $productItem->category->name }}</td>
                          <td>
                            <a href="{{ route('product.view',['id'=>$productItem->id]) }}" class = "btn btn-primary">Xem</a>
                            <a href="{{ route('product.edit',['id'=>$productItem->id]) }}" class = "btn btn-info">Sửa</a>
                            <a href="#"
                              data-url="{{ route('product.delete',['id'=>$productItem->id]) }}" 
                              class = "btn btn-danger action_delete">Xóa</a>
                          </td>
                        </tr>

                      @endforeach
                      
                    </tbody>
                </table>
            </div>
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                  <ul class="pagination">
                    @if ($products->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
                            <span class="page-link" aria-hidden="true">&laquo;Trang đầu</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->url(1) }}" rel="prev" aria-label="@lang('pagination.first')">&laquo;</a>
                        </li>
                    @endif
                
                    {{ $products->links() }}
                
                    @if ($products->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->url($products->lastPage()) }}" rel="next" aria-label="@lang('pagination.last')">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
                            <span class="page-link" aria-hidden="true">Trang cuối&raquo;</span>
                        </li>
                    @endif
                  </ul>

                </div>
                
                {{-- {{ $posts->links() }} --}}
              </div>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src={{ asset('backend/js/product/index/list.js') }}></script>
@endsection
