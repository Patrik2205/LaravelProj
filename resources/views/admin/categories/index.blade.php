@extends('layouts.app')

@section('title', 'Manage Categories')

@push('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .categories-table {
        width: 100%;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .categories-table th {
        background-color: #f8f9fa;
        padding: 1rem;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .categories-table td {
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .categories-table tr:hover {
        background-color: #f8f9fa;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .parent-category {
        color: #666;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
    <div class="admin-header">
        <h1>Manage Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn">Add New Category</a>
    </div>
    
    <table class="categories-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent Category</th>
                <th>Products Count</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        @if($category->parent)
                            <span class="parent-category">{{ $category->parent->name }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $category->products_count ?? 0 }}</td>
                    <td>{{ $category->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this category?');" 
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
        {{ $categories->links() }}
    </div>
@endsection