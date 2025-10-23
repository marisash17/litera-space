<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'LiteraSpace') }}</title>

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                background: linear-gradient(135deg, #8EC5FC 0%, #E0C3FC 100%);
                font-family: 'Poppins', sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }

            .login-card {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
                transition: all 0.3s ease-in-out;
            }

            .login-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            }

            .logo {
                display: flex;
                justify-content: center;
                margin-bottom: 1.5rem;
            }

            .btn-login {
                background: linear-gradient(90deg, #8EC5FC 0%, #FFD580 100%);
                color: #222;
                font-weight: 600;
                border: none;
                border-radius: 10px;
                transition: all 0.3s ease;
            }

            .btn-login:hover {
                background: linear-gradient(90deg, #FFD580 0%, #8EC5FC 100%);
                transform: scale(1.03);
            }

            .link {
                color: #6B6B6B;
                font-size: 0.9rem;
                text-align: center;
                margin-top: 1rem;
            }

            .link a {
                color: #4A4A4A;
                text-decoration: none;
                font-weight: 500;
            }

            .link a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="login-card">
            <div class="logo">
                <img src="{{ asset('images/literaspace-logo.png') }}" alt="LiteraSpace" width="60">
            </div>
            {{ $slot }}
        </div>
    </body>
</html>
