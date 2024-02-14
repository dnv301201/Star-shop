<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Component\Recusive;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeQuantity;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductRequest;

class AdminProductController extends Controller
{   
    use StorageImageTrait;
    private $category;
    private $product;
    private $productImage;
    private $tag;
    private $productTag;
    public function __construct(Category $category,Product $product,ProductImage $productImage,
    Tag $tag,ProductTag $productTag){
        $this->category = $category;
        $this->product = $product;
        $this->productImage = $productImage;
        $this->tag = $tag;
        $this->productTag = $productTag;
    }

    public function index()
    {
        $products = $this->product->paginate(10);
        return view('admin.product.index',compact('products'));
    }
    public function create()
        {
            $addOption = $this->getCategory($parentId='');
            return view('admin.product.add', compact('addOption'));
        }
    
    public function getCategory($parentId){
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $addOption = $recusive -> categoryRecusive($parentId);
        return $addOption;
    }    

    public  function store(ProductRequest $request)
    {
        try{
            DB::beginTransaction();
            $validator = Validator::make($request->all(),$request->rules(), $request->messages());
            if($validator->fails()){
                return redirect()->back()
                                ->withErrors($validator);            
            }
            $dataProductCreate=[
                'name'=> $request->name,
                'price' =>$request->price,
                'content'=>$request->content,
                'user_id'=>auth()->id(),
                'category_id'=>$request->category_id,
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request,'feature_image_path','product');
            if(!empty($dataUploadFeatureImage)){
                $dataProductCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataProductCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }
            
            //them dư lieu bang product
            $product = $this->product->create($dataProductCreate);
            
            //them data vao bang product_images
            if($request->hasFile('image_path')){
                foreach($request->image_path as $fileItem){
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem,'product');
                    
                    $product->images()->create(
                        [
                            'image_path'=>$dataProductImageDetail['file_path'],
                            'image_name'=>$dataProductImageDetail['file_name']
        
                        ]
                    );
                
                }
    
            }
        
            //Them tag cho san pham

            foreach($request->tags as $tagItem){
                
                $tagInstance=$this->tag->firstOrCreate(['name'=>$tagItem]);
                // $this->productTag->create([
                //     'product_id'=>$product->id,
                //     'tag_id'=>$tagInstance->id
                // ]);
                $tagIds[] = $tagInstance->id;
            }
            $product->tags()->attach($tagIds);
            
            DB::commit();
            return redirect()->route('product.index')->with('success','Thêm sản phẩm thành công');
            
        }
        catch(\Exception $exception){ 
            DB::rollBack();
            Log::error('Message'.$exception->getMessage() . 'Line'.$exception->getLine());
            return redirect()->back()->with('error','Thêm sản phẩm không thành công');
        }
        //  dd($request->tags);
  
    
    }

    public function view($id)
    {

        $product = Product::find($id);

        if (!$product) {

            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }
        
        $addOption = $this->getCategory($product->category_id);

        $productVersions = ProductAttribute::with('quantities')
            ->where('product_id', $id)
            ->paginate(10);

        return view('admin.product.view', compact('product','addOption','productVersions'));
    }


    //
    public function edit($id)
    {
        $product = $this->product->find($id);
        $addOption = $this->getCategory($product->category_id);
        return view('admin.product.edit',compact('product','addOption'));
    }


    public function update(Request $request, $id){
        try{
            DB::beginTransaction();
            $dataProductUpdate=[
                'name'=> $request->name,
                'price' =>$request->price,
                'content'=>$request->content,
                'user_id'=>auth()->id(),
                'category_id'=>$request->category_id,
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request,'feature_image_path','product');
            if(!empty($dataUploadFeatureImage)){
                $dataProductUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataProductUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }
            
            //them dư lieu bang product
            $this->product->find($id)->update($dataProductUpdate);
            $product = $this->product->find($id);

            //them data vao bang product_images
            if($request->hasFile('image_path')){
                $this->productImage->where('product_id',$id)->delete();
                foreach($request->image_path as $fileItem){
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem,'product');
                    
                    $product->images()->create(
                        [
                            'image_path'=>$dataProductImageDetail['file_path'],
                            'image_name'=>$dataProductImageDetail['file_name']
        
                        ]
                    );
                
                }
    
            }
        
            //Them tag cho san pham
            // $tags = $request->tags;
    
            // if (!is_array($tags)) {
            //     $tags = array($tags);
            // }
            foreach($request->tags as $tagItem){
                
                $tagInstance=$this->tag->firstOrCreate(['name'=>$tagItem]);
                // $this->productTag->create([
                //     'product_id'=>$product->id,
                //     'tag_id'=>$tagInstance->id
                // ]);
                $tagIds[] = $tagInstance->id;
            }
            $product->tags()->sync($tagIds);
            
            DB::commit();
            return redirect()->route('product.index')->with('success','Sửa thông tin thành công');
      
        }
        catch(\Exception $exception){ 
            DB::rollBack();
            Log::error('Message'.$exception->getMessage() . 'Line'.$exception->getLine());
            return redirect()->back()->with('error','Sửa sản phẩm không thành công');
        }
        //  dd($request->tags);
  
    
    }

    public function delete($id)
    { 
        try {
            $product = $this->product->find($id);
    
            $featureImagePath = $product->feature_image_path;
            
            if ($featureImagePath) {
                // Chuyển đổi đường dẫn tương đối thành đường dẫn tuyệt đối
                $absoluteFeaturePath = storage_path('app/public/' . substr($featureImagePath, 9));
                // Xóa tệp tin
                if (file_exists($absoluteFeaturePath)) {
                    unlink($absoluteFeaturePath);
                }
            }
            
            $productImages = $product->productImages;
            
            foreach ($productImages as $productImageItem) {
                $imagePath = $productImageItem->image_path;
            
                if ($imagePath) {
                    // Chuyển đổi đường dẫn tương đối thành đường dẫn tuyệt đối
                    $absoluteImagePath = storage_path('app/public/' . substr($imagePath, 9));
                    // Xóa tệp tin
                    if (file_exists($absoluteImagePath)) {
                        unlink($absoluteImagePath);
                    }
                }
            }                      
    
            $product->delete();
    
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('Message'.$exception->getMessage() . 'Line'.$exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
            return redirect()->back()->with('error','Xóa sản phẩm không thành công');
        }
    }
    

    

    public function showAddProductVersionForm($id)
    {
        $product = $this->product->find($id);

        return view('admin.product.version.addProductVersion', compact('product'));
    }
    


    public function storeProductVersion(Request $request, $id)
    {
        $color = $request->input('color');
        $sizes = $request->input('sizes'); 
        $quantities = $request->input('quantities'); 
    

        $existingColor = ProductAttribute::where('product_id', $id)
            ->where('color', $color)
            ->exists();
    
        if ($existingColor) {
            foreach ($sizes as $index => $size) {
                if (!empty($size)) {
                    // Kiểm tra nếu size đã tồn tại cho màu này
                    $existingSize = ProductAttribute::where('product_id', $id)
                        ->where('color', $color)
                        ->whereHas('quantities', function ($query) use ($size) {
                            $query->where('size', $size);
                        })
                        ->first();
    
                    if (!$existingSize) {

                        $productAttribute = ProductAttribute::where('product_id', $id)
                            ->where('color', $color)
                            ->first();
    
                        $quantity = new ProductAttributeQuantity();
                        $quantity->size = $size;
                        $quantity->quantity = $quantities[$index] ?? 0;
    
                        $productAttribute->quantities()->save($quantity);
                    } else if($existingSize) {

                        $quantity = $existingSize->quantities()->firstOrCreate(
                            ['size' => $size]
                        );


                        if (isset($quantities[$index])) {

                            if ($quantities[$index] >= 0) {
                                
                                $quantity->increment('quantity', $quantities[$index]);
                            } else {
                                
                                $quantity->decrement('quantity', abs($quantities[$index]));
                            }
                        }
                        if ($quantity->quantity <= 0) {
                            
                            $quantity->delete();
                        }
                        // return redirect()->back()->with('success', 'Size đã tồn tại cho màu này đã cập nhật số lượng.');
                    }
                }
            }
            return redirect()->route('product.view',['id' => $id])->with('success', 'Phiên bản sản phẩm đã được thêm thành công!');
        }
    
        // Nếu màu không tồn tại, tạo mới thuộc tính cho sản phẩm
        $productAttribute = new ProductAttribute();
        $productAttribute->color = $color;
        $productAttribute->product_id = $id;
        $productAttribute->save();
    
        // Tạo số lượng cho từng kích cỡ
        foreach ($sizes as $index => $size) {
            if (!empty($size)) {
                $quantity = new ProductAttributeQuantity();
                $quantity->size = $size;
                $quantity->quantity = $quantities[$index] ?? 0;
    
                $productAttribute->quantities()->save($quantity);
            }
        }
    
        return redirect()->route('product.view',['id' => $id])->with('success', 'Phiên bản sản phẩm đã được thêm thành công!');
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $products = $this->product
            ->where('name', 'like', "%$searchTerm%")
            ->orWhereHas('category', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            })
            ->paginate(10); 
    
        $products->appends(['search' => $searchTerm]); // Để giữ trạng thái tìm kiếm khi chuyển trang
    
        return view('admin.product.search', compact('products'));
    }
}

