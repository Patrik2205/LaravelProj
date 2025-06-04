@extends('layouts.app')

@section('title', 'Create Product')

@push('styles')
<style>
    .form-container {
        background-color: #fff;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        max-width: 800px;
    }
    
    .form-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .form-group-full {
        grid-column: 1 / -1;
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <div class="form-container">
        <div class="form-header">
            <h1>Create New Product</h1>
        </div>
        
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Product Name *</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="sku">SKU *</label>
                    <input type="text" name="sku" id="sku" class="form-control" 
                           value="{{ old('sku') }}" required>
                    @error('sku')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group form-group-full">
                    <label for="description">Description *</label>
                    <textarea name="description" id="description" rows="4" 
                              class="form-control" required>{{ old('description') }}</textarea>
                    @error('description')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="price">Price *</label>
                    <input type="number" name="price" id="price" class="form-control" 
                           step="0.01" min="0" value="{{ old('price') }}" required>
                    @error('price')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="stock">Stock Quantity *</label>
                    <input type="number" name="stock" id="stock" class="form-control" 
                           min="0" value="{{ old('stock', 0) }}" required>
                    @error('stock')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                                @if($category->parent)
                                    ({{ $category->parent->name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @error('image')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                    <small style="color: #666;">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn">Create Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection