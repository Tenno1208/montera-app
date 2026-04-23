<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Daftar Akun</title>
    <style>
        /* Desain konsisten dengan tema Montera */
        body { background: #0F0F0F; color: white; font-family: 'Segoe UI', sans-serif; padding: 40px; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .register-box { width: 100%; max-width: 400px; }
        h2 { font-size: 2rem; font-weight: 900; margin-bottom: 10px; line-height: 1.2; }
        p.subtitle { color: #555; font-size: 0.9rem; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        label { font-size: 10px; font-weight: bold; color: #444; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px; margin-left: 5px; }
        
        input { 
            width: 100%; 
            padding: 18px; 
            border-radius: 18px; 
            border: 1px solid #222; 
            background: #1A1A1A; 
            color: white; 
            outline: none; 
            box-sizing: border-box;
            transition: 0.3s;
        }
        input:focus { border-color: #D32F2F; box-shadow: 0 0 15px rgba(211, 47, 47, 0.1); }
        
        .btn-register { 
            width: 100%; 
            padding: 20px; 
            border-radius: 20px; 
            border: none; 
            background: #D32F2F; 
            color: white; 
            font-weight: 900; 
            cursor: pointer; 
            margin-top: 15px; 
            letter-spacing: 1px;
            transition: 0.3s;
        }
        .btn-register:active { transform: scale(0.98); opacity: 0.9; }
        
        .footer-link { color: #555; text-decoration: none; font-size: 0.8rem; display: block; text-align: center; margin-top: 25px; font-weight: bold; }
        .footer-link span { color: #D32F2F; }

        /* Error handling sederhana */
        .error-msg { color: #ff4d4d; font-size: 12px; margin-top: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Buat Akun<br><span style="color: #D32F2F;">Baru Anda</span></h2>
        <p class="subtitle">Mulailah langkah pertama menuju kebebasan finansial yang terukur.</p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="Contoh: Nama Saya" required value="{{ old('name') }}">
            </div>

            <div class="input-group">
                <label>Alamat Email</label>
                <input type="email" name="email" placeholder="email@anda.com" required value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <label>Kata Sandi</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="input-group">
                <label>Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-register shadow-lg">DAFTAR SEKARANG</button>
            
            <a href="{{ route('login') }}" class="footer-link">Sudah punya akun? <span>Masuk di sini</span></a>
        </form>
    </div>
</body>
</html>