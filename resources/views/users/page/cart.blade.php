
@extends('users.layout.user')

@section('title')
<title>Giỏ hàng của tôi</title>
 
@endsection


@section('css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/adminlte.min.css') }}"> --}}

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <link rel="stylesheet" href="{{ asset ('frontend/css/product-detail.css') }}">
    <link rel="stylesheet" href="{{ asset ('frontend/css/cart.css') }}">


@endsection 


@section('content')
  <br>
  <div class="title-pgae"> Giỏ hàng</div>
  <br>
  <div class="cart-product">
    @if ($cartProducts->isEmpty())
        <div class="cart-table-null title-pgae">
            <h5>Úi Giỏ hàng của bạn hiện tại trống!</h5>
        </div>
    @else
                <div class="row cart-table">
                    <div class=" col-md-8 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Màu</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Thao tác</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($cartProducts as $cartProduct)
                                        <tr class="product-row">
                                            <td> 
                                                <a href="{{ route('product_detail', ['id' => $cartProduct->id]) }}">
                                                    <img class="product_image" src="{{ $cartProduct->feature_image_path }}" alt="">
                                                </a>  
                                            </td>
                                            <td class="col-md-3 text-center align-middle">{{ $cartProduct->name }}</td>
                                            <td class="text-center align-middle">{{ number_format($cartProduct->price) }}</td>
                                            <td class="text-center align-middle">{{ $cartProduct->pivot->color }}</td>
                                            <td class="text-center align-middle">{{ $cartProduct->pivot->size }}</td>
                                            <form action="{{ route('cart.update', ['productId' => $cartProduct->id, 'color' => $cartProduct->pivot->color, 'size' => $cartProduct->pivot->size]) }}" method="post">
                                                @csrf
                                                @method('POST')
                                                
                                                <td class="col-lg-2 col-sm-2 text-center align-middle ">
                                                    <div class="input-group input-group-sm">
                                                        <button class="btn btn-outline-secondary" type="button" id="minusBtn">-</button>
                                                        <input type="number" id="quantityInput" class="form-control text-center" value="{{ $cartProduct->pivot->quantity }}" name="quantity" min="1" readonly>
                                                        
                                                        <button class="btn btn-outline-secondary" type="button" id="plusBtn">+</button>

                                                        
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <button type="submit" class="btn btn-success update-product-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                                                </td>                                               
                                            </form>
                                            <td class="text-center align-middle">                                               
                                                <a href="{{ route('cart.removeProduct', ['productId' => $cartProduct->id, 'color' => $cartProduct->pivot->color, 'size' => $cartProduct->pivot->size]) }}" class="btn btn-danger remove-product-btn"><i class="fa-solid fa-trash"></i></a>
                                            </td> 
                                        </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                        </div>

                    </div>
                    <div class=" col-md-4 col-sm-12" id="total-detail">
                        <div class="total-detail">
                            <h4>Tiến hành đặt hàng</h4>
                            <br>
                            <h5 id="selectedProductCount">Sản phẩm trong giỏ hàng :{{ $cartProducts->count() }}</h5>

                            <br>
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
                            <h5 id="totalAmount">Tổng tiền: 0 VND</h5>
                            <br>
                            <form action="{{  route('checkout.index') }}" method="post">
                                @csrf
                                <!-- Lặp qua danh sách sản phẩm trong giỏ hàng -->
                                <input type="hidden" id="hiddenTotalAmount" name="totalAmount" value="">
                                <input type="hidden" id="productInfoInput" name="productInfo" value="">

                                <input type="hidden" name="cartProducts" value="{{ json_encode($cartProducts) }}">

                                <button type="submit" class="btn dat-hang">Đặt Hàng</button>
                            </form>
                        </div>
                    </div>          

                </div>

        <br>
        <div class="title-pgae"> Có thể bạn cũng thích</div>
        <div class="similar-product">
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
    @endif
 
    <script>
        document.addEventListener('DOMContentLoaded', function() 
        {
            const totalAmountElement = document.getElementById('totalAmount');
            const quantityInputs = document.querySelectorAll('.text-center.align-middle input[name="quantity"]');
            
            const plusButtons = document.querySelectorAll('#plusBtn');
            const minusButtons = document.querySelectorAll('#minusBtn');

            plusButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    let currentValue = parseInt(quantityInputs[index].value);
                    quantityInputs[index].value = currentValue + 1;

                });
            });

            minusButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    let currentValue = parseInt(quantityInputs[index].value);
                    if (currentValue > 1) {
                        quantityInputs[index].value = currentValue - 1;
                    }
                });
            });

            updateTotalAmount();

            function updateTotalAmount() {
                let totalAmount = 0;
                const productInfos = document.querySelectorAll('.selected-product-info');


                productInfos.forEach(function(productInfo) {
                    const priceElement = productInfo.querySelector('.selected-product-total-price');

                    const priceText = priceElement.innerText;

                    // Log giá trị để kiểm tra
                    console.log('Price Text:', priceText);

                    const price = parseInt(priceText.replace('Giá: ', '').replace(' VND', '').replace(/,/g, ''), 10);
                     totalAmount += price;
                    console.log('Price Text:', totalAmount);
                });

                const totalAmountElement = document.getElementById('totalAmount');
                totalAmountElement.innerText = 'Tổng tiền: ' + formatCurrency(totalAmount);
            }

            function formatCurrency(amount) {
                return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            }

            const totalAmountText = document.getElementById('totalAmount').innerText;
            const totalAmount = parseFloat(totalAmountText.replace('Tổng tiền: ', '').replace(' VND', '').replace(/\./g, '').replace(',', '.'));

            // Đặt giá trị vào trường ẩn
            document.getElementById('hiddenTotalAmount').value = totalAmount;

        });        

    </script>
    
  </div>
  <!-- /.card-body -->
@endsection


@section('js')

        <!--Bao gồm thư viện SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('frontend/js/cart-product.js') }}"></script>
        <script>
            // console.log(selectedProducts)
        </script>
@endsection
</body>
</html>

