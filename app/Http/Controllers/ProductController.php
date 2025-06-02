<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->when(request('search'), function ($query) {
                return $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('category'), function ($query) {
                return $query->where('category_id', request('category'));
            })
            ->when(request('sort'), function ($query) {
                $sort = request('sort');
                switch ($sort) {
                    case 'name_asc':
                        return $query->orderBy('name', 'asc');
                    case 'name_desc':
                        return $query->orderBy('name', 'desc');
                    case 'price_asc':
                        return $query->orderBy('price', 'asc');
                    case 'price_desc':
                        return $query->orderBy('price', 'desc');
                    default:
                        return $query->orderBy('created_at', 'desc');
                }
            })
            ->paginate(12);
            
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}