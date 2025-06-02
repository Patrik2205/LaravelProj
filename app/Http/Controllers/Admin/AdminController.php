<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'users' => User::count(),
            'revenue' => Order::sum('total'),
        ];
        
        $recentOrders = Order::latest()->take(5)->get();
        
        return view('admin.index', compact('stats', 'recentOrders'));
    }
}