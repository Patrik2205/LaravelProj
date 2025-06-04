@extends('layouts.app')

@section('title', 'All Products')

@push('styles')
<style>
    .search-bar {
        background-color: #fff;
        padding: 2rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .search-form {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: end;
    }
    
    .search-form .form-group {
        flex: 1;
        min-width: 200px;
        margin-bottom: 0;
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
    
    .product-category {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
    
    .product-price {
        font-size: 1.25rem;
        color: #007bff;
        font-weight: bold;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
    <h1>All Products</h1>
    
    <div class="search-bar">
        <form method="GET" action="{{ route('products.index') }}" class="search-form">
            <div class="form-group">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Search products..." value="{{ request('search') }}">
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="sort">Sort by</label>
                <select name="sort" id="sort" class="form-control">
                    <option value="">Default</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                </select>
            </div>
            
            <button type="submit" class="btn">Search</button>
        </form>
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
                    <p class="product-category">{{ $product->category->name }}</p>
                    <p class="product-price">${{ number_format($product->price, 2) }}</p>
                    
                    @if($product->isInStock())
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="add-to-cart-form">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                   class="quantity-input" style="width: 60px; margin-right: 0.5rem;">
                            <button type="submit" class="btn btn-sm">Add to Cart</button>
                        </form>
                    @else
                        <p style="color: #dc3545;">Out of Stock</p>
                    @endif
                </div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
    
    <div style="margin-top: 2rem;">
        {{ $products->withQueryString()->links() }}
    </div>
@endsection