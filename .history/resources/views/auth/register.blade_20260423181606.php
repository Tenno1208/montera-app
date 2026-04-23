<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Daftar Akun</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Desain Mewah & Elemen Visual */
        body { 
            background: #0F0F0F; 
            color: white; 
            font-family: 'Segoe UI', sans-serif; 
            padding: 20px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0;
            overflow-x: hidden;
        }

        /* Dekorasi Background agar tidak sepi */
        .bg-glow {
            position: fixed;
            top: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(211, 47, 47, 0.15) 0%, rgba(15, 15, 15, 0) 70%);
            z-index: -1;
        }

        .bg-glow-bottom {
            position: fixed;
            bottom: -5%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(211, 47, 47, 0.1) 0%, rgba(15, 15, 15, 0) 70%);
            z-index: -1;
        }

        .register-box { 
            width: 100%; 
            max-width: 420px; 
            padding: 20px;
            position: relative;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-img {
            width: 70px;
            filter: drop-shadow(0 0 15px rgba(211, 47, 47, 0.4));
        }

        h2 { font-size: 2.2rem; font-weight: 900; margin-bottom: 10px; line-height: 1.1; letter-spacing: -1.5px; }
        p.subtitle { color: #555; font-size: 0.9rem; margin-bottom: 35px; font-weight: 500; }
        
        .input-group { margin-bottom: 18px; position: relative; }
        label { 
            font-size: 10px; 
            font-weight: 800; 
            color: #444; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            display: block; 
            margin-bottom: 8px; 
            margin-left: 5px; 
        }
        
        input { 
            width: 100%; 
            padding: 18px 18px 18px 45px; /* Space for icon */
            border-radius: 20px; 
            border: 1px solid #222; 
            background: #161616; 
            color: white; 
            outline: none; 
            box-sizing: border-box;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            bottom: 18px;
            color: #333;
            transition: 0.3s;
        }

        input:focus { 
            border-color: #D32F2F; 
            background: #1A1A1A;
            box-shadow: 0 0 20px rgba(211, 47, 47, 0.1); 
        }

        input:focus + i {
            color: #D32F2F;
        }
        
        .btn-register { 
            width: 100%; 
            padding: 20px; 
            border-radius: 22px; 
            border: none; 
            background: linear-gradient(135deg, #D32F2F 0%, #9B1C1C 100%);
            color: white; 
            font-weight: 900; 
            cursor: pointer; 
            margin-top: 15px; 
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.85rem;
            box-shadow: 0 10px 25px rgba(211, 47, 47, 0.3);
            transition: all 0.3s;
        }

        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 15px 30px rgba(211, 47, 47, 0.4); }
        .btn-register:active { transform: scale(0.98); }
        
        .footer-link { color: #555; text-decoration: none; font-size: 0.85rem; display: block; text-align: center; margin-top: 30px; font-weight: 600; }
        .footer-link span { color: #D32F2F; font-weight: 800; }

        /* Error Validation Styling */
        .alert-error {
            background: rgba(211, 47, 47, 0.1);
            border-left: 4px solid #D32F2F;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .error-list { list-style: none; padding: 0; margin: 0; }
        .error-item { color: #ff4d4d; font-size: 12px; font-weight: bold; margin-bottom: 2px; }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    <div class="bg-glow-bottom"></div>

    <div class="register-box">
        <div class="logo-container">
            <img src="{{ asset('img/logo-montera.png') }}" alt="Logo Montera" class="logo-img">
        </div>

        <h2>Gabung<br><span style="color: #D32F2F;">Montera</span></h2>
        <p class="subtitle">Satu akun untuk mengontrol seluruh kekayaan Anda secara eksklusif.</p>

        @if ($errors->any())
            <div class="alert-error">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li class="error-item"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="Masukkan nama" required value="{{ old('name') }}">
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="input-group">
                <label>Alamat Email</label>
                <input type="email" name="email" placeholder="email@montera.com" required value="{{ old('email') }}">
                <i class="fa-solid fa-envelope"></i>
            </div>

            <div class="input-group">
                <label>Kata Sandi</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="input-group">
                <label>Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                <i class="fa-solid fa-shield-check"></i>
            </div>

            <button type="submit" class="btn-register">Buat Akun Gratis</button>
            
            <a href="{{ route('login') }}" class="footer-link">Sudah memiliki akses? <span>MASUK</span></a>
        </form>
    </div>
</body>
</html>