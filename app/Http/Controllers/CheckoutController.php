<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::getCart();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = Cart::getCart();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);
        
        $order = Order::createFromCart($cart, $request->all());
        
        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}