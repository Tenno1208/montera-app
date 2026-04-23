<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montera - Kelola Uang dengan Gaya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            margin: 0; 
            background: #080808; 
            color: white; 
            font-family: 'Inter', 'Segoe UI', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        /* Elemen Background Mewah */
        .bg-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(211, 47, 47, 0.15) 0%, transparent 70%);
            z-index: 0;
            filter: blur(50px);
            animation: pulse 8s infinite alternate;
        }
        .glow-1 { top: -50px; right: -50px; }
        .glow-2 { bottom: -50px; left: -50px; }

        @keyframes pulse {
            from { transform: scale(1); opacity: 0.5; }
            to { transform: scale(1.5); opacity: 0.8; }
        }

        .hero { 
            padding: 40px; 
            max-width: 450px; 
            z-index: 10; 
            position: relative;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-big { 
            width: 140px; 
            margin-bottom: 30px; 
            filter: drop-shadow(0 0 30px rgba(211, 47, 47, 0.6)); 
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        h1 { 
            font-size: 3.5rem; 
            font-weight: 900; 
            letter-spacing: -3px; 
            margin: 0; 
            background: linear-gradient(to bottom, #fff 0%, #555 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .brand-sub {
            color: #D32F2F;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 20px;
            display: block;
        }

        p { 
            color: #888; 
            font-size: 0.95rem; 
            margin-bottom: 45px; 
            line-height: 1.6; 
            padding: 0 10px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn { 
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%; 
            padding: 22px; 
            border-radius: 25px; 
            text-decoration: none; 
            font-weight: 800; 
            font-size: 1rem;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            box-sizing: border-box;
        }

        .btn-red { 
            background: #D32F2F; 
            color: white; 
            box-shadow: 0 15px 35px rgba(211, 47, 47, 0.4);
            border: none;
        }

        .btn-red:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(211, 47, 47, 0.6);
            background: #B71C1C;
        }

        .btn-outline { 
            border: 1px solid #222; 
            color: #fff; 
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(10px);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #444;
        }

        .btn:active { transform: scale(0.95); }

        .footer-text {
            position: absolute;
            bottom: 30px;
            font-size: 0.7rem;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="bg-glow glow-1"></div>
    <div class="bg-glow glow-2"></div>

    <div class="hero">
        <img src="{{ asset('img/logo-montera.png') }}" class="logo-big">
        <span class="brand-sub">Exclusive A</span>
        <h1>MONTERA</h1>
        <p>Kendalikan finansial Anda dengan AI tercanggih. Catat setiap rupiah, bangun masa depan mewah secara otomatis.</p>
        
        <div class="btn-group">
            <a href="{{ route('login') }}" class="btn btn-red">
                <span>Mulai Sekarang</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline">
                <i class="fa-solid fa-user-plus"></i>
                <span>Daftar Akun</span>
            </a>
        </div>
    </div>

    <div class="footer-text">© 2026 Montera International Group</div>
</body>
</html>