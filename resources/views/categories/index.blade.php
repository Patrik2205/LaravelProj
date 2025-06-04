@extends('layouts.app')

@section('title', 'Categories')

@push('styles')
<style>
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .category-card {
        background: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .category-card h3 {
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .category-card p {
        color: #666;
        margin-bottom: 1rem;
    }
    
    .subcategories {
        margin-top: 1rem;
        padding-left: 1rem;
        border-left: 2px solid #e0e0e0;
    }
    
    .subcategory-link {
        display: block;
        padding: 0.25rem 0;
        color: #007bff;
        text-decoration: none;
    }
    
    .subcategory-link:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
    <h1>Product Categories</h1>
    
    <div class="categories-grid">
        @foreach($categories as $category)
            <div class="category-card">
                <h3>
                    <a href="{{ route('categories.show', $category) }}" style="color: inherit; text-decoration: none;">
                        {{ $category->name }}
                    </a>
                </h3>
                <p>{{ $category->description }}</p>
                
                @if($category->children->count() > 0)
                    <div class="subcategories">
                        <strong>Subcategories:</strong>
                        @foreach($category->children as $child)
                            <a href="{{ route('categories.show', $child) }}" class="subcategory-link">
                                → {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                
                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm" style="margin-top: 1rem;">
                    View Products
                </a>
            </div>
        @endforeach
    </div>
@endsection