<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOderController extends Controller
{
    public function index(){
        $userOrders = Order::with('orderDetails.product')
        ->orderBy('created_at', 'desc')
        ->paginate(5);
    if ($userOrders->isNotEmpty()){
        return view('admin.order.view', compact('userOrders'));
    } else {

        return redirect()->back()->with('error', 'Bạn không có đơn hàng nào.');
    }  
    }
}
