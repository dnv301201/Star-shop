<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HomeController extends Controller
{   
    private $product;
    private $productImage;
    private $category;
    public function __construct(Product $product,ProductImage $productImage, Category $category){
        $this->product = $product;
        $this->productImage = $productImage;
        $this->category = $category;

    }
    public function index(){
        $products = $this->product->oldest('id')->paginate(4);


        // Lấy danh mục có tên là 'Nam'
        $categoryNam = $this->category->where('name', 'Nam')->first();

        // Lấy tất cả sản phẩm thuộc danh mục 'Nam'
        $childCategoryNamId = $categoryNam->children()->with('products')->get()->pluck('children.*.id')->collapse()->toArray();
        $childProductsNam = Product::whereIn('category_id', $childCategoryNamId)->paginate(8);

        // Lấy danh mục có tên là 'Nữ'
        $categoryNu = $this->category->where('name', 'Nữ')->first();

        // Lấy tất cả sản phẩm thuộc danh mục 'Nữ'
        $childCategoryNuId = $categoryNu->children()->with('products')->get()->pluck('children.*.id')->collapse()->toArray();
        $childProductsNu = Product::whereIn('category_id', $childCategoryNuId)->paginate(8);
        return view('users.page.home',compact('products','childProductsNam','childProductsNu'));
    }

    public function category_detail(){
        // $rootCategories = $this->category->where('parent_id', 0)->get();
        $categories = Category::with('children.children')->where('parent_id', 0)->get();

        return view('users.partials.header', compact('categories'));
    }

    public function showCategory($categorySlug)
    {
        // Tìm danh mục theo slug được truyền vào từ URL
        $selectedCategory = $this->category->where('slug', $categorySlug)->first();
        
        $categories = $selectedCategory->children;

        // Lấy tất cả các ID của các danh mục con cấp 3 của danh mục được chọn
        $childCategoryIds = $selectedCategory->children()->with('children')->get()->pluck('children.*.id')->collapse()->toArray();

        // Lấy tất cả sản phẩm từ các danh mục con cấp 3 của danh mục được chọn
        $products = Product::whereIn('category_id', $childCategoryIds)->paginate(12);

        return view('users.page.pro-of-cate', [
            
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q');
    
        $products = $this->product
            ->where('name', 'like', "%$searchTerm%")
            ->orWhereHas('category', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            })
            ->paginate(10); 
    
        $products->appends(['search' => $searchTerm]); // Để giữ trạng thái tìm kiếm khi chuyển trang
        if($products->total() > 0){
            return view('users.page.search', compact('products'));
        }
        else{
            return redirect()->back()->with('error','Không tìm thấy sản phẩm nào');
        }          
    }

}