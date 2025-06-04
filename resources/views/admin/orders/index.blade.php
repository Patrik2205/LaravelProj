@extends('layouts.app')

@section('title', 'Manage Orders')

@push('styles')
<style>
    .admin-header {
        margin-bottom: 2rem;
    }
    
    .filters {
        background-color: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .filters form {
        display: flex;
        gap: 1rem;
        align-items: end;
        flex-wrap: wrap;
    }
    
    .orders-table {
        width: 100%;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .orders-table th {
        background-color: #f8f9fa;
        padding: 1rem;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .orders-table td {
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .orders-table tr:hover {
        background-color: #f8f9fa;
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
        <h1>Manage Orders</h1>
    </div>
    
    <div class="filters">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="status">Filter by Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All Orders</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-sm">Filter</button>
        </form>
    </div>
    
    <table class="orders-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">View Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                        No orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 2rem;">
        {{ $orders->withQueryString()->links() }}
    </div>
@endsection