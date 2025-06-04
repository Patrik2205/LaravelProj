@extends('layouts.app')

@section('title', 'Create Category')

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
            <h1>Create New Category</h1>
        </div>
        
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Category Name *</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name') }}" required>
                @error('name')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3" 
                          class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="parent_id">Parent Category</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">None (Top Level)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <small style="color: #dc3545;">{{ $message }}</small>
                @enderror
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn">Create Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection