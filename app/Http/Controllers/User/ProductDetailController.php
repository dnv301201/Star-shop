<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductAttribute;

class ProductDetailController extends Controller
{
    private $product;
    private $productImage;
    private $attribute;
    public function __construct(Product $product,ProductImage $productImage,ProductAttribute $attribute){
        $this->product = $product;
        $this->productImage = $productImage;
        $this->attribute = $attribute;
    }
    public function product_detail($id){
        $pro=$this->product->find($id);
        $img_pro=$this->productImage->where('product_id',$id)->get();
        $productVersions=$this->attribute->with('quantities')
            ->where('product_id',$id)->get();

        return view('users.page.product',compact('pro','img_pro','productVersions'));

    }   
}
