@extends('layouts.app')

@section('content')
<div class="container">
    <div class="checkout-container">
        <h2 class="mb-4 text-center text-warning">Checkout</h2>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            {{-- Payment Method as Cards --}}
            <div class="mb-4">
                <label class="form-label">Payment Method</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="payment-method" onclick="selectPayment('paypal')">
                            <input type="radio" name="payment_method" value="paypal" id="paypal" class="d-none" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                            <div class="text-center">
                                <i class="fab fa-paypal payment-icon fa-3x"></i>
                                <h5 class="mt-2">PayPal</h5>
                                <p class="small text-blue">Pay securely with PayPal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-method" onclick="selectPayment('crypto')">
                            <input type="radio" name="payment_method" value="crypto" id="crypto" class="d-none" {{ old('payment_method') == 'crypto' ? 'checked' : '' }}>
                            <div class="text-center">
                                <i class="fab fa-bitcoin payment-icon fa-3x"></i>
                                <h5 class="mt-2">Cryptocurrency</h5>
                                <p class="small text-gold">Pay with Bitcoin or other cryptocurrencies</p>
                            </div>
                        </div>
                    </div>
                </div>
                @error('payment_method')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Game Nickname --}}
            @if ($hasGoldProducts)
            <div class="mb-4">
                <label for="game_nickname" class="form-label">Game Nickname</label>
                <input type="text" name="game_nickname" id="game_nickname" class="form-control" value="{{ old('game_nickname') }}" required>
                @error('game_nickname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            @endif

            {{-- Total --}}
            <div class="mb-4">
                <label class="total-label">Total Payment</label>
                <div class="total-value">$ {{ number_format($total, 0, ',', '.') }}</div>
            </div>

            <button type="submit" class="btn btn-gold">Place Order</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .checkout-container {
        background-color: var(--darker-bg);
        border: 1px solid var(--primary-gold);
        border-radius: 10px;
        padding: 30px;
        margin-top: 30px;
    }
    .total-label {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--primary-gold);
    }
    .total-value {
        font-size: 1.5rem;
        color: #fff;
    }
    .payment-method {
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 10px;
        padding: 20px;
        transition: border-color 0.3s ease;
        background-color: #222;
    }
    .payment-method:hover {
        border-color: var(--primary-gold);
    }
    .payment-method.selected {
        border-color: var(--primary-gold);
        background-color: #333;
    }
    .payment-icon {
        color: #0070ba; /* PayPal blue by default */
    }
    .payment-method:nth-child(2) .payment-icon {
        color: #f7931a; /* Bitcoin orange */
    }
    .text-blue {
        color: #0070ba;
    }
    .text-gold {
        color: var(--primary-gold);
    }
</style>
@endpush

@push('scripts')
<script>
    function selectPayment(method) {
        // Remove selected class from all payment methods
        document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));

        // Add selected class to the clicked payment method
        const selectedMethod = document.querySelector(`input[value="${method}"]`).parentElement;
        selectedMethod.classList.add('selected');

        // Check the related radio button
        document.getElementById(method).checked = true;
    }

    // On page load, select old input if exists
    document.addEventListener('DOMContentLoaded', () => {
        const oldPayment = "{{ old('payment_method') }}";
        if (oldPayment) {
            selectPayment(oldPayment);
        }
    });
</script>
@endpush
