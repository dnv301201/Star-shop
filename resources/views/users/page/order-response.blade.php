
@extends('users.layout.user')

@section('title')
<title>Giỏ hàng của tôi</title>
 
@endsection


@section('css')
  <link rel="stylesheet" href="{{ asset('frontend/css/order-response.css') }}">
@endsection 


@section('content')
  <br>
  <div class="title-pgae">Thanh toán</div>
  <br>
  <div class="oder-response">
    @if($paymentSuccess == true)
      <div class="cart-table-comp title-pgae">
        <h4><i class="fa-solid fa-check"></i>Cảm ơn bạn đã quan tâm và đặt hàng</h4>
      </div>
    @else
      <div class="cart-table-uncomp title-pgae">
        <h4><i class="fa-solid fa-circle-xmark"></i>Rất tiếc, thanh toán không thành công</h4>
       </div>
    @endif
  </div>

@endsection


@section('js')

@endsection
</body>
</html>

