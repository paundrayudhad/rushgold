@extends('layouts.app')

@section('title', 'Profile - Rush Gold')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-md-4">
            <div class="profile-container p-4 border rounded bg-dark text-white">
                <div class="text-center mb-4">
                    <div class="profile-avatar mx-auto mb-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4 class="text-warning">{{ $user->username }}</h4>
                </div>
                <div class="profile-info mb-4 p-3 border rounded">
                    <h5 class="text-warning mb-3"><i class="fas fa-info-circle me-2"></i>Profile Information</h5>
                    <p><i class="fas fa-envelope me-2"></i>{{ $user->email }}</p>
                    <p><i class="fas fa-calendar-alt me-2"></i>Joined: {{ $user->created_at->format('F j, Y') }}</p>
                    <p><i class="fas fa-shopping-bag me-2"></i>Total Orders: {{ $orders->total() }}</p>
                    <p><i class="fas fa-dollar-sign me-2"></i>Total Spent: ${{ number_format($total_spent, 2) }}</p>
                </div>

                <!-- Profile Update Form -->
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @error('current_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label for="email" class="form-label text-warning">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="current_password" class="form-label text-warning">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" autocomplete="current-password">
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label text-warning">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label text-warning">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-warning w-100">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Order History -->
        <div class="col-md-8">
            <h4 class="mb-4 text-warning"><i class="fas fa-history me-2"></i>Order History</h4>

            @if($orders->isEmpty())
                <p class="text-center text-white">No orders found.</p>
            @else
                @foreach($orders as $order)
                    <div class="order-card mb-3 p-3 border rounded bg-dark text-white">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <p class="mb-0">{{ $order->order_number }}</p>
                                <small>{{ $order->created_at->format('M j, Y') }}</small>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                            <div class="col-md-3">
                                <span class="badge
                                    {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('order.details', $order->order_number) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $orders->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    :root {
        --primary-gold: #FFD700;
        --secondary-gold: #DAA520;
    }
    body {
        background-color: #1a1a1a;
        color: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        background-color: var(--primary-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2.5rem;
        color: #000;
    }
    .order-card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>
@endsection
