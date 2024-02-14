@extends('users.layout.user')

@section('title')
<title>Star Shop</title>
 
@endsection

@section('content')
    <div class="title-pgae"> Trang chủ</div>
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
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 product-new">
            @foreach($products as $productItem)
                <div class="col">
                    <div class="card ">
                        <a href="{{ route('product_detail',['id'=>$productItem->id])}}"><img class="product_image_home" src="{{ $productItem->feature_image_path }}" alt=""></a>
                        <div class="card-body">
                            <h6 class="name">{{ $productItem->name }}</h6>
                            <h6>{{ number_format($productItem->price, 0, '', ',') }}đ</h6>
                            <p class="card-text">Some thing</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> 
    </div>
@endsection