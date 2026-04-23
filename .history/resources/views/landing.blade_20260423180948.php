<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Kelola Uang dengan Gaya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { margin: 0; background: #0F0F0F; color: white; font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; text-align: center; }
        .hero { padding: 40px; max-width: 450px; }
        .logo-big { width: 120px; margin-bottom: 20px; filter: drop-shadow(0 0 20px rgba(211, 47, 47, 0.4)); }
        h1 { font-size: 2.5rem; font-weight: 900; letter-spacing: -2px; margin-bottom: 10px; }
        p { color: #555; font-size: 0.9rem; margin-bottom: 40px; line-height: 1.5; }
        .btn { display: block; width: 100%; padding: 20px; border-radius: 20px; text-decoration: none; font-weight: bold; margin-bottom: 15px; transition: 0.3s; }
        .btn-red { background: #D32F2F; color: white; }
        .btn-outline { border: 1px solid #222; color: #aaa; background: #1A1A1A; }
        .btn:active { transform: scale(0.95); }
    </style>
</head>
<body>
    <div class="hero">
        <img src="{{ asset('img/logo-montera.png') }}" class="logo-big">
        <h1>MONTERA</h1>
        <p>Catat setiap rupiah, raih masa depan mewah. Platform manajemen keuangan pribadi paling eksklusif.</p>
        
        <a href="{{ route('login') }}" class="btn btn-red shadow-lg">Masuk Ke Aplikasi</a>
        <a href="{{ route('register') }}" class="btn btn-outline">Daftar Akun Baru</a>
    </div>
</body>
</html>