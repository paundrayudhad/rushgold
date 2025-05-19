<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Title dengan keyword penting di depan -->
    <title>@yield('title', 'Rush Gold - Buy & Sell Gold, Accounts & Services | WoW Marketplace')</title>
    
    <!-- Meta Description untuk SEO -->
    <meta name="description" content="Rush Gold is your trusted marketplace for buying and selling World of Warcraft gold, accounts, and gaming services securely and fast." />
    
    <!-- Meta Keywords (optional, masih kadang dipakai walau sebagian mesin pencari mengabaikan) -->
    <meta name="keywords" content="Rush Gold, Buy Gold WoW, Sell WoW Gold, WoW Accounts, Gaming Services, WoW Marketplace" />
    
    <!-- Meta Author -->
    <meta name="author" content="Rush Gold Team" />
    
    <!-- Open Graph untuk social sharing -->
    <meta property="og:title" content="Rush Gold - Buy & Sell WoW Gold, Accounts & Services" />
    <meta property="og:description" content="Trusted WoW marketplace to buy and sell gold, accounts, and gaming services." />
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Rush Gold - Buy & Sell WoW Gold, Accounts & Services" />
    <meta name="twitter:description" content="Trusted WoW marketplace to buy and sell gold, accounts, and gaming services." />
    <meta name="twitter:image" content="{{ asset('images/twitter-card.jpg') }}" />

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        :root {
            --primary-gold: #ffd700;
            --secondary-gold: #daa520;
            --dark-bg: #1a1a1a;
            --darker-bg: #141414;
        }

        /* FLEXBOX LAYOUT UNTUK FOOTER STICKY */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background-color: var(--dark-bg);
            color: #fff;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body > main {
            flex: 1 0 auto;
        }

        .navbar {
            background-color: var(--darker-bg);
            border-bottom: 2px solid var(--primary-gold);
        }

        .navbar-brand {
            color: var(--primary-gold) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            color: #fff !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link:focus {
            color: var(--primary-gold) !important;
            outline: none;
        }

        .hero-section {
            background: linear-gradient(
                    rgba(0, 0, 0, 0.7),
                    rgba(0, 0, 0, 0.7)
                ),
                url("https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80");
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 0 1rem;
        }

        .hero-title {
            color: var(--primary-gold);
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 10px var(--primary-gold), 0 0 20px var(--primary-gold),
                    0 0 30px var(--primary-gold);
            }
            to {
                text-shadow: 0 0 20px var(--primary-gold), 0 0 30px var(--primary-gold),
                    0 0 40px var(--primary-gold);
            }
        }

        .category-card {
            background-color: var(--darker-bg);
            border: 1px solid var(--primary-gold);
            border-radius: 10px;
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        }

        .btn-gold {
            background: linear-gradient(45deg, var(--primary-gold), var(--secondary-gold));
            border: none;
            color: #000;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-gold:hover, .btn-gold:focus {
            transform: scale(1.05);
            box-shadow: 0 0 15px var(--primary-gold);
            outline: none;
        }

        .footer {
            flex-shrink: 0;
            background-color: var(--darker-bg);
            border-top: 2px solid var(--primary-gold);
            padding: 2rem 0;
        }
    </style>
    @stack("styles")
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" role="navigation" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" aria-label="Rush Gold homepage">
                <i class="fas fa-dragon me-2" aria-hidden="true"></i>Rush Gold
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/shop') }}">Shop</a></li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cart') }}"
                            ><i class="fas fa-shopping-cart" aria-hidden="true"></i> Cart</a
                        >
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/profile') }}">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}">Logout</a></li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main role="main">
        @yield("content")
    </main>

    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="row">
                <section class="col-md-4" aria-labelledby="aboutus-title">
                    <h5 id="aboutus-title" style="color: var(--primary-gold)">About Us</h5>
                    <p>Your trusted marketplace for World of Warcraft items and services.</p>
                </section>
                <nav class="col-md-4" aria-label="Quick links">
                    <h5 style="color: var(--primary-gold)">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/about') }}" class="text-light">About Us</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-light">Contact</a></li>
                        <li><a href="{{ url('/terms') }}" class="text-light">Terms & Conditions</a></li>
                    </ul>
                </nav>
                <section class="col-md-4" aria-labelledby="contactus-title">
                    <h5 id="contactus-title" style="color: var(--primary-gold)">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2" aria-hidden="true"></i> <a href="mailto:support@wowmarketplace.com" class="text-light">support@wowmarketplace.com</a></li>
                        <li><i class="fas fa-phone me-2" aria-hidden="true"></i> <a href="tel:+15551234567" class="text-light">+1 (555) 123-4567</a></li>
                    </ul>
                </section>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack("scripts")
</body>
</html>
