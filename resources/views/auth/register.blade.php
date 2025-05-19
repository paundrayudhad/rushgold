<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rush Gold</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: var(--darker-bg);
            border: 1px solid var(--primary-gold);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255,215,0,0.1);
        }

        .register-title {
            color: var(--primary-gold);
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            background-color: var(--dark-bg);
            border: 1px solid var(--primary-gold);
            color: #fff;
        }

        .form-control:focus {
            background-color: var(--dark-bg);
            border-color: var(--primary-gold);
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255,215,0,0.25);
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

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: var(--primary-gold);
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2 class="register-title">
                <i class="fas fa-dragon me-2"></i>Register
            </h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.perform') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-gold">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
