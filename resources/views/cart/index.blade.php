@extends('layouts.app')

@section('title', 'Shopping Cart')

@push('styles')
<style>
    .cart-container {
        background-color: #fff;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2rem;
    }
    
    .cart-table th {
        text-align: left;
        padding: 1rem;
        border-bottom: 2px solid #e0e0e0;
        background-color: #f8f9fa;
    }
    
    .cart-table td {
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .product-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .product-image-small {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .quantity-input {
        width: 60px;
        padding: 0.25rem;
        text-align: center;
    }
    
    .cart-summary {
        text-align: right;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e0e0e0;
    }
    
    .total-price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 1rem;
    }
    
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-cart-icon {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 1rem;
    }
    
    @media (max-width: 768px) {
        .cart-table {
            font-size: 0.9rem;
        }
        
        .cart-table th,
        .cart-table td {
            padding: 0.5rem;
        }
        
        .product-image-small {
            display: none;
        }
    }
</style>
@endpush

@section('content')
    <h1>Shopping Cart</h1>
    
    <div class="cart-container">
        @if($cart->items->count() > 0)
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $item)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    @if($item->product->image)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                             class="product-image-small">
                                    @endif
                                    <div>
                                        <a href="{{ route('products.show', $item->product) }}" 
                                           style="color: #333; text-decoration: none;">
                                            {{ $item->product->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', $item->product) }}" 
                                      class="quantity-controls">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                           min="1" max="{{ $item->product->stock }}" 
                                           class="quantity-input form-control">
                                    <button type="submit" class="btn btn-sm">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($item->subtotal, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $item->product) }}" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="cart-summary">
                <p class="total-price">Total: ${{ number_format($cart->total, 2) }}</p>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <form method="POST" action="{{ route('cart.clear') }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary">Clear Cart</button>
                    </form>
                    
                    <a href="{{ route('checkout.index') }}" class="btn">Proceed to Checkout</a>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Start shopping to add items to your cart!</p>
                <a href="{{ route('products.index') }}" class="btn" style="margin-top: 1rem;">Browse Products</a>
            </div>
        @endif
    </div>
@endsection