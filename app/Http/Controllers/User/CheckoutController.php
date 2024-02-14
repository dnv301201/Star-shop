<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderDetail;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request) {

        $totalAmount = $request->input('totalAmount');

        $productInfo = $request->input('productInfo');

        $userCart = Cart::with('products')->where('user_id', auth()->id())->first();
        $cartProducts = $userCart->products;
        $cart_id=$userCart->id;
        $userId = Auth::id();


        return view('users.page.checkout', compact('productInfo', 'totalAmount','cartProducts'));
    }
}
