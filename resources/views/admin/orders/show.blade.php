@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@push('styles')
<style>
    .order-details {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    
    @media (max-width: 768px) {
        .order-details {
            grid-template-columns: 1fr;
        }
    }
    
    .detail-section {
        background-color: #fff;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .detail-section h2 {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-label {
        font-weight: bold;
        color: #666;
    }
    
    .items-table {
        width: 100%;
        margin-top: 1rem;
    }
    
    .items-table th {
        text-align: left;
        padding: 0.75rem;
        border-bottom: 2px solid #e0e0e0;
        background-color: #f8f9fa;
    }
    
    .items-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .status-update {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e0e0e0;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: bold;
        display: inline-block;
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
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">← Back to Orders</a>
    </div>
    
    <h1>Order #{{ $order->id }}</h1>
    
    <div class="order-details">
        <div>
            <div class="detail-section">
                <h2>Order Items</h2>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    {{ $item->product_name }}
                                    @if($item->product)
                                        <a href="{{ route('products.show', $item->product) }}" 
                                           target="_blank" style="color: #007bff; text-decoration: none;">
                                            →
                                        </a>
                                    @endif
                                </td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>
                            <td style="font-weight: bold;">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="detail-section">
                <h2>Customer Information</h2>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span>{{ $order->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span>{{ $order->email }}</span>
                </div>
                @if($order->phone)
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span>{{ $order->phone }}</span>
                    </div>
                @endif
                @if($order->address)
                    <div class="info-row">
                        <span class="info-label">Address:</span>
                        <span>{{ $order->address }}</span>
                    </div>
                @endif
                @if($order->user)
                    <div class="info-row">
                        <span class="info-label">Registered User:</span>
                        <span>Yes (ID: {{ $order->user_id }})</span>
                    </div>
                @endif
            </div>
        </div>
        
        <div>
            <div class="detail-section">
                <h2>Order Status</h2>
                <div style="text-align: center; margin-bottom: 1rem;">
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Updated:</span>
                    <span>{{ $order->updated_at->format('M d, Y H:i') }}</span>
                </div>
                
                <div class="status-update">
                    <h3>Update Status</h3>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection