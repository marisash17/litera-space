<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraSpace - Lupa Password</title>
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
            background: linear-gradient(135deg, #ffffff, #fbefe3);
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
            object-fit: cover;
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
            color: #80964d;
            margin-bottom: 8px;
            text-align: center;
        }

        .subtitle {
            color: #80964d;
            margin-bottom: 30px;
            font-size: 15px;
            text-align: center;
        }

        .info-text {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
            text-align: center;
            line-height: 1.6;
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
            border-color: #80964d;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(128, 150, 77, 0.1);
        }

        input.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #fbefe3, #fbefe3);
            color: #80964d;
            border: 2px solid #80964d;
            border-radius: 10px;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(128, 150, 77, 0.2);
            width: 100%;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(128, 150, 77, 0.3);
            background: #80964d;
            color: white;
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .auth-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .auth-link a {
            color: #80964d;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .auth-link a:hover {
            color: #e09c08;
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .errors {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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
            <h2>Lupa Password?</h2>
            <p>Jangan khawatir, kami akan mengirimkan link reset ke email Anda</p>
        </div>
        
        <div class="form-section">
            <div class="logo">LiteraSpace</div>
            <h1>Reset Password</h1>
            <p class="subtitle">Masukkan email Anda untuk mendapatkan link reset password</p>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="info-text">
                Lupa password Anda? Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimkan link reset password yang memungkinkan Anda memilih password baru.
            </div>
            
            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="masukkan email Anda" required autofocus
                           class="{{ $errors->has('email') ? 'error' : '' }}">
                </div>

                <button type="submit" class="btn-primary" id="submitBtn">
                    <span id="btnText">Kirim Link Reset Password</span>
                    <div class="loading" id="loadingSpinner" style="display: none;"></div>
                </button>
                
                <div class="auth-link">
                    Ingat password Anda? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            // Disable button dan show loading
            submitBtn.disabled = true;
            btnText.textContent = 'Mengirim...';
            loadingSpinner.style.display = 'inline-block';
        });

        // Tambah class error pada input yang invalid
        const emailInput = document.getElementById('email');
        if (emailInput.classList.contains('error')) {
            emailInput.focus();
        }
    </script>
</body>
</html>