@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    .product-detail {
        background-color: #fff;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 2rem;
    }
    
    @media (max-width: 768px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .product-image-container {
        text-align: center;
    }
    
    .product-detail-image {
        max-width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: contain;
    }
    
    .product-info-section h1 {
        margin-bottom: 1rem;
        color: #333;
    }
    
    .product-meta {
        margin-bottom: 1rem;
        color: #666;
    }
    
    .product-meta span {
        margin-right: 1rem;
    }
    
    .product-price-large {
        font-size: 2rem;
        color: #007bff;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    
    .product-description {
        margin-bottom: 2rem;
        line-height: 1.8;
    }
    
    .stock-info {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        margin-bottom: 1rem;
        display: inline-block;
    }
    
    .in-stock {
        background-color: #d4edda;
        color: #155724;
    }
    
    .out-of-stock {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .add-to-cart-section {
        border-top: 1px solid #e0e0e0;
        padding-top: 2rem;
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb" style="margin-bottom: 2rem;">
        <a href="{{ route('home') }}">Home</a> /
        <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a> /
        {{ $product->name }}
    </div>
    
    <div class="product-detail">
        <div class="product-detail-grid">
            <div class="product-image-container">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-detail-image">
                @else
                    <div style="background-color: #f0f0f0; height: 400px; display: flex; align-items: center; justify-content: center; color: #999;">
                        No Image Available
                    </div>
                @endif
            </div>
            
            <div class="product-info-section">
                <h1>{{ $product->name }}</h1>
                
                <div class="product-meta">
                    <span><strong>SKU:</strong> {{ $product->sku }}</span>
                    <span><strong>Category:</strong> {{ $product->category->name }}</span>
                </div>
                
                <p class="product-price-large">${{ number_format($product->price, 2) }}</p>
                
                <div class="stock-info {{ $product->isInStock() ? 'in-stock' : 'out-of-stock' }}">
                    @if($product->isInStock())
                        ✓ In Stock ({{ $product->stock }} available)
                    @else
                        ✗ Out of Stock
                    @endif
                </div>
                
                <div class="product-description">
                    <h3>Description</h3>
                    <p>{{ $product->description }}</p>
                </div>
                
                @if($product->isInStock())
                    <div class="add-to-cart-section">
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" 
                                       min="1" max="{{ $product->stock }}" class="form-control" style="width: 100px;">
                            </div>
                            <button type="submit" class="btn">Add to Cart</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection