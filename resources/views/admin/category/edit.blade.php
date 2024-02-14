@extends('admin.layouts.admin')
 
@section('title')
<title>Sửa danh mục sản phẩm</title>
 
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/backend/css/notificate/message.css') }}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header',['name'=>'Category','key'=>'edit'])
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <form action = "{{ route('category.update',['id' => $category->id]) }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <div class="form-group">
                        <label >Tên Danh Mục</label>
                        <input type="text" 
                        class="form-control" 
                        name = "name"
                        value = "{{ $category -> name }}"
                        placeholder="Nhập tên danh mục muốn thêm";>
                      </div>
                    </div>
                    <div class="mb-3">
                      <div class="form-group">
                        <label >Danh mục cha</label>
                        <select class="form-control" name="parent_id" > 
                          <option value="0">Chọn danh mục cha</option>
                          {!! $addOption !!}
            
                        </select>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                  </form>
            </div>
       </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

