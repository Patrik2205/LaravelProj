<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::tree();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()
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
            
        return view('categories.show', compact('category', 'products'));
    }
}