@extends('users.layout.user')

@section('title')
<title>Star Shop</title>
 
@endsection


@section('css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <link rel="stylesheet" href="{{ asset ('frontend/css/product-detail.css') }}">
@endsection 


@section('content')
  <br>
  <div class="title-pgae"> Chi tiết sản phẩm</div>
  <div class="card card-solid">
  <div class="card-body">
    <div class="row">
      <div class="col-12 col-sm-6">
          <div class="row">
              <div class="col-md-2 img_tyni">
                  <div class="row">
                      <div>
                          <img class="d-block w-100 img-thumbnail" src="{{ $pro->feature_image_path }}" alt="Thumbnail Image">
                      </div>
                      @foreach($img_pro as $key => $proItem)
                          <div >
                              <img class="d-block w-100 img-thumbnail" src="{{ $proItem->image_path }}" alt="Thumbnail Image">
                          </div>
                      @endforeach
                  </div>
              </div>
              <div class="col-md-8">
                  
                  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                      
                      <ol class="carousel-indicators">
                          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                          @foreach($img_pro as $key => $proItem)
                              <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key + 1 }}"></li>
                          @endforeach
                      </ol>
                      
                      <div class="carousel-inner">
                          <div class="carousel-item active">
                              <img class="d-block w-100" src="{{ $pro->feature_image_path }}" alt="Ảnh đại diện">
                          </div>
                          @foreach($img_pro as $proItem)
                              <div class="carousel-item">
                                  <img class="d-block w-100" src="{{ $proItem->image_path }}" alt="Ảnh thành phần">
                              </div>
                          @endforeach
                      </div>
                      
                      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="" id="carousel-control"></span>
                          <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true" id="carousel-control"></span>
                          <span class="sr-only">Next</span>
                      </a>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-12 col-sm-6">
        <h3 class="my-3"></h3>
        <h4><p>{{ $pro ->name }}</p></h4>
          
        <div class=" py-2 px-3 mt-4">
          <h5 class="mb-0">
              <strong>{{ number_format($pro->price, 0, '', ',') }}đ</strong>
          </h5>
        </div>
        <br>
        <div class="product-details">
          <form id="addToCartForm" method="post" action="{{ route('cart.add') }}">
              @csrf
              <!-- Hidden input để chứa thông tin sản phẩm -->
              <input type="hidden" name="product_id" value="{{ $pro->id }}">
              <input type="hidden" name="product_name" value="{{ $pro->name }}">
              <input type="hidden" name="product_price" value="{{ $pro->price }}">
              <input type="hidden" name="product_image" value="{{ $pro->feature_image_path }}">
              <input type="hidden" name="product_price" value="{{ $pro->price }}">
              <!-- Các trường khác cần thiết bạn cần thêm vào đây -->
              


              <!-- Chọn màu -->
              <h5>Chọn màu:</h5>
              <div class="mb-3">
                  @foreach ($productVersions as $productItem)
                      <button class="btn color-btn" data-color="{{ $productItem->color }}">{{ $productItem->color }}</button>
                  @endforeach
              </div>
              <input type="hidden" id="selected_color" name="color" value="">
              <!-- Hiển thị danh sách size theo màu đã chọn -->
              <h5>Danh sách size:</h5>
              <div class="mb-3">
                  <select id="sizeSelect" name="selected_size" class="form-select">
                    {{-- xử lý ở file product-detail.js --}}
                  </select>
              </div>
              <input type="hidden" id="selected_size" name="size" value="">
              <!-- Tăng giảm số lượng -->
              <h5>Số lượng:</h5>
              <div class="col-12 col-sm-4">
                  <div class="input-group ">
                      <button class="btn btn-outline-secondary" type="button" id="minusBtn">-</button>
                      <input type="number" id="quantityInput" name="quantity" class="form-control text-center" min="1" value="1" readonly >
                      <button class="btn btn-outline-secondary" type="button" id="plusBtn">+</button>
                  </div>
              </div>
              <!-- Nút thêm vào giỏ hàng -->
              <button type="submit" class="btn add-to-cart">Thêm vào giỏ hàng</button> 
              <button type=""class="btn add-to-cart">Thêm vào yêu thích</button>
          </form>

            <ul class="shipping-list">
                <li>
                    <h6>Giao hàng nhanh</h6>
                    <h6>Từ 2 - 5 ngày</h6>
                    <i class="fas fa-truck"></i>
                </li>
        
                <li>
                    <h6>Freeship toàn quốc từ 399k</h6>
                    <h6>Miễn phí vận chuyển</h6>
                    <h6>Đơn hàng từ 399K</h6>
                    <i class="fas fa-shipping-fast"></i>
                </li>
        
                <!-- Các mục khác với icon tương ứng -->
                <li>
                    <h6>Theo dõi đơn hàng dễ dàng</h6>
                    <h6>Theo dõi đơn hàng một cách dễ dàng</h6>
                    <i class="fas fa-search"></i>
                </li>
        
                <li>
                    <h6>Đổi trả tận nơi</h6>
                    <h6>Đổi trả linh hoạt</h6>
                    <h6>Với sản phẩm không áp dụng khuyến mãi</h6>
                    <i class="fas fa-exchange-alt"></i>
                </li>
        
                <li>
                    <h6>Thanh toán dễ dàng</h6>
                    <h6>Thanh toán dễ dàng nhiều hình thức</h6>
                    <i class="fas fa-credit-card"></i>
                </li>
        
                <li>
                    <h6>Hotline hỗ trợ</h6>
                    <h6>Hotline hỗ trợ: 077 817 3107</h6>
                    <i class="fas fa-phone"></i> 
                </li>
            </ul>
        </div>
        <div class="product-content-wrapper">
            <div class="product-content">
                {!! $pro->content !!}
            </div>
        </div>

      </div>
    </div>
  </div>
  <!-- /.card-body -->
  </div>
@endsection


@section('js')
        <!-- jQuery -->
        <script src="{{ asset('/adminlte/plugins/jquery/jquery.min.js') }}"></script>

        <!-- Bootstrap 4 -->

        <script src="{{ asset('/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->

        <script src="{{ asset('/adminlte/dist/js/adminlte.min.js') }}"></script>
        <!-- Bao gồm jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- JavaScript của Slick Carousel -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <!-- Js xử lý thêm -->
        <script>
          const productVersions = @json($productVersions);
        </script>
        <script src="{{ asset('frontend/js/product-detail.js') }}"> </script>

@endsection
</body>
</html>

