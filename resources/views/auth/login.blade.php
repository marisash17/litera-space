<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LiteraSpace') }} - Login</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f6f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            display: flex;
            width: 900px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-image {
            background-color: white;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-image img {
            width: 90%;
            max-width: 380px;
        }

        .login-form {
            width: 50%;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
        }

        .login-form p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .form-control {
            background: #f1f1f1;
            border: none;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            width: 100%;
            outline: none;
            transition: 0.3s;
        }

        .form-control:focus {
            background: #e7e9ff;
            box-shadow: 0 0 0 2px #536dfe;
        }

        .btn-login {
            background: linear-gradient(135deg, #6c63ff, #a17ffb);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #7f74ff, #b19dfb);
        }

        .forgot {
            text-align: right;
            margin-bottom: 1rem;
        }

        .forgot a {
            font-size: 0.85rem;
            color: #6c63ff;
            text-decoration: none;
        }

        .forgot a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 95%;
            }
            .login-image {
                width: 100%;
                padding: 1.5rem;
            }
            .login-form {
                width: 100%;
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Left Side -->
    <div class="login-image">
        <img src="{{ asset('images/login-ilustration.png') }}" alt="Login Illustration">
    </div>

    <!-- Right Side (Form) -->
    <div class="login-form">
        <h2>Welcome 👋</h2>
        <p>Sign in to continue to <strong>LiteraSpace</strong></p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" class="form-control" placeholder="Email Address" required autofocus>
            <input type="password" name="password" class="form-control" placeholder="Password" required>

            <div class="forgot">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login w-full">Log In</button>
        </form>
    </div>
</div>

</body>
</html>
