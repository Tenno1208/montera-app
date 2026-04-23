<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Masuk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Desain Mewah & Elemen Visual */
        body { 
            background: #0F0F0F; 
            color: white; 
            font-family: 'Segoe UI', sans-serif; 
            margin: 0; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            overflow: hidden;
        }

        /* Dekorasi Glow agar ramai */
        .bg-glow-top {
            position: fixed;
            top: -15%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(211, 47, 47, 0.12) 0%, rgba(15, 15, 15, 0) 70%);
            z-index: -1;
        }

        .bg-glow-bottom {
            position: fixed;
            bottom: -10%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(211, 47, 47, 0.08) 0%, rgba(15, 15, 15, 0) 70%);
            z-index: -1;
        }

        .login-box { width: 100%; max-width: 400px; padding: 20px; position: relative; }
        
        /* Logo Section */
        .logo-header { text-align: center; margin-bottom: 30px; }
        .logo-img { width: 65px; filter: drop-shadow(0 0 10px rgba(211, 47, 47, 0.3)); }

        h2 { font-size: 2.2rem; font-weight: 900; margin-bottom: 30px; line-height: 1.1; letter-spacing: -1.5px; text-align: left; }
        .montera-text { color: #D32F2F; }

        /* Alert Sukses Registrasi */
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid #22c55e;
            padding: 15px;
            border-radius: 18px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #22c55e;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Form Styling */
        .input-group { margin-bottom: 22px; position: relative; }
        label { font-size: 10px; font-weight: 800; color: #444; letter-spacing: 1.5px; display: block; margin-bottom: 10px; margin-left: 5px; text-transform: uppercase; }
        
        input { 
            width: 100%; padding: 18px 20px 18px 50px; border-radius: 20px; border: 1px solid #222; 
            background: #161616; color: white; outline: none; box-sizing: border-box;
            transition: 0.3s; font-size: 0.95rem;
        }
        
        .input-group i { position: absolute; left: 20px; bottom: 18px; color: #333; transition: 0.3s; font-size: 1.1rem; }
        input:focus { border-color: #D32F2F; background: #1A1A1A; box-shadow: 0 0 20px rgba(211, 47, 47, 0.1); }
        input:focus + i { color: #D32F2F; }

        /* Error Messaging */
        .error-message { color: #ff4d4d; font-size: 11px; font-weight: bold; margin-top: 8px; display: flex; align-items: center; gap: 6px; padding-left: 5px; }

        /* Tombol */
        .btn-login { 
            width: 100%; padding: 20px; border-radius: 20px; border: none; 
            background: linear-gradient(135deg, #D32F2F 0%, #9B1C1C 100%);
            color: white; font-weight: 900; cursor: pointer; 
            margin-top: 15px; transition: 0.3s; letter-spacing: 1.5px; text-transform: uppercase;
            box-shadow: 0 10px 25px rgba(211, 47, 47, 0.3);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 15px 30px rgba(211, 47, 47, 0.4); }
        .btn-login:active { transform: scale(0.97); }
        
        .footer-link { color: #555; text-decoration: none; font-size: 0.85rem; display: block; text-align: center; margin-top: 30px; font-weight: 600; }
        .footer-link span { color: #D32F2F; font-weight: 800; }
    </style>
</head>
<body>
    <div class="bg-glow-top"></div>
    <div class="bg-glow-bottom"></div>

    <div class="login-box">
        <div class="logo-header">
            <img src="{{ asset('img/logo-montera.png') }}" alt="Logo Montera" class="logo-img">
        </div>

        <h2>Masuk ke<br><span class="montera-text">Montera</span></h2>

        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('loginError'))
            <div style="background: rgba(211, 47, 47, 0.1); border-left: 4px solid #D32F2F; padding: 15px; border-radius: 15px; margin-bottom: 20px; font-size: 12px; color: #ff4d4d; font-weight: bold;">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first('loginError') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label>Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                <i class="fa-solid fa-envelope"></i>
                @error('email')
                    <div class="error-message">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
                <i class="fa-solid fa-lock"></i>
                @error('password')
                    <div class="error-message">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-login">Masuk Sekarang</button>
            <a href="{{ route('register') }}" class="footer-link">Belum punya akun? <span>DAFTAR GRATIS</span></a>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>