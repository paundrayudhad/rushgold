@extends('layouts.app')

@section('title', 'Welcome to Rush Gold')

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title mb-4">Welcome to Rush Gold</h1>
                <p class="lead text-light mb-4">Your trusted source for WoW Gold, Accounts, and Services</p>
                <a href="{{ url('/shop') }}" class="btn btn-gold btn-lg">Start Shopping</a>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--primary-gold);">Our Categories</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="category-card p-4 text-center">
                        <i class="fas fa-coins fa-3x mb-3" style="color: var(--primary-gold);"></i>
                        <h3>WoW Gold Coin</h3>
                        <p>Buy and sell WoW Gold safely and securely</p>
                        <a href="{{ url('/shop?category=gold') }}" class="btn btn-gold">View Gold</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card p-4 text-center">
                        <i class="fas fa-user-shield fa-3x mb-3" style="color: var(--primary-gold);"></i>
                        <h3>Accounts</h3>
                        <p>Premium WoW accounts with rare mounts and achievements</p>
                        <a href="{{ url('/shop?category=accounts') }}" class="btn btn-gold">View Accounts</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card p-4 text-center">
                        <i class="fas fa-magic fa-3x mb-3" style="color: var(--primary-gold);"></i>
                        <h3>Services</h3>
                        <p>Professional boosting and leveling services</p>
                        <a href="{{ url('/shop?category=services') }}" class="btn btn-gold">View Services</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
