<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Daftar Akun</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: #0F0F0F; color: white; font-family: 'Segoe UI', sans-serif; 
            padding: 20px; display: flex; align-items: center; justify-content: center; 
            min-height: 100vh; margin: 0; overflow-x: hidden;
        }

        .bg-glow { position: fixed; top: -10%; right: -10%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(211, 47, 47, 0.15) 0%, transparent 70%); z-index: -1; }
        .bg-glow-bottom { position: fixed; bottom: -5%; left: -5%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(211, 47, 47, 0.1) 0%, transparent 70%); z-index: -1; }

        .register-box { width: 100%; max-width: 420px; padding: 20px; position: relative; }
        .logo-container { text-align: center; margin-bottom: 30px; }
        .logo-img { width: 70px; filter: drop-shadow(0 0 15px rgba(211, 47, 47, 0.4)); }

        h2 { font-size: 2.2rem; font-weight: 900; margin-bottom: 10px; line-height: 1.1; letter-spacing: -1.5px; }
        p.subtitle { color: #555; font-size: 0.9rem; margin-bottom: 35px; font-weight: 500; }
        
        .input-group { margin-bottom: 18px; position: relative; }
        label { font-size: 10px; font-weight: 800; color: #444; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 8px; margin-left: 5px; }
        
        /* Input Styling */
        .password-wrapper { position: relative; width: 100%; }
        input { 
            width: 100%; padding: 18px 50px 18px 45px; border-radius: 20px; 
            border: 1px solid #222; background: #161616; color: white; 
            outline: none; box-sizing: border-box; transition: 0.3s; font-size: 0.95rem;
        }
        input:focus { border-color: #D32F2F; background: #1A1A1A; box-shadow: 0 0 20px rgba(211, 47, 47, 0.1); }

        /* Icon Position */
        .input-group i.main-icon { position: absolute; left: 18px; bottom: 18px; color: #333; transition: 0.3s; z-index: 5; }
        input:focus + i.main-icon { color: #D32F2F; }

        /* Toggle Mata */
        .toggle-password { position: absolute; right: 18px; bottom: 18px; color: #333; cursor: pointer; transition: 0.3s; z-index: 10; }
        .toggle-password:hover { color: #D32F2F; }

        /* Kriteria Sandi Box */
        .criteria-box { background: rgba(255,255,255,0.02); padding: 15px; border-radius: 18px; border: 1px solid #222; margin-bottom: 20px; }
        .criteria-box p { font-size: 10px; color: #777; font-weight: 800; margin: 0 0 8px 0; text-transform: uppercase; }
        .criteria-list { margin: 0; padding-left: 15px; font-size: 0.75rem; color: #555; display: flex; flex-direction: column; gap: 4px; }

        .btn-register { 
            width: 100%; padding: 20px; border-radius: 22px; border: none; 
            background: linear-gradient(135deg, #D32F2F 0%, #9B1C1C 100%);
            color: white; font-weight: 900; cursor: pointer; margin-top: 15px; 
            text-transform: uppercase; font-size: 0.85rem; box-shadow: 0 10px 25px rgba(211, 47, 47, 0.3); transition: 0.3s;
        }
        .btn-register:active { transform: scale(0.98); }
        .footer-link { color: #555; text-decoration: none; font-size: 0.85rem; display: block; text-align: center; margin-top: 30px; font-weight: 600; }
        .footer-link span { color: #D32F2F; font-weight: 800; }

        .alert-error { background: rgba(211, 47, 47, 0.1); border-left: 4px solid #D32F2F; padding: 12px; border-radius: 12px; margin-bottom: 25px; }
        .error-item { color: #ff4d4d; font-size: 12px; font-weight: bold; list-style: none; }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    <div class="bg-glow-bottom"></div>

    <div class="register-box">
        <div class="logo-container">
            <img src="{{ asset('img/logo-montera.png') }}" class="logo-img">
        </div>

        <h2>Gabung<br><span style="color: #D32F2F;">Montera</span></h2>
        <p class="subtitle">Mulai bangun masa depan finansial mewah Anda sekarang.</p>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div class="error-item"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <label>Nama Lengkap</label>
                <div class="password-wrapper">
                    <input type="text" name="name" placeholder="Nama Anda" required value="{{ old('name') }}">
                    <i class="fa-solid fa-user main-icon"></i>
                </div>
            </div>

            <div class="input-group">
                <label>Alamat Email</label>
                <div class="password-wrapper">
                    <input type="email" name="email" placeholder="email@montera.com" required value="{{ old('email') }}">
                    <i class="fa-solid fa-envelope main-icon"></i>
                </div>
            </div>

            <div class="input-group">
                <label>Kata Sandi</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="reg_pass" placeholder="Buat sandi kuat" required>
                    <i class="fa-solid fa-lock main-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" onclick="toggleView('reg_pass', this)"></i>
                </div>
            </div>

            <div class="input-group">
                <label>Konfirmasi Sandi</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="reg_confirm" placeholder="Ulangi sandi" required>
                    <i class="fa-solid fa-shield-check main-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" onclick="toggleView('reg_confirm', this)"></i>
                </div>
            </div>

            <button type="submit" class="btn-register">Buat Akun Eksklusif</button>
            
            <a href="{{ route('login') }}" class="footer-link">Sudah member? <span>MASUK</span></a>
        </form>
    </div>

    <script>
        function toggleView(id, icon) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                icon.style.color = "#D32F2F";
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                icon.style.color = "#333";
            }
        }
    </script>
</body>
</html>