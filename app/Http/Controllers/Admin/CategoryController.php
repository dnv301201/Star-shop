<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Component\Recusive;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\warning;

class CategoryController extends Controller
{


    private $category;
    public function __construct(Category $category){
        $this->category = $category;
    }

    public function index(){
        
        $categories = $this->category->latest()->paginate(5);
        $addOption = $this->getCategory($parentId='');
        return view('admin.category.index',compact('categories','addOption'));

    }
    
    public function create()
    {   
        
        $addOption = $this->getCategory($parentId='');
        return view('admin.category.add',compact('addOption'));
    }

    public function store(CategoryRequest $request){
        
        $existingCategory = $this->category::where('name', $request->name)->first();
        
        if ($existingCategory) {
            return redirect()->route('category.index')->with('error', 'Danh mục đã tồn tại.');
        }

        $validator = Validator::make($request->all(),$request->rules(), $request->messages());
        if($validator->fails()){
            return redirect()->back()
                            ->withErrors($validator);
                             
        }
        $this->category->create([
            'name'=>$request->name,
            'parent_id'=>$request->parent_id,
            'slug' =>str_slug($request->name)
        ]);
        return redirect()->route('category.index')->with('success','Thêm thông tin thành công');;
    }


    public function getCategory($parentId){
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $addOption = $recusive -> categoryRecusive($parentId);
        return $addOption;

    }

    public function view(){} 

   public function edit($id)
    {
        $category = $this->category->find($id);
        $addOption = $this -> getCategory($category->parent_id);
        //  dd($category);
        return view ('admin.category.edit',compact('category','addOption'));

    }
    
    public function update($id,Request $request){
        $this->category->find($id)->update([
            'name'=>$request->name,
            'parent_id'=>$request->parent_id,
            'slug' =>str_slug($request->name)
        ]);
        return redirect()->route('category.index')->with('success','Sửa thông tin thành công');
    }

    public function delete($id)
    {
        try{
            $category = $this->category->find($id);

            if ($category->products()->count() > 0) {
                
                return response()->json([
                    'code' => 200,
                    'message' => 'error'
                ], 200);
            }
            else{
                $category->delete();
                // return redirect()->route('category.index')->with('success','Xóa thông tin thành công');
                return response()->json([
                    'code' => 200,
                    'message' => 'success'
                ], 200);
            }

        }
        catch(\Exception $exception){
            Log::error('Message'.$exception->getMessage() . 'Line'.$exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }

    }
    
}
