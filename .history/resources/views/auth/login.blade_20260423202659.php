<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Masuk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: #080808; 
            color: white; 
            font-family: 'Inter', 'Segoe UI', sans-serif; 
            margin: 0; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Elemen Background Glow Mewah */
        .bg-glow {
            position: absolute;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(211, 47, 47, 0.12) 0%, transparent 70%);
            z-index: 0;
            filter: blur(60px);
            animation: pulse 10s infinite alternate;
        }
        .glow-top { top: -100px; left: -100px; }
        .glow-bottom { bottom: -100px; right: -100px; }

        @keyframes pulse {
            from { transform: scale(1); opacity: 0.4; }
            to { transform: scale(1.3); opacity: 0.7; }
        }

        /* Tombol Kembali ke Landing Page */
        .btn-back {
            position: absolute;
            top: 30px;
            left: 30px;
            color: #555;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.3s;
            z-index: 100;
        }
        .btn-back:hover { color: #D32F2F; transform: translateX(-5px); }

        .login-box { 
            width: 100%; 
            max-width: 400px; 
            padding: 20px; 
            position: relative; 
            z-index: 10;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .logo-header { text-align: center; margin-bottom: 30px; }
        .logo-img { 
            width: 75px; 
            filter: drop-shadow(0 0 20px rgba(211, 47, 47, 0.4)); 
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        h2 { font-size: 2.5rem; font-weight: 900; margin-bottom: 35px; line-height: 1; letter-spacing: -2px; text-align: center; }
        .montera-text { 
            background: linear-gradient(to bottom, #D32F2F, #7B1111);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            padding: 15px;
            border-radius: 20px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #22c55e;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .input-group { margin-bottom: 22px; position: relative; }
        label { font-size: 10px; font-weight: 800; color: #444; letter-spacing: 2px; display: block; margin-bottom: 10px; margin-left: 5px; text-transform: uppercase; }
        
        .input-wrapper { position: relative; width: 100%; }

        input { 
            width: 100%; padding: 18px 55px 18px 55px; border-radius: 22px; border: 1px solid #222; 
            background: rgba(255, 255, 255, 0.03); color: white; outline: none; box-sizing: border-box;
            transition: 0.3s; font-size: 0.95rem; backdrop-filter: blur(10px);
        }
        
        .input-wrapper i.main-icon { 
            position: absolute; left: 20px; top: 50%; transform: translateY(-50%); 
            color: #333; transition: 0.3s; font-size: 1.1rem; pointer-events: none;
        }

        .toggle-password {
            position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
            color: #333; cursor: pointer; transition: 0.3s; font-size: 1rem;
        }
        .toggle-password:hover { color: #D32F2F; }
        
        input:focus { border-color: #D32F2F; background: rgba(255, 255, 255, 0.07); box-shadow: 0 0 25px rgba(211, 47, 47, 0.15); }
        input:focus + i.main-icon { color: #D32F2F; }

        .error-message { color: #ff4d4d; font-size: 11px; font-weight: bold; margin-top: 8px; display: flex; align-items: center; gap: 6px; padding-left: 5px; }

        .btn-login { 
            width: 100%; padding: 22px; border-radius: 25px; border: none; 
            background: linear-gradient(135deg, #D32F2F 0%, #7B1111 100%);
            color: white; font-weight: 900; cursor: pointer; 
            margin-top: 20px; transition: 0.4s; letter-spacing: 2px; text-transform: uppercase;
            box-shadow: 0 15px 35px rgba(211, 47, 47, 0.3);
            font-size: 0.9rem;
        }
        .btn-login:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(211, 47, 47, 0.5); }
        .btn-login:active { transform: scale(0.97); }
        
        .footer-link { color: #555; text-decoration: none; font-size: 0.85rem; display: block; text-align: center; margin-top: 35px; font-weight: 600; }
        .footer-link span { color: #D32F2F; font-weight: 800; transition: 0.3s; }
        .footer-link:hover span { letter-spacing: 1px; }
    </style>
</head>
<body>
    <div class="bg-glow glow-top"></div>
    <div class="bg-glow glow-bottom"></div>

    <a href="/" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Beranda</span>
    </a>

    <div class="login-box">
        <div class="logo-header">
            <img src="{{ asset('img/logo-montera.png') }}" alt="Logo" class="logo-img">
        </div>

        <h2>Welcome to<br><span class="montera-text">MONTERA</span></h2>

        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label>Access Email</label>
                <div class="input-wrapper">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@eksklusif.com" required>
                    <i class="fa-solid fa-envelope main-icon"></i>
                </div>
                @error('email')
                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label>Security Key</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="login_pass" placeholder="••••••••" required>
                    <i class="fa-solid fa-lock main-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" onclick="toggleLoginPass('login_pass', this)"></i>
                </div>
                @error('password')
                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">Unlock Account</button>
            
            <a href="{{ route('register') }}" class="footer-link">Belum menjadi member? <span>DAFTAR SEKARANG</span></a>
        </form>
    </div>

    <script>
        function toggleLoginPass(id, icon) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                icon.style.color = "#D32F2F";
            } else {
                input.type = "password";
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                icon.style.color = "#333";
            }
        }
    </script>
</body>
</html>