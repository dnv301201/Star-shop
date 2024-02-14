@extends('users.layout.user')

@section('title')
<title>Star Shop</title>
 
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/pro-of-cate.css') }}">
@endsection

@section('content')
    <br>
    <div class="title-pgae">Thời Trang {{ $category->name }}</div>
    <br>
    <div class="banner-main">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
            {{-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class="active" aria-current="true" aria-label="Slide 3"></button> --}}
            </div>
            <div class="carousel-inner">
            <div class="carousel-item active">
                
                <img src="{{ asset('frontend/img/slide/thoi-trang-nam-thuong-hieu-routine-dep-cao-cap-chinh-hang (1).jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                
                <img src="{{ asset('frontend/img/slide/thoi-trang-nu-thuong-hieu-routine-dep-cao-cap-chinh-hang.jpg') }}" class="d-block w-100" alt="...">
            </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="title-pgae">Khám Phá Đồ {{ $category->name }}</div>
    <div class="row">
        {{-- <div class="col-md-3">
            <div class="body-category">
                <div class="title-pgae"> <h5>Khám Phá Đồ {{ $category->name }}</h5></div>
            </div> 
        </div>  --}}

        <div class="col-md-12" >
            <div class="boddy-center">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 product-new">
                    @foreach($products as $productItem)
                        <div class="col product-item" data-category-id="{{ $productItem->category_id }}">
                            <div class="card ">
                                <a href="{{ route('product_detail',['id'=>$productItem->id])}}"><img class="product_image_home" src="{{ $productItem->feature_image_path }}" alt=""></a>
                                <div class="card-body">
                                    <h6 class="name">{{ $productItem->name }}</h6>
                                    <h6>{{ number_format($productItem->price, 0, '', ',') }}đ</h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <br> 
                <div class="paginate">
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
            </div>
        </div>

    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection