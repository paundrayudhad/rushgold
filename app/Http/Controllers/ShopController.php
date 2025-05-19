<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;

class ShopController extends Controller
{
    public function index($slug = null)
    {
        $categories = Category::all();

        $category = null;
        $categoryId = 0;

        if ($slug) {
            $category = Category::where('slug', $slug)->firstOrFail();
            $categoryId = $category->id;
        }

        $products = Product::with('category')
            ->when($category, function ($query) use ($category) {
                return $query->where('category_id', $category->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shop', [
            'categories' => $categories,
            'products' => $products,
            'category_id' => $categoryId,
        ]);
    }
    
}
