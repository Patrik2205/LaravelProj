<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::getCart();
        $cart->addProduct($product, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = Cart::getCart();
        $cart->updateQuantity($product, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function remove(Product $product)
    {
        $cart = Cart::getCart();
        $cart->removeProduct($product);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function clear()
    {
        $cart = Cart::getCart();
        $cart->clear();

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}