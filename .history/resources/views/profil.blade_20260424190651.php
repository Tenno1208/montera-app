@extends('layouts.app')

@section('styles')
<style>
    .profil-container { padding: 20px; padding-bottom: 150px; }
    
    /* Tambahan Variabel CSS agar Warna Dinamis */
    :root {
        --montera-red: #D32F2F; /* Default */
    }

    /* HEADER PROFIL - Menggunakan Variabel */
    .user-card { 
        background: linear-gradient(145deg, #1A1A1A 0%, #0A0A0A 100%); 
        border-radius: 35px; padding: 40px 20px; text-align: center; border: 1px solid #222;
        margin-bottom: 30px; position: relative; overflow: hidden;
    }
    
    .big-avatar {
        width: 100px; height: 100px; 
        background: var(--montera-red); /* Berubah otomatis */
        border-radius: 30px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 2.5rem; font-weight: 900; color: white;
        box-shadow: 0 15px 35px rgba(211, 47, 47, 0.3); position: relative; z-index: 1;
        transition: background 0.3s ease;
    }

    /* Input Warna Mewah */
    .color-picker-wrapper {
        background: #161616; padding: 20px; border-radius: 25px; border: 1px solid #222;
        display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px;
    }
    .color-info { display: flex; flex-direction: column; }
    #themeColor {
        -webkit-appearance: none; -moz-appearance: none; appearance: none;
        width: 45px; height: 45px; background-color: transparent; border: none; cursor: pointer;
    }
    #themeColor::-webkit-color-swatch { border-radius: 12px; border: 2px solid #333; }

    /* Mengganti semua warna merah statis ke variabel */
    .stat-icon i, .action-content i { color: var(--montera-red) !important; }
    .logout-card button:last-child { background: var(--montera-red) !important; }

    /* Gaya CSS lama kamu tetap saya pertahankan di bawah ini */
    .user-name { font-size: 1.5rem; font-weight: 900; margin-bottom: 5px; position: relative; z-index: 1; }
    .user-email { font-size: 0.85rem; color: #555; font-weight: 600; position: relative; z-index: 1; }
    .stat-box { background: #161616; padding: 20px; border-radius: 25px; border: 1px solid #222; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .stat-label { font-size: 10px; font-weight: 800; color: #444; text-transform: uppercase; letter-spacing: 1px; }
    .stat-value { font-size: 1rem; font-weight: 800; color: white; margin-top: 2px; }
    .menu-group { margin-bottom: 25px; }
    .group-label { padding: 10px 5px; font-size: 10px; font-weight: 800; color: #444; text-transform: uppercase; letter-spacing: 1px; }
    .action-list { display: flex; flex-direction: column; gap: 10px; }
    .action-item { padding: 18px 20px; background: #161616; border-radius: 22px; text-decoration: none; color: white; display: flex; align-items: center; justify-content: space-between; border: 1px solid transparent; transition: 0.3s; }
    .action-content { display: flex; align-items: center; gap: 15px; }
    .logout-btn { color: #ff4d4d !important; border: 1px solid rgba(255, 77, 77, 0.1) !important; }
    .logout-overlay { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.9); backdrop-filter: blur(10px); display: none; align-items: center; justify-content: center; z-index: 2000; padding: 20px; }
    .logout-overlay.active { display: flex; }
    .logout-card { background: #121212; width: 100%; max-width: 320px; border-radius: 35px; padding: 35px; text-align: center; border: 1px solid #222; }
</style>
@endsection

@section('content')
<div class="profil-container">
    <div class="user-card">
        <div class="big-avatar" id="avatarIcon">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="user-name">{{ $user->name }}</div>
        <div class="user-email">{{ $user->email }}</div>
    </div>

    <div class="menu-group">
        <div class="group-label">Personalisasi</div>
        <div class="color-picker-wrapper">
            <div class="color-info">
                <span class="stat-label">Warna Aksen Montera</span>
                <span style="font-size: 0.75rem; color: #777;">Sesuaikan warna merah sesukamu</span>
            </div>
            <input type="color" id="themeColor" value="#D32F2F">
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-info">
            <span class="stat-label">Ringkasan Aktivitas</span>
            <span class="stat-value">{{ $transactionCount }} Transaksi Tercatat</span>
        </div>
        <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
    </div>

    <div class="menu-group">
        <div class="group-label">Pengaturan Akun</div>
        <div class="action-list">
            <a href="{{ route('profil.edit') }}" class="action-item">
                <div class="action-content">
                    <i class="fa-solid fa-user-pen"></i>
                    <span>Edit Nama & Email</span>
                </div>
                <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #333;"></i>
            </a>
            <a href="{{ route('profil.keamanan') }}" class="action-item">
                <div class="action-content">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Kata Sandi & Keamanan</span>
                </div>
                <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #333;"></i>
            </a>
        </div>
    </div>
    </div>

<div class="logout-overlay" id="logoutOverlayProfil">
    <div class="logout-card">
        <div style="width: 55px; height: 55px; background: rgba(211, 47, 47, 0.1); color: var(--montera-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 1.5rem;">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 style="font-weight: 900; margin-bottom: 8px; color: white;">Keluar Akun?</h3>
        <p style="color: #555; font-size: 0.85rem; margin-bottom: 25px;">Sesi Anda akan berakhir.</p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <button onclick="hideLogoutModal()" style="background: #1A1A1A; color: #777; border: 1px solid #222; padding: 15px; border-radius: 18px; font-weight: bold; cursor: pointer;">Batal</button>
            <button onclick="document.getElementById('logout-form-profil').submit();" style="background: var(--montera-red); color: white; border: none; padding: 15px; border-radius: 18px; font-weight: 900; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const colorInput = document.getElementById('themeColor');

    // 1. Ambil warna tersimpan saat halaman dibuka
    const savedColor = localStorage.getItem('montera_theme_red') || '#D32F2F';
    applyColor(savedColor);
    colorInput.value = savedColor;

    // 2. Event Listener saat warna diganti
    colorInput.addEventListener('input', function(e) {
        const newColor = e.target.value;
        applyColor(newColor);
        localStorage.setItem('montera_theme_red', newColor);
    });

    function applyColor(color) {
        // Mengubah variabel CSS di seluruh dokumen
        document.documentElement.style.setProperty('--montera-red', color);
    }

    // Fungsi modal kamu yang lain tetap di sini...
    function showLogoutModal(e) { e.preventDefault(); document.getElementById('logoutOverlayProfil').classList.add('active'); }
    function hideLogoutModal() { document.getElementById('logoutOverlayProfil').classList.remove('active'); }
</script>
@endsection