@extends('admin.layouts.admin')
 
@section('title')
<title>Trang chủ</title>
 
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/backend/css/page/home.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

@endsection
 
@section('content')

<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>'Home','key'=>'star'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalOrders }}</h3>
                            <p>Đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">Xem thêm<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
        
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h3>
                            <p>Doanh thu</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Xem thêm<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
        
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalUsers }}</h3>
                            <p>Người dùng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Xem thêm<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
        
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalProductQuantity }}</h3>
                            <p>Sản phẩm đã bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">Xem thêm<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>Doanh Thu Theo Tháng</h3>
                            <canvas id="revenueChart"></canvas>

                        </div>

                        <div class="col-md-4">
                            <h3>Thống Kê Sản Phẩm</h3>
                            <canvas id="productChart"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <table>
                        <thead>
                            
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          let ctx = document.getElementById('revenueChart').getContext('2d');
          let revenueChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: @json($monthlyRevenue->pluck('month')),
                  datasets: [{
                      label: 'Doanh Thu (VNĐ)',
                      data: @json($monthlyRevenue->pluck('total')),
                      backgroundColor: 'rgba(75, 192, 192, 1)', //độ đậm
                      borderColor: 'rgba(75, 192, 192, 1)',
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });

          let ctxProduct = document.getElementById('productChart').getContext('2d');
          let productChart = new Chart(ctxProduct, {
              type: 'pie',
              data: {
                  labels: Object.values({!! json_encode($productNames) !!}),
                  
                  datasets: [{
                      data: @json($productStats->pluck('total_quantity')),
                      
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.7)', // độ đậm 
                          'rgba(54, 162, 235, 0.7)',
                          'rgba(255, 206, 86, 0.7)',
                          'rgba(75, 192, 192, 0.7)',
                          'rgba(153, 102, 255, 0.7)',
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                      ],
                      borderWidth: 1
                  }]
              },
              options:{

              }         
          });
      });
    </script>


</div>

@endsection

