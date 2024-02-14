<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\User;


class StatiticsController extends Controller
{
    public function index()
    {
        // Thống kê doanh thu theo tháng
        $monthlyRevenue = Order::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), 
                          DB::raw("SUM(total_amount) as total"))
            ->groupBy('month')
            ->get();


        $productStats = OrderDetail::select('product_id', DB::raw('SUM(quantity) as total_quantity'))

            ->groupBy('product_id')
            ->get();
            
              // Lấy thông tin sản phẩm
        $productDetails = OrderDetail::with('product')->get();
        $productNames = $productDetails->pluck('product.name')->unique();

        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalProductQuantity = $productStats->sum('total_quantity');
        $totalRevenue = $monthlyRevenue->sum('total');

        return view('admin.home', compact('monthlyRevenue', 'productStats', 'productNames','productDetails',
            'totalOrders','totalUsers','totalProductQuantity','totalRevenue'));
    }
}
