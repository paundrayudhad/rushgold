<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rush Gold</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gold: #FFD700;
            --secondary-gold: #DAA520;
            --dark-bg: #1a1a1a;
            --darker-bg: #141414;
        }

        body {
            background-color: var(--dark-bg);
            color: #fff;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: var(--darker-bg);
            border: 1px solid var(--primary-gold);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255,215,0,0.1);
        }

        .btn-gold {
            background: linear-gradient(45deg, var(--primary-gold), var(--secondary-gold));
            border: none;
            color: #000;
            font-weight: bold;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
        }

        .btn-gold:hover {
            transform: scale(1.02);
            box-shadow: 0 0 15px var(--primary-gold);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center" style="color: var(--primary-gold)">
                <i class="fas fa-dragon me-2"></i>Login
            </h2>

            @if ($errors->has('loginError'))
                <div class="alert alert-danger">
                    {{ $errors->first('loginError') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" required class="form-control">
                </div>
                <button type="submit" class="btn btn-gold">Login</button>
            </form>

            <div class="text-center mt-3">
                Don't have an account? <a href="{{ url('/register') }}" style="color: var(--primary-gold);">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>
