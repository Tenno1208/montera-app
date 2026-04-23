<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Daftar Akun</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS yang sudah ada sebelumnya tetap sama, tambahkan ini untuk alert sukses */
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border-left: 4px solid #22c55e;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 25px;
            color: #22c55e;
            font-size: 12px;
            font-weight: bold;
        }
        /* ... (Gunakan CSS dari kode sebelumnya) ... */
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
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <button type="submit" class="btn-register">Buat Akun Gratis</button>
            
            <a href="{{ route('login') }}" class="footer-link">Sudah memiliki akses? <span>MASUK</span></a>
        </form>
    </div>
</body>
</html>