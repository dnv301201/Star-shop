@extends('admin.layouts.admin')
 
@section('title')
<title>Thêm sản phẩm</title>
 
@endsection
 
@section('css')
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/product/add/add.css') }}"  rel="stylesheet" />
@endsection


@section('content')

<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>'Product','key'=>'add'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('product.storeProductVersion', ['id' => $product->id]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="color">Màu sắc:</label>
                            <input type="text" name="color" id="color" required>
                        </div>
                        <div class="form-group" id="sizes">
                            <label for="sizes">Size và số lượng:</label>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" name="sizes[]" placeholder="Size" required>
                                </div>
                                <div class="col">
                                    <input type="number" name="quantities[]" placeholder="Số lượng" required>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-success" onclick="addSize()">Thêm Size</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm phiên bản</button>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('js')
<script>
    let maxSize = 5; // Số lượng size tối đa cho môi phiên bản sản phẩm

    function addSize() {
        let sizesDiv = document.getElementById('sizes');
        let currentSizeCount = sizesDiv.getElementsByClassName('row mb-2').length;

        if (currentSizeCount < maxSize) {
            let newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-2');
            newRow.innerHTML = `
                <div class="col">
                    <input type="text" name="sizes[]" placeholder="Size" required>
                </div>
                <div class="col">
                    <input type="number" name="quantities[]" placeholder="Số lượng" required>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger" onclick="removeSize(this)">Xoá</button>
                </div>
            `;
            sizesDiv.appendChild(newRow);
        } else {
            alert('Bạn đã đạt tối đa số lượng size cho phiên bản này.');
        }
    }

    function removeSize(button) {
        let row = button.parentElement.parentElement;
        row.remove();
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/7s9qu3p6fgmlnmqmlc2zfjkd8b56s3awj8qq4df93xx3w8cy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('backend/js/product/add/add.js') }}"></script>

@endsection