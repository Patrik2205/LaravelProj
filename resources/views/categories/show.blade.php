@extends('layouts.app')

@section('title', $category->name)

@push('styles')
<style>
    .category-header {
        background-color: #fff;
        padding: 2rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .breadcrumb {
        margin-bottom: 1rem;
        color: #666;
    }
    
    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }
    
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    
    .subcategories-section {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .subcategories-section h3 {
        margin-bottom: 1rem;
        color: #333;
    }
    
    .subcategories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .subcategory-card {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
        text-align: center;
    }
    
    .subcategory-card:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .subcategory-card a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        display: block;
    }
    
    .subcategory-card a:hover {
        color: #007bff;
    }
    
    .sort-controls {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 2rem;
        gap: 1rem;
        align-items: center;
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    
    .product-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background-color: #f0f0f0;
    }
    
    .product-info {
        padding: 1rem;
    }
    
    .product-name {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .product-price {
        font-size: 1.25rem;
        color: #007bff;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    
    .add-to-cart-form {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .quantity-input {
        width: 60px;
        padding: 0.25rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
    <div class="category-header">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a> /
            @if($category->parent)
                <a href="{{ route('categories.show', $category->parent) }}">{{ $category->parent->name }}</a> /
            @endif
            {{ $category->name }}
        </div>
        <h1>{{ $category->name }}</h1>
        @if($category->description)
            <p>{{ $category->description }}</p>
        @endif
    </div>
    
    @if($category->children->count() > 0)
        <div class="subcategories-section">
            <h3>Subcategories</h3>
            <div class="subcategories-grid">
                @foreach($category->children as $subcategory)
                    <div class="subcategory-card">
                        <a href="{{ route('categories.show', $subcategory) }}">
                            {{ $subcategory->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <div class="sort-controls">
        <label for="sort">Sort by:</label>
        <select id="sort" onchange="window.location.href='?sort=' + this.value" class="form-control" style="width: auto;">
            <option value="">Default</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
        </select>
    </div>
    
    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image" style="display: flex; align-items: center; justify-content: center; color: #999;">
                        No Image
                    </div>
                @endif
                
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="{{ route('products.show', $product) }}" style="color: inherit; text-decoration: none;">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="product-price">${{ number_format($product->price, 2) }}</p>
                    
                    @if($product->isInStock())
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="add-to-cart-form">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="quantity-input">
                            <button type="submit" class="btn btn-sm">Add to Cart</button>
                        </form>
                    @else
                        <p style="color: #dc3545;">Out of Stock</p>
                    @endif
                </div>
            </div>
        @empty
            <p>No products found in this category.</p>
        @endforelse
    </div>
    
    <div style="margin-top: 2rem;">
        {{ $products->links() }}
    </div>
@endsection