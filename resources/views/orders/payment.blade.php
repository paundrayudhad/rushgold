@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-warning">
        <i class="fas fa-credit-card me-2"></i>Payment
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="p-4 border border-warning rounded bg-dark text-white">
                <h4>Payment Details</h4>

                <div class="mb-4 text-center">
                    @if ($order->payment_method === 'paypal')
                        <i class="fab fa-paypal fa-2x text-warning"></i>
                        <p class="mt-2">PayPal Payment: <strong>payments@wowmarketplace.com</strong></p>
                    @else
                        <i class="fab fa-bitcoin fa-2x text-warning"></i>
                        <p class="mt-2">Crypto Payment: <strong>1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa</strong></p>
                    @endif
                </div>

                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_proof">Upload Payment Proof</label>
                        <input type="file" name="payment_proof" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="transaction_proof">Transaction ID/Reference</label>
                        <input type="text" name="transaction_proof" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-upload me-2"></i>Submit Payment Proof
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 border border-warning rounded bg-dark text-white">
                <h4>Order Summary</h4>
                <p>Order Number: <strong>{{ $order->order_number }}</strong></p>
                <p>Date: {{ $order->created_at->format('M d, Y H:i') }}</p>
                <hr>

                @foreach ($order->orderItems as $item)
                    <div class="mb-3">
                        <strong>{{ $item->product->name }}</strong><br>
                        Quantity: {{ $item->quantity }}<br>
                        Price: ${{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                @endforeach

                <hr>
                <h5>Total: ${{ number_format($order->total_amount, 2) }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
