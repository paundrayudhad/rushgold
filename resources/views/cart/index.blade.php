@extends('layouts.app')

@section('title', 'Your Cart - Rush Gold')

@section('content')
<div class="container mt-5 ">
    <h2 class="mb-4" style="color: var(--primary-gold);">Your Shopping Cart</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cart->isEmpty())
        <div class="alert alert-warning" role="alert">
            Your cart is empty. <a href="{{ route('shop') }}" class="text-decoration-none">Shop now!</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th width="120">Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr data-product-id="{{ $item->product->id }}">
                        <td class="text-start">
                            <img src="{{ asset('storage/'. $item->product->image_path) }}" alt="{{ $item->product->name }}" width="70" height="70" class="me-3 rounded" style="object-fit: cover;">
                            <strong>{{ $item->product->name }}</strong>
                        </td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td>
                            <input type="number" 
                                   class="quantity-input form-control text-center" 
                                   value="{{ $item->quantity }}" 
                                   min="1" 
                                   max="{{ $item->product->stock }}" 
                                   data-product-id="{{ $item->product->id }}" />
                        </td>
                        <td class="subtotal">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-remove" data-product-id="{{ $item->product->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Total: <span style="color: var(--primary-gold);" id="total-price">${{ number_format($totalPrice, 2) }}</span></h4>
        <a href="" class="btn btn-gold">
                    <i class="fas fa-credit-card me-1"></i> Proceed to Checkout
                </a>
        </div>
         
    @endif
</div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // CSRF token untuk fetch
            const csrfToken = '{{ csrf_token() }}';

            // Fungsi update quantity
            async function updateQuantity(productId, quantity) {
                try {
                    const response = await fetch("{{ route('cart.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantities: {
                                [productId]: quantity
                            }
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to update quantity');
                    }

                    const data = await response.json();

                    // Update subtotal dan total harga dari response
                    const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                    if (row) {
                        row.querySelector('.subtotal').textContent = '$' + data.itemSubtotal.toFixed(2);
                    }
                    document.getElementById('total-price').textContent = '$' + data.totalPrice.toFixed(2);

                } catch (error) {
                    alert(error.message);
                }
            }

            // Event listener quantity input change
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', (e) => {
                    const productId = e.target.getAttribute('data-product-id');
                    let quantity = parseInt(e.target.value);

                    if (quantity < 1) quantity = 1;
                    if (quantity > parseInt(e.target.max)) quantity = parseInt(e.target.max);
                    e.target.value = quantity;

                    updateQuantity(productId, quantity);
                });
            });

            // Fungsi hapus item
            async function removeItem(productId) {
                if (!confirm('Remove this item from cart?')) return;

                try {
                    const response = await fetch("{{ url('cart') }}/" + productId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to remove item');
                    }

                    const data = await response.json();

                    // Hapus baris dari tabel
                    const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                    if (row) {
                        row.remove();
                    }

                    // Update total harga
                    document.getElementById('total-price').textContent = '$' + data.totalPrice.toFixed(2);

                    // Jika cart kosong setelah hapus, tampilkan pesan kosong
                    if (data.cartIsEmpty) {
                        document.querySelector('.table-responsive').innerHTML = `
                            <div class="alert alert-warning" role="alert">
                                Your cart is empty. <a href="{{ route('shop') }}" class="text-decoration-none">Shop now!</a>
                            </div>
                        `;
                        document.getElementById('total-price').textContent = '$0.00';
                    }

                } catch (error) {
                    alert(error.message);
                }
            }

            // Event listener tombol remove
            document.querySelectorAll('.btn-remove').forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.getAttribute('data-product-id');
                    removeItem(productId);
                });
            });
        });
    </script>
@endsection
