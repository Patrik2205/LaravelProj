@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #2563eb;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 1rem;
    }
    
    .admin-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 3rem;
    }
    
    .action-btn {
        display: block;
        background: #2563eb;
        color: white;
        padding: 1rem 1.5rem;
        text-decoration: none;
        border-radius: 8px;
        text-align: center;
        font-weight: bold;
        transition: background-color 0.2s;
    }
    
    .action-btn:hover {
        background: #1d4ed8;
        color: white;
    }
    
    .recent-orders {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    
    .orders-table th {
        padding: 0.75rem;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solid #e0e0e0;
        background-color: #f8f9fa;
    }
    
    .orders-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        font-size: 0.875rem;
        font-weight: bold;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-processing {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
@endpush

@section('content')
    <div class="admin-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}!</p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['products'] }}</div>
            <div class="stat-label">Products</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ $stats['categories'] }}</div>
            <div class="stat-label">Categories</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ $stats['orders'] }}</div>
            <div class="stat-label">Orders</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ $stats['users'] }}</div>
            <div class="stat-label">Users</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">${{ number_format($stats['revenue'], 2) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
    
    <div class="admin-actions">
        <a href="{{ route('admin.products.create') }}" class="action-btn">+ Add New Product</a>
        <a href="{{ route('admin.categories.create') }}" class="action-btn">+ Add New Category</a>
        <a href="{{ route('admin.categories.index') }}" class="action-btn">Manage Categories</a>
        <a href="{{ route('admin.orders.index') }}" class="action-btn">View All Orders</a>
        <a href="{{ route('admin.products.index') }}" class="action-btn">Manage Products</a>
    </div>
    
    <div class="recent-orders">
        <h2>Recent Orders</h2>
        
        @if($recentOrders->count() > 0)
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No orders yet.</p>
        @endif
    </div>
@endsection