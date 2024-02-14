<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductOfCateController extends Controller
{
    public function showChild($id, $childId)
    {
        $category = Category::findOrFail($childId);
        $products = $category->products()->paginate(10);;
        $categories = Category::all();

        return view('users.page.show-pro', compact('category', 'products', 'categories'));
    }
}
