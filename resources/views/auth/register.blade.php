<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraSpace - Daftar</title>
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
            background: linear-gradient(135deg, white, #fbefe3);
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

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: #f9f9f9;
            resize: vertical;
        }

        textarea {
            min-height: 80px;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: rgb(128, 150, 77);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(128, 150, 77, 0.1);
        }

        .input-with-icon {
            position: relative;
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

        .password-strength {
            height: 5px;
            background: #f1f1f1;
            border-radius: 5px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .terms {
            display: flex;
            align-items: flex-start;
            margin: 25px 0;
            font-size: 14px;
            color: #555;
        }

        .terms input {
            width: auto;
            margin-right: 10px;
            margin-top: 3px;
        }

        .terms label {
            margin-bottom: 0;
            line-height: 1.5;
            font-weight: normal;
        }

        .terms a {
            color: rgb(128, 150, 77);
            text-decoration: none;
        }

        .btn-register {
            background: linear-gradient(135deg, #fbefe3, #fbefe3);
            color: rgb(128, 150, 77);
            border: 2px solid rgb(128, 150, 77);
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(128, 150, 77, 0.3);
            background: rgb(128, 150, 77);
            color: white;
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

        .divider {
            height: 1px;
            background: #eee;
            margin: 25px 0;
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
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-section">
            <img src="{{ asset('images/literaspacelogo.png') }}" alt="LiteraSpace Illustration" onerror="this.src='https://cdn.pixabay.com/photo/2018/03/07/18/42/men-3205710_1280.png'">
            <h2>Bergabung dengan LiteraSpace</h2>
            <p>Buat akun dan akses koleksi buku digital terlengkap</p>
        </div>
        
        <div class="form-section">
            <div class="logo">LiteraSpace</div>
            <h1>Buat Akun Baru</h1>
            <p class="subtitle">Daftar untuk bergabung dengan komunitas kami</p>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Depan</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama depan" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Masukkan nama belakang" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@contoh.com" required>
                </div>

                <!-- TAMBAHAN: Field Nomor Telepon -->
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required>
                </div>

                <!-- TAMBAHAN: Field Alamat -->
                <div class="form-group">
                    <label for="address">Alamat Lengkap</label>
                    <textarea id="address" name="address" placeholder="Masukkan alamat lengkap Anda" required>{{ old('address') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-with-icon">
                        <input type="password" id="password" name="password" placeholder="Buat kata sandi" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">👁️</button>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="password-strength-bar"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-with-icon">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">👁️</button>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <div class="terms">
                    <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                    <label for="agreeTerms">
                        Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan 
                        <a href="#">Kebijakan Privasi</a> LiteraSpace
                    </label>
                </div>
                
                <button type="submit" class="btn-register">Daftar Sekarang</button>
                
                <div class="auth-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
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

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength-bar');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.backgroundColor = '#ff4d4d';
            } else if (strength < 75) {
                strengthBar.style.backgroundColor = '#ffa64d';
            } else {
                strengthBar.style.backgroundColor = '#4CAF50';
            }
        });

        // Validasi nomor telepon
        document.getElementById('phone').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    </script>
</body>
</html>