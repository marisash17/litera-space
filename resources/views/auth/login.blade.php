<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraSpace - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f6f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .image-section {
            flex: 1;
            background: linear-gradient(135deg, #fbefe3, white
            );
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #e09c08;
            text-align: center;
        }

        .image-section img {
            max-width: 280px;
            margin-bottom: 30px;
            border-radius: 10px;
        }

        .image-section h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .image-section p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .form-section {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            color: #e09c08;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .form-section h1 {
            font-size: 28px;
            color: rgb(128, 150, 77);
            margin-bottom: 8px;
            text-align: center;
        }

        .subtitle {
            color: rgb(128, 150, 77);
            margin-bottom: 30px;
            font-size: 15px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
            font-size: 14px;
        }

        .input-with-icon {
            position: relative;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }

        input:focus {
            outline: none;
            border-color: #795218;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgb(128, 150, 77);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #777;
            font-size: 16px;
        }

        .btn-login {
            background: linear-gradient(135deg, #fbefe3, #fbefe3);
            color: rgb(128, 150, 77);
            border: none;
            border-radius: 10px;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgb(128, 150, 77);
            width: 100%;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgb(128, 150, 77);
        }

        .auth-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .auth-link a {
            color: rgb(128, 150, 77);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: rgb(128, 150, 77);
            text-decoration: none;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .image-section {
                padding: 30px 20px;
            }
            
            .image-section img {
                max-width: 200px;
            }
            
            .form-section {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-section">
            <img src="{{ asset('images/literaspace-logo.png') }}" alt="LiteraSpace Illustration" onerror="this.src='https://cdn.pixabay.com/photo/2018/03/07/18/42/men-3205710_1280.png'">
            <h2>Selamat Datang di LiteraSpace</h2>
            <p>Jelajahi dunia literasi digital dengan koleksi buku terlengkap</p>
        </div>
        
        <div class="form-section">
            <div class="logo">LiteraSpace</div>
            <h1>Selamat Datang</h1>
            <p class="subtitle">Masuk untuk melanjutkan ke akun Anda</p>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" placeholder="admin@literaspace.com" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-with-icon">
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">👁️</button>
                    </div>
                </div>
                
                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                    @endif
                </div>
                
                <button type="submit" class="btn-login">Masuk</button>
                
                <div class="auth-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleButton = passwordField.parentNode.querySelector('.password-toggle');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = '🔒';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }
    </script>
</body>
</html>