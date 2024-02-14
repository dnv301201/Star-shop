<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function viewCart(){

        $products = Product::paginate(4);
        $userCart = Cart::with('products')->where('user_id', auth()->id())->first();
        // dd($userCart->toArray());
        if ($userCart) {
            // $Cart=$userCart->id;
            // dd($Cart);
            $cartProducts = $userCart->products;

            return view('users.page.cart', compact('cartProducts','products'));
        } else {
            
            return redirect()->back()->with('error','Bạn chưa có sản phẩm nào trong giỏ hàng');
        }
    }
    public function addToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_name = $request->input('product_name');
        $product_image = $request->input('product_image');
        $color = $request->input('color');
        $size = $request->input('size');
        $product_price = $request->input('product_price');
        $quantity = $request->input('quantity');

        if (empty($color) || empty($size)) {
            return redirect()->back()->with('error', 'Vui lòng chọn màu trước khi thêm vào giỏ hàng.');
        }
        $user_id = auth()->id();

        $cart = Cart::where('user_id', $user_id)->first();
        if ($cart) {
            $existingProductSameAttributes = $cart->products()->where('product_id', $product_id)
                ->wherePivot('size', $size)
                ->wherePivot('color', $color)
                ->first();
    
            if ($existingProductSameAttributes) {
                // Nếu sản phẩm đã tồn tại trong giỏ hàng với cùng màu và cùng size, chỉ cập nhật số lượng
                $existingProductSameAttributes->pivot->quantity += $quantity;
                $existingProductSameAttributes->pivot->save();
    
                return redirect()->back()->with('success', 'Số lượng sản phẩm đã được cập nhật trong giỏ hàng.');
            }
        }

        // Thêm sản phẩm vào giỏ hàng cùng với user_id
        $cart = Cart::firstOrCreate(['user_id' => $user_id]);
        $cart->products()->attach($product_id, [ 
            'product_name' => $product_name,
            'quantity' => $quantity,
            'size' => $size,
            'color' => $color,
            'product_price' => $product_price,
            'product_img' => $product_image,
        ]);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function updateCartQuantity(Request $request, $productId, $color, $size)
    {
        try {
            $quantity = $request->input('quantity');
            $userCart = Cart::where('user_id', auth()->id())->firstOrFail();
            if ($userCart) {
                // Tìm sản phẩm cần cập nhật
                $productToUpdate = $userCart->products()
                    ->where('products.id', $productId)
                    ->where('cart_product.color', $color)
                    ->where('cart_product.size', $size)
                    ->first();

                if ($productToUpdate) {
                    // Cập nhật số lượng sản phẩm trong giỏ hàng
                    $userCart->products()
                        ->where('products.id', $productId)
                        ->where('cart_product.color', $color)
                        ->where('cart_product.size', $size)
                        ->update(['quantity' => $quantity]);
    
                    return redirect()->back()->with('success','Cập nhật số lượng thành công');
                }
    
                return response()->json([
                    'code' => 400,
                    'message' => 'Không tìm thấy sản phẩm trong giỏ hàng hoặc cập nhật không thành công.'
                ], 400);
            }
    
            return response()->json([
                'code' => 400,
                'message' => 'Không tìm thấy giỏ hàng hoặc cập nhật không thành công.'
            ], 400);
        } catch (\Exception $exception) {
            Log::error('Error update quantity product. Message: ' . $exception->getMessage() . '. File: ' . $exception->getFile() . '. Line: ' . $exception->getLine() . '. Trace: ' . $exception->getTraceAsString());
            return response()->json([
                'code' => 500,
                'message' => 'Có lỗi xảy ra khi cập nhật số lượng sản phẩm.'
            ], 500);
        }
    }
    
    

    public function removeProduct($productId, $color, $size)
    {
        try {

            // Tìm giỏ hàng của người dùng hiện tại
            $userCart = Cart::where('user_id', auth()->id())->firstOrFail();

            // Xác định sản phẩm cần xóa theo ID, màu sắc và kích thước
            $productToRemove = $userCart->products()
                ->where('product_id', $productId)
                ->wherePivot('color', $color)
                ->wherePivot('size', $size)
                ->first();

 
            
            if ($productToRemove) {
                // Xóa sản phẩm khỏi giỏ hàng
                $userCart->products()->where('id', $productId)
                    ->wherePivot('color', $color)
                    ->wherePivot('size', $size)
                    ->detach();

                return response()->json([
                    'code' => 200,
                    'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.'
                ], 200);
            } else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Không tìm thấy sản phẩm trong giỏ hàng.'
                ], 400);
            }
        } catch (\Exception $exception) {
            Log::error('Error deleting product. Message: ' . $exception->getMessage() . '. File: ' . $exception->getFile() . '. Line: ' . $exception->getLine() . '. Trace: ' . $exception->getTraceAsString());
            return response()->json([
                'code' => 500,
                'message' => 'Xóa sản phẩm không thành công. Vui lòng kiểm tra logs để biết chi tiết lỗi.'
            ], 500);
        }
    }

    public function processCart(Request $request)
    {
        // Nhận dữ liệu từ form
        $selectedProductDetails = json_decode($request->input('selectedProductsDetails'), true);
        
        Session::put('selected_products_details', $selectedProductDetails);

        return view('users.page.checkout', compact('selectedProductDetails'));
    }

}
