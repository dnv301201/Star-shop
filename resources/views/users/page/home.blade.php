@extends('users.layout.user')

@section('title')
<title>Star Shop</title>
 
@endsection



@section('content')
    <br>
    <div class="title-pgae"> 
        <h3>Trang chủ</h3>
    </div>
    <div class="boddy-center">
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
        <div class="title-pgae"> 
            <h3>Sản phẩm mới</h3>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 product-new">
            @foreach($products as $productItem)
                <div class="col">
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
        
        <div class="banner-home">
            <div class="banner-left">
                <div class="row col-sm-12">
                    <a href="#"><img src="{{ asset('/frontend/img/banner/banner_web-05_jpg.webp') }}" alt=""></a>
                </div>
            </div>
            <div class="banner-right">
                <div class="row col-sm-12">
                    <a href="#"><img src="{{ asset('/frontend/img/banner/banner_web-06_jpg.webp') }}" alt=""></a>
                </div>
            </div>
        </div>

        <div class="title-pgae"> 
            <h3>Thời Trang Nam</h3>
        </div>
        <div class="category-products">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 product-new">
                @foreach($childProductsNam as $productNamItem)
                    <div class="col">
                        <div class="card ">
                            <a href="{{ route('product_detail',['id'=>$productNamItem->id])}}"><img class="product_image_home" src="{{ $productNamItem->feature_image_path }}" alt=""></a>
                            <div class="card-body">
                                <h6 class="name">{{ $productNamItem->name }}</h6>
                                <h6>{{ number_format($productNamItem->price, 0, '', ',') }}đ</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        
            @if($productNamItem->count() > 4)
                <div class="col" id="view-more">
                    <a href="{{ route('category.show', ['categorySlug' => 'Nam']) }}"><button class="btn btn-view-more">Xem thêm</button></a>
                    
                </div>
            @endif
        </div>
        
        <!-- Hiển thị sản phẩm cho danh mục 'nữ' -->
        <div class="title-pgae"> 
            <h3>Thời Trang Nữ</h3>
        </div>
        <div class="category-products">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 product-new">
                @foreach($childProductsNu as $productNuItem)
                    <div class="col">
                        <div class="card ">
                            <a href="{{ route('product_detail',['id'=>$productNuItem->id])}}"><img class="product_image_home" src="{{ $productNuItem->feature_image_path }}" alt=""></a>
                            <div class="card-body">
                                <h6 class="name">{{ $productNuItem->name }}</h6>
                                <h6>{{ number_format($productNuItem->price, 0, '', ',') }}đ</h6>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        
            @if($productNuItem->count() > 4)
                <div class="col" id="view-more">
                    <a href="{{ route('category.show', ['categorySlug' => 'Nữ']) }}"><button class="btn btn-view-more">Xem thêm</button></a>
                    
                </div>
            @endif
        </div>
        
    </div>
@endsection