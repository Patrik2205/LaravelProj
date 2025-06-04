@extends('layouts.app')

@section('title', 'Edit Category')

@push('styles')
<style>
    .form-container {
        background-color: #fff;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        max-width: 600px;
    }
    
    .form-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
    }
</style>
@endpush

@section('content')
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Category</h1>
        </div>
        
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Category Name *</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3" 
                          class="form-control">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="parent_id">Parent Category</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">None (Top Level)</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" 
                                {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection