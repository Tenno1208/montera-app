<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Masuk</title>
    <style>
        body { background: #0F0F0F; color: white; font-family: sans-serif; padding: 40px; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-box { width: 100%; max-width: 400px; }
        h2 { font-size: 2rem; font-weight: 900; margin-bottom: 30px; }
        .input-group { margin-bottom: 20px; }
        input { width: 100%; padding: 15px; border-radius: 15px; border: 1px solid #222; background: #1A1A1A; color: white; outline: none; margin-top: 5px; }
        .btn-login { width: 100%; padding: 18px; border-radius: 15px; border: none; background: #D32F2F; color: white; font-weight: bold; cursor: pointer; margin-top: 10px; }
        a { color: #555; text-decoration: none; font-size: 0.8rem; display: block; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Masuk ke<br><span style="color: #D32F2F;">Montera</span></h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label style="font-size: 11px; font-weight: bold; color: #444;">ALAMAT EMAIL</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label style="font-size: 11px; font-weight: bold; color: #444;">PASSWORD</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login shadow-lg">MASUK SEKARANG</button>
            <a href="{{ route('register') }}">Belum punya akun? Daftar gratis</a>
        </form>
    </div>
</body>
</html>