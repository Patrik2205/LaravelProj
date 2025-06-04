@extends('layouts.app')

@section('title', 'Order Successful')

@push('styles')
<style>
    .success-container {
        background-color: #fff;
        border-radius: 8px;
        padding: 3rem;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .success-icon {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .order-details {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 2rem;
        margin: 2rem 0;
        text-align: left;
    }
    
    .order-details h3 {
        margin-bottom: 1rem;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e0e0e0;
    }
</style>
@endpush

@section('content')
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for your order. We've received your order and will process it soon.</p>
        
        <div class="order-details">
            <h3>Order Details</h3>
            <div class="detail-row">
                <span>Order Number:</span>
                <strong>#{{ $order->id }}</strong>
            </div>
            <div class="detail-row">
                <span>Date:</span>
                <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
            </div>
            <div class="detail-row">
                <span>Total:</span>
                <strong>${{ number_format($order->total, 2) }}</strong>
            </div>
            <div class="detail-row">
                <span>Status:</span>
                <span style="color: #ffc107;">{{ ucfirst($order->status) }}</span>
            </div>
        </div>
        
        <a href="{{ route('home') }}" class="btn">Continue Shopping</a>
    </div>
@endsection