<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Rush Gold - Buy & Sell Gold, Accounts & Services')</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />

    <style>
        :root {
            --primary-gold: #ffd700;
            --secondary-gold: #daa520;
            --dark-bg: #1a1a1a;
            --darker-bg: #141414;
        }

        /* FLEXBOX LAYOUT UNTUK FOOTER STICKY */
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background-color: var(--dark-bg);
            color: #fff;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body > main {
            flex: 1 0 auto; /* Isi utama tumbuh dan ambil ruang tersisa */
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

        .nav-link:hover {
            color: var(--primary-gold) !important;
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

        .btn-gold:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px var(--primary-gold);
        }

        .footer {
            flex-shrink: 0; /* jangan dikecilkan */
            background-color: var(--darker-bg);
            border-top: 2px solid var(--primary-gold);
            padding: 2rem 0;
        }
    </style>
    @stack("styles")
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-dragon me-2"></i>Rush Gold
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
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
                            ><i class="fas fa-shopping-cart"></i> Cart</a
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
    <main>
        @yield("content")
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 style="color: var(--primary-gold)">About Us</h5>
                    <p>Your trusted marketplace for World of Warcraft items and services.</p>
                </div>
                <div class="col-md-4">
                    <h5 style="color: var(--primary-gold)">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/about') }}" class="text-light">About Us</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-light">Contact</a></li>
                        <li><a href="{{ url('/terms') }}" class="text-light">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 style="color: var(--primary-gold)">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> support@wowmarketplace.com</li>
                        <li><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack("scripts")
</body>
</html>
