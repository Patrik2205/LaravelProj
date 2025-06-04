@extends('layouts.app')

@section('title', 'Manage Products')

@push('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .products-table {
        width: 100%;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .products-table th {
        background-color: #f8f9fa;
        padding: 1rem;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .products-table td {
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .products-table tr:hover {
        background-color: #f8f9fa;
    }
    
    .product-image-small {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .stock-low {
        color: #dc3545;
        font-weight: bold;
    }
    
    .stock-good {
        color: #28a745;
    }
</style>
@endpush

@section('content')
    <div class="admin-header">
        <h1>Manage Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn">Add New Product</a>
    </div>
    
    <table class="products-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="product-image-small">
                        @else
                            <div style="width: 50px; height: 50px; background: #f0f0f0; 
                                        display: flex; align-items: center; justify-content: center; 
                                        border-radius: 4px; color: #999; font-size: 0.8rem;">
                                No Image
                            </div>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        <span class="{{ $product->stock < 10 ? 'stock-low' : 'stock-good' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this product?');" 
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem;">
        {{ $products->links() }}
    </div>
@endsection