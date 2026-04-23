<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Masuk</title>
    <style>
        body { background: #0F0F0F; color: white; font-family: sans-serif; padding: 40px; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .login-box { width: 100%; max-width: 400px; }
        h2 { font-size: 2rem; font-weight: 900; margin-bottom: 30px; line-height: 1.1; }
        .input-group { margin-bottom: 20px; position: relative; }
        
        /* Gaya Label & Input */
        label { font-size: 11px; font-weight: bold; color: #444; letter-spacing: 1px; display: block; margin-bottom: 8px; }
        input { 
            width: 100%; padding: 15px; border-radius: 15px; border: 1px solid #222; 
            background: #1A1A1A; color: white; outline: none; box-sizing: border-box;
            transition: 0.3s;
        }
        
        /* State Input Error */
        input.is-invalid { border-color: #D32F2F; background: rgba(211, 47, 47, 0.05); }
        input:focus { border-color: #D32F2F; }

        /* Pesan Error Mewah */
        .error-message { 
            color: #D32F2F; font-size: 11px; font-weight: bold; margin-top: 6px; 
            display: flex; align-items: center; gap: 5px;
        }

        /* Tombol */
        .btn-login { 
            width: 100%; padding: 18px; border-radius: 15px; border: none; 
            background: #D32F2F; color: white; font-weight: bold; cursor: pointer; 
            margin-top: 10px; transition: 0.3s; letter-spacing: 1px;
        }
        .btn-login:active { transform: scale(0.98); }
        
        a { color: #555; text-decoration: none; font-size: 0.8rem; display: block; text-align: center; margin-top: 20px; font-weight: 600; }
        span.montera-text { color: #D32F2F; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Masuk ke<br><span class="montera-text">Montera</span></h2>

        @if($errors->has('loginError'))
            <div style="background: rgba(211, 47, 47, 0.1); border: 1px solid #D32F2F; padding: 15px; border-radius: 15px; margin-bottom: 20px; font-size: 12px; color: #ff4d4d; font-weight: bold; text-align: center;">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first('loginError') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label>ALAMAT EMAIL</label>
                <input type="email" name="email" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="nama@email.com" required autofocus>
                @error('email')
                    <div class="error-message">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="input-group">
                <label>PASSWORD</label>
                <input type="password" name="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="••••••••" required>
                @error('password')
                    <div class="error-message">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-login shadow-lg">MASUK SEKARANG</button>
            <a href="{{ route('register') }}">Belum punya akun? <span style="color: #D32F2F;">Daftar gratis</span></a>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>