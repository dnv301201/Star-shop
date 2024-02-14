
@extends('users.layout.user')

@section('title')
<title>Check out</title>
 
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('/frontend/css/order-view.css') }}">
@endsection 


@section('content')
  <br>
  <div class="title-pgae"> Đơn hàng của tôi</div>
  <br>
  <div class="order-detail">
    <h4>Your Orders</h4>

    @foreach ($userOrders as $order)
        <div class="order-item">
            <h5>Mã đơn hàng: {{ $order->id }}</h5>
            <div class="row">
                <div class="col-md-6">
                    <p>Tên người đặt: {{ $order->fullname }}</p>
                    <p>Email: {{ $order->email }}</p>
                    <p>Số diện thoại: {{ $order->phone }}</p>
                    <p>Địa chỉ: {{ $order->address }}</p>
                    <p>Ghi chú: {{ $order->notes }}</p>
                </div>
                <div class="col-md-6">
                    <p>Tổng tiền: {{ number_format( $order->total_amount, 0, ',', '.') }} VNĐ
                    <p>Phương thức thanh toán: {{ $order->payment_method }}</p>
                    <p>Trạng thái: {{ $order->status }}</p>
                    <p>Ngày đặt hàng: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                </div>

                <div class="col-md-12">
                    <h5>Sản phẩm đã đặt</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Màu</th>
                                    <th>Size</th>
                                    <th>Giá sản phẩm</th>
                                    <th>Tổng tiền sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td><img class="product_image" src="{{ $detail->product->feature_image_path }}" alt="{{ $detail->product->name }}"></td>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $detail->color }}</td>
                                        <td>{{ $detail->size }}</td>
                                        <td>{{ $detail->product_price }}</td>
                                        <td>{{ number_format($detail->total_price, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    @endforeach
  </div>
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div>
      <div class="col-sm-6">
        <ul class="pagination">
          @if ($userOrders->onFirstPage())
              <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
                  <span class="page-link" aria-hidden="true">&laquo;Trang đầu</span>
              </li>
          @else
              <li class="page-item">
                  <a class="page-link" href="{{ $userOrders->url(1) }}" rel="prev" aria-label="@lang('pagination.first')">&laquo;</a>
              </li>
          @endif
      
          {{ $userOrders->links() }}
      
          @if ($userOrders->hasMorePages())
              <li class="page-item">
                  <a class="page-link" href="{{ $userOrders->url($userOrders->lastPage()) }}" rel="next" aria-label="@lang('pagination.last')">&raquo;</a>
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

@endsection


@section('js')

@endsection
</body>
</html>

