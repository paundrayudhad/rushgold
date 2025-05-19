@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="text-gold text-center mb-4">Our Exclusive Collections</h1>
<div class="row">
     <!-- Categories Sidebar -->
        <div class="col-md-3">
            <div class="category-sidebar">
                <h4 class="mb-4" style="color: var(--primary-gold);">Categories</h4>
                <a href="{{ route('shop') }}" class="category-link {{ $category_id == 0 ? 'active' : '' }}">
                    All Products
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('shop.category', ['slug' => $category->slug]) }}"
                       class="category-link {{ $category_id == $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

    {{-- Produk --}}
    <div class="col-md-9">
        <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white h-100">
                    <div class="position-relative">
                        @if (!empty($product->faction))
                            <div class="position-absolute top-0 end-0 bg-dark bg-opacity-75 px-2 py-1 rounded-start" style="color: var(--primary-gold); z-index: 2;">
                                <i class="fas {{ $product->faction === 'Horde' ? 'fa-fire text-danger' : 'fa-shield-alt text-primary' }} me-1"></i>
                                {{ $product->faction }}
                            </div>
                        @endif
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top" alt="{{ $product->name }}" style="object-fit: cover; height: 250px;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-gold">{{ $product->name }}</h5>
                        <p class="text-white mb-1">{{ $product->category->name }}</p>
                        <p class="text-gold fw-bold mb-1">${{ number_format($product->price, 2) }}</p>
                        <p class="small text-white mb-2">{{ $product->description }}</p>
                        <p class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fas {{ $product->stock > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </p>

                        <div class="mt-auto">
                            @auth
                                @if($product->stock > 0)
                                    <form action="{{ route('addcart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-gold w-100">
                                            <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-times-circle me-2"></i>Out of Stock
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-gold w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Buy
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-white">No products found.</p>
        @endforelse
        </div>
    </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.querySelectorAll('form[action="{{ route('addcart') }}"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();  // cegah submit dulu agar animasi jalan

            const btn = this.querySelector('button[type="submit"]');
            btn.classList.add('added');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Added!';

            // Submit form setelah animasi selesai (misal 600ms)
            setTimeout(() => {
                this.submit();
            }, 600);
        });
    });
</script>
@endpush

@push('styles')
<style>
.product-card {
    background-color: var(--darker-bg);
    border: 1px solid var(--primary-gold);
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    margin-bottom: 1.5rem;
    color: #fff;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
}

.product-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-bottom: 1px solid var(--primary-gold);
}

.product-title {
    font-weight: bold;
    font-size: 1.25rem;
    color: var(--primary-gold);
    margin-bottom: 0.5rem;
}

.product-price {
    font-weight: bold;
    color: var(--primary-gold);
    margin-bottom: 0.5rem;
}

.category-link {
    display: inline-block;
    margin-right: 1rem;
    margin-bottom: 1rem;
    padding: 0.5rem 1rem;
    color: #fff;
    border: 1.5px solid var(--primary-gold);
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.category-link.active,
.category-link:hover {
    background-color: var(--primary-gold);
    color: #000;
}

.text-success {
    color: #28a745 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.btn-gold {
    background: linear-gradient(45deg, var(--primary-gold), var(--secondary-gold));
    border: none;
    color: #000;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-gold:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px var(--primary-gold);
}
@keyframes addedToCart {
  0% {
    transform: scale(1);
    background-color: linear-gradient(45deg, var(--primary-gold), var(--secondary-gold));
  }
  50% {
    transform: scale(1.1);
    background-color: #ffc107; /* warna kuning cerah */
    box-shadow: 0 0 15px var(--primary-gold);
  }
  100% {
    transform: scale(1);
    background-color: linear-gradient(45deg, var(--primary-gold), var(--secondary-gold));
  }
}

.btn-gold.added {
  animation: addedToCart 0.5s ease forwards;
}

</style>
@endpush
