@extends('admin.layouts.admin')
 
@section('title')
<title>Thêm danh mục sản phẩm </title>
 
@endsection
 
@section('css')
<link rel="stylesheet" href="{{ asset('/backend/css/notificate/message.css') }}">

@endsection
@section('content')


<div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'Category','key'=>'add'])
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <form action = "{{ route('category.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <div class=form-group>
                        <label >Tên Danh Mục</label>
                        <input type="text" 
                          class="form-control" 
                          name = "name"
                          placeholder="Nhập tên danh mục muốn thêm";>
                      </div>
                    </div>
                    @error('name')
                      <span class="error-message">*{{
                      $errors -> first('name')  }}</span>
                    @enderror
                    <div class="mb-3">
                      <div class="form-group">
                        <label >Danh mục cha - Bỏ trống để là danh mục cha</label>
                        <select class="form-control" name="parent_id" > 
                          <option value="0">Chọn danh mục cha</option>
                          {!! $addOption !!}
                        </select>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
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

