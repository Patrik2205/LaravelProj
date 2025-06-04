@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    
    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .checkout-form {
        background-color: #fff;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .order-summary {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 2rem;
        height: fit-content;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .order-total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #333;
        font-size: 1.25rem;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
    <h1>Checkout</h1>
    
    <div class="checkout-grid">
        <div class="checkout-form">
            <h2>Billing Information</h2>
            
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    @error('email')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    @error('name')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" 
                           value="{{ old('phone') }}">
                    @error('phone')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="address">Shipping Address</label>
                    <textarea name="address" id="address" rows="3" class="form-control">{{ old('address') }}</textarea>
                    @error('address')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <button type="submit" class="btn">Place Order</button>
            </form>
        </div>
        
        <div class="order-summary">
            <h3>Order Summary</h3>
            
            @foreach($cart->items as $item)
                <div class="order-item">
                    <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                    <span>${{ number_format($item->subtotal, 2) }}</span>
                </div>
            @endforeach
            
            <div class="order-total">
                <div style="display: flex; justify-content: space-between;">
                    <span>Total:</span>
                    <span>${{ number_format($cart->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection