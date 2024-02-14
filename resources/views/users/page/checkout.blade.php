
@extends('users.layout.user')

@section('title')
<title>Check out</title>
 
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset ('frontend/css/cart.css') }}">
@endsection 


@section('content')
  <br>
  <div class="title-pgae"> Tiến hành đặt hàng</div>
  <br>
  <div class="cart-product">
        <form action="{{ route('process.checkout') }}" method="post">
            @csrf 
            <div class="row">
                <div class=" col-md-7 col-sm-12">
                        <div class="form-group">
                            <label for="fullname">Họ và tên:</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="address">Địa chỉ giao hàng:</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="notes">Ghi chú:</label>
                            <textarea class="form-control" id="notes" name="notes"></textarea>
                        </div>
                        <br>
                </div>
                <div class=" col-md-5 col-sm-12" id="total-detail">
                    <div class="total-detail">
                        <div class="product">

                            <h1>Thông tin đặt hàng</h1>
                            <div id="selectedProductsInfo">
                                @foreach($cartProducts as $cartProduct)
                                <div class="selected-product-info">
                                    <img class="selected-product-image product_image" src="{{ $cartProduct->feature_image_path }}" alt="">
                                    <div class="product-details">
                                        <p class="selected-product-name">
                                            {{ $cartProduct->name }} x {{ $cartProduct->pivot->quantity }} x
                                            {{ $cartProduct->pivot->color }} x {{ $cartProduct->pivot->size }}
                                        </p>
                                        <p class="selected-product-total-price">
                                            Giá: {{ number_format($cartProduct->price * $cartProduct->pivot->quantity) }} VND
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <br>
                            <h4>Tổng tiền: {{ number_format($totalAmount, 0, ',', '.') }} VND</h4>
                            <input type="hidden" name="redirect" value="true">
                            <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-2 col-md-2 col-sm-2"></div>
            <button type="submit" class="btn dat-hang" name="payment_method" value="cashOnDelivery">Thanh toán khi nhận hàng</button>
            <button type="submit" class="btn dat-hang" name="payment_method" value="vnpay">Thanh toán bằng VNpay</button>
        </form>
        <br>
  </div>

@endsection


@section('js')
        <!--Bao gồm thư viện SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
</body>
</html>

