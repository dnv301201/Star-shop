<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Log;

class OderController extends Controller
{

    public function processCheckout(Request $request) {
        $paymentMethod = $request->input('payment_method');
        
        $totalAmount = $request->input('totalAmount');

        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $notes = $request->input('notes');

        $userCart = Cart::with('products')->where('user_id', auth()->id())->first();
        $cartProducts = $userCart->products;

        $order = $this->createOrderAndDetails($totalAmount,$cartProducts,$fullname,$email,$phone,$address,$notes,$paymentMethod);

        if ($paymentMethod === 'cashOnDelivery') {
            $order->status = 'Chờ giao hàng';
            $order->save();

            $userId = auth()->id();
            $this->clearCartByUserId($userId);
            
            return view('users.page.order-response', ['paymentSuccess' => true]);
        } elseif ($paymentMethod === 'vnpay') {

            $order_id=$order->id;

            $totalAmount = $request->input('totalAmount');

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://shop-project.test/user/order_response";

            $vnp_TmnCode = "LPSHU043";//Mã website tại VNPAY 
            $vnp_HashSecret = "VKQWMCUAYOSFMFONPIMFSEFCREZEDJER"; //Chuỗi bí mật


            $vnp_TxnRef = $order_id; 
            $vnp_OrderInfo = "Thanh toán hóa đơn";
            $vnp_OrderType = "Star Shop";
            $vnp_Amount = $totalAmount * 100;
            $vnp_Locale = "vi-VN";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }


            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }


            $userId = auth()->id();
            $this->clearCartByUserId($userId);


            $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);

                if (isset($_POST['redirect'])) {
                    header('Location: ' . $vnp_Url);
                    die();
                } else {
                    echo json_encode($returnData);
                } 

        }

    }

    private function createOrderAndDetails($totalAmount,$cartProducts,$fullname,$email,$phone,$address,$notes,$paymentMethod) {

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_amount = $totalAmount;
        $order->fullname = $fullname;
        $order->email = $email;
        $order->phone = $phone;
        $order->address = $address;
        $order->notes = $notes;
        $order->total_amount = $totalAmount;
        $order->status = 'Chờ thanh toán';
        $order->payment_method = $paymentMethod;

        $order->save();


        $orderId = $order->id;


        foreach ($cartProducts as $cartProduct) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $orderId;
            $orderDetail->product_id = $cartProduct->id;
            $orderDetail->quantity = $cartProduct->pivot->quantity;
            $orderDetail->color = $cartProduct->pivot->color;
            $orderDetail->size = $cartProduct->pivot->size;
            $orderDetail->product_price = $cartProduct->price;
            $orderDetail->total_price = $cartProduct->price * $cartProduct->pivot->quantity;

            $orderDetail->save();
        }
        return $order;
    }

    public function oderes_Page(Request $request){
            $vnp_ResponseCode = $request->input('vnp_ResponseCode');
            $vnp_TxnRef = $request->input('vnp_TxnRef');
            // dd($vnp_ResponseCode);
            // Kiểm tra kết quả thanh toán từ cổng thanh toán
            if ($vnp_ResponseCode === '00') {
                // Xử lý khi thanh toán thành công
                $order = Order::find($vnp_TxnRef);
    
                if ($order) {
                    $order->status = 'Chờ giao hàng';
                    $order->save();
    
                    return view('users.page.order-response', ['paymentSuccess' => true]);
                } else {
                    return view('users.page.order-response', ['paymentSuccess' => false, 'error' => 'Quá trình thanh toán lỗi']);
                }
            }
        return view('users\page\order-response');
    }

    public function clearCartByUserId($userId)
    {

        $cart = Cart::where('user_id', $userId)->first();
    
        if ($cart) {

            $cart->cartProducts()->delete();
        }
    }
    
    public function show_Order($id){

        $userOrders = Order::with('orderDetails.product')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);
        // dd($userOrders);
        if ($userOrders->isNotEmpty()) {
            return view('users.page.my-order', compact('userOrders'));
        } else {

            return redirect()->back()->with('error', 'Bạn không có đơn hàng nào.');
        }    
    }

}
