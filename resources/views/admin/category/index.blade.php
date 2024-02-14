@extends('admin.layouts.admin')
 
@section('title')
<title>Danh mục</title>
 
@endsection
 
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header',['name'=>'Danh mục','key'=>'Danh sách'])
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content-body">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <div class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('category.create') }}" class="btn btn-success">Thêm danh mục</a></li>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid-show">
        <div class="row">
          <div class="col-md-6">
            <h4>Danh sách các danh mục - Nhấn để xem</h4>
            <select class="form-control" name="parent_id" > 
              <option value="">-------------------------------------Danh sách các danh mục sản phẩm-------------------------------------</option>
              {!! $addOption !!}
            </select>
            <br>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">   
            <div class="col-md-12">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên danh mục</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($categories as $category)
                          
                        <tr>
                          <th scope="row">{{ $category->id }}</th>
                          <td>{{ $category->name }}</td>
                          <td>
                            <a href="{{ route('category.edit',['id'=>$category->id]) }}" class = "btn btn-info">Sửa</a>
                            <a href="#" 
                              data-url="{{ route('category.delete',['id'=>$category->id]) }}"
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
                    @if ($categories->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
                            <span class="page-link" aria-hidden="true">&laquo;Trang đầu</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $categories->url(1) }}" rel="prev" aria-label="@lang('pagination.first')">&laquo;</a>
                        </li>
                    @endif
                
                    {{ $categories->links() }}
                
                    @if ($categories->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $categories->url($categories->lastPage()) }}" rel="next" aria-label="@lang('pagination.last')">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
                            <span class="page-link" aria-hidden="true">Trang cuối&raquo;</span>
                        </li>
                    @endif
                </ul>
                </div>
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
  <script src={{ asset('backend/js/category/list.js') }}></script>
@endsection

