@extends('layouts.app')

@section('title', 'Order Details - Rush Gold')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="order-details-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 style="color: var(--primary-gold);">
                        <i class="fas fa-receipt me-2"></i>Order Details
                    </h4>
                    <a href="{{ route('profile') }}" class="btn btn-gold">
                        <i class="fas fa-arrow-left me-2"></i>Back to Profile
                    </a>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Order Number:</strong></p>
                        <p class="mb-0">{{ $order->order_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Order Status:</strong></p>
                        <span class="status-badge {{ $order->status == 'completed' ? 'status-completed' : 'status-pending' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Order Date:</strong></p>
                        <p class="mb-0">{{ $order->created_at->format('F j, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Payment Method:</strong></p>
                        <p class="mb-0">
                            @if ($order->payment_method == 'paypal')
                                <i class="fab fa-paypal me-2"></i>PayPal
                            @else
                                <i class="fab fa-bitcoin me-2"></i>Cryptocurrency
                            @endif
                        </p>
                    </div>
                </div>

                @if ($order->game_nickname)
                <div class="row mb-4">
                    <div class="col-12">
                        <p class="mb-2"><strong>Game Nickname/Character Name:</strong></p>
                        <p class="mb-0">{{ $order->game_nickname }}</p>
                    </div>
                </div>
                @endif

                {{-- @if ($order->status == 'pending')
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-dark border-gold">
                            <div class="card-body" style="display: none;">
                                <h5 class="card-title" style="color: var(--primary-gold);">
                                    <i class="fas fa-upload me-2"></i>Upload Proof of Payment
                                </h5>
                                <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="mb-3">
                                        <label for="transaction_proof" class="form-label text-white">Transaction Proof (or) Tx ID</label>
                                        <input type="text" class="form-control bg-dark text-light border-gold"
                                               id="transaction_proof" name="transaction_proof"
                                               placeholder="Enter transaction ID or reference number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment_proof" class="form-label text-white">Payment Screenshot</label>
                                        <input type="file" class="form-control bg-dark text-light border-gold"
                                               id="payment_proof" name="payment_proof"
                                               accept="image/*" required>
                                        <small class="text-muted">Upload a screenshot of your payment confirmation (JPG, PNG, or GIF)</small>
                                    </div>
                                    <button type="submit" class="btn btn-gold">
                                        <i class="fas fa-upload me-2"></i>Submit Proof
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}

                @if ($order->payment_proof)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-dark border-gold">
                            <div class="card-body">
                                <h5 class="card-title" style="color: var(--primary-gold);">
                                    <i class="fas fa-check-circle me-2"></i>Payment Proof Submitted
                                </h5>
                                <p class="mb-2 text-white"><strong>Transaction Proof:</strong> {{ $order->transaction_proof }}</p>
                                <p class="mb-2 text-white"><strong>Submitted on:</strong> {{ $order->payment_proof_date->format('F j, Y H:i') }}</p>
                                <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                     alt="Payment Proof" class="img-fluid rounded mt-2"
                                     style="max-height: 300px;">
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <h5 class="mb-3" style="color: var(--primary-gold);">Order Items</h5>
                @foreach ($order->orderItems as $item)
                    <div class="order-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="product-image img-fluid">
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <p class="mb-0 text-white">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <p class="mb-0">${{ number_format($item->price, 2) }} each</p>
                                <p class="mb-0 text-gold">${{ number_format($item->price * $item->quantity, 2) }} total</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-end mt-4">
                    <h5>Total Amount: <span style="color: var(--primary-gold);">${{ number_format($order->total_amount, 2) }}</span></h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
