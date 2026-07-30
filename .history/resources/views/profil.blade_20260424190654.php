@extends('layouts.app')

@section('styles')
<style>
    .profil-container { padding: 20px; padding-bottom: 150px; }
    
    /* Header Profil Card */
    .user-card { 
        background: linear-gradient(145deg, #1A1A1A 0%, #0A0A0A 100%); 
        border-radius: 35px; 
        padding: 40px 20px; 
        text-align: center; 
        border: 1px solid #222;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .user-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(211, 47, 47, 0.05) 0%, transparent 70%);
        z-index: 0;
    }

    .big-avatar {
        width: 100px;
        height: 100px;
        background: #D32F2F;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        font-weight: 900;
        color: white;
        box-shadow: 0 15px 35px rgba(211, 47, 47, 0.3);
        position: relative;
        z-index: 1;
    }

    .user-name { font-size: 1.5rem; font-weight: 900; margin-bottom: 5px; position: relative; z-index: 1; }
    .user-email { font-size: 0.85rem; color: #555; font-weight: 600; position: relative; z-index: 1; }

    /* Ringkasan Box */
    .stat-box { 
        background: #161616; 
        padding: 20px; 
        border-radius: 25px; 
        border: 1px solid #222;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .stat-info span { display: block; }
    .stat-label { font-size: 10px; font-weight: 800; color: #444; text-transform: uppercase; letter-spacing: 1px; }
    .stat-value { font-size: 1rem; font-weight: 800; color: white; margin-top: 2px; }
    .stat-icon { width: 40px; height: 40px; background: rgba(255,255,255,0.03); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #D32F2F; }

    /* Menu Grouping */
    .menu-group { margin-bottom: 25px; }
    .group-label { padding: 10px 5px; font-size: 10px; font-weight: 800; color: #444; text-transform: uppercase; letter-spacing: 1px; }
    
    .action-list { display: flex; flex-direction: column; gap: 10px; }
    .action-item { 
        padding: 18px 20px; 
        background: #161616; 
        border-radius: 22px; 
        text-decoration: none; 
        color: white; 
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        border: 1px solid transparent;
        transition: 0.3s;
    }
    .action-item:active { background: #1A1A1A; border-color: #333; transform: scale(0.98); }
    .action-content { display: flex; align-items: center; gap: 15px; }
    .action-content i { color: #D32F2F; width: 25px; text-align: center; font-size: 1.1rem; }
    .action-content span { font-size: 0.9rem; font-weight: 700; }
    
    .logout-btn { color: #ff4d4d !important; border: 1px solid rgba(255, 77, 77, 0.1) !important; }
    .logout-btn i { color: #ff4d4d !important; }

    /* Modal Logout Style */
    .logout-overlay {
        position: fixed; inset: 0; background: rgba(0, 0, 0, 0.9); backdrop-filter: blur(10px);
        display: none; align-items: center; justify-content: center; z-index: 2000; padding: 20px;
    }
    .logout-overlay.active { display: flex; }
    .logout-card {
        background: #121212; width: 100%; max-width: 320px; border-radius: 35px; padding: 35px; text-align: center; border: 1px solid #222;
        animation: popUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes popUp { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>
@endsection

@section('content')
<div class="profil-container">
    <div class="user-card">
        <div class="big-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="user-name">{{ $user->name }}</div>
        <div class="user-email">{{ $user->email }}</div>
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

    <div class="menu-group">
        <div class="group-label">Dukungan & Lainnya</div>
        <div class="action-list">
            <a href="{{ route('bantuan') }}" class="action-item">
                <div class="action-content">
                    <i class="fa-solid fa-circle-question"></i>
                    <span>Pusat Bantuan</span>
                </div>
                <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #333;"></i>
            </a>
            <a href="{{ route('tentang') }}" class="action-item">
                <div class="action-content">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Tentang Montera v2.5</span>
                </div>
                <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #333;"></i>
            </a>
            <a href="#" class="action-item logout-btn" onclick="showLogoutModal(event)">
                <div class="action-content">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar dari Akun</span>
                </div>
            </a>
        </div>
    </div>
</div>

@include('partials.modal_input')

<div class="logout-overlay" id="logoutOverlayProfil">
    <div class="logout-card">
        <div style="width: 55px; height: 55px; background: rgba(211, 47, 47, 0.1); color: #D32F2F; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 1.5rem;">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 style="font-weight: 900; margin-bottom: 8px; color: white;">Keluar Akun?</h3>
        <p style="color: #555; font-size: 0.85rem; margin-bottom: 25px;">Sesi Anda akan berakhir. Pastikan data transaksi hari ini sudah lengkap.</p>
        <div style="display: grid; grid-template-cols: 1fr 1fr; gap: 12px;">
            <button onclick="hideLogoutModal()" style="background: #1A1A1A; color: #777; border: 1px solid #222; padding: 15px; border-radius: 18px; font-weight: bold; cursor: pointer;">Batal</button>
            <button onclick="document.getElementById('logout-form-profil').submit();" style="background: #D32F2F; color: white; border: none; padding: 15px; border-radius: 18px; font-weight: 900; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<form id="logout-form-profil" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

@endsection

@section('scripts')
<script>
    // Toggle Modal Logout
    function showLogoutModal(e) {
        e.preventDefault();
        document.getElementById('logoutOverlayProfil').classList.add('active');
    }

    function hideLogoutModal() {
        document.getElementById('logoutOverlayProfil').classList.remove('active');
    }

    // Fungsi Modal Input (Pemicu dari Navbar)
    function openModal() { 
        document.getElementById('modalTransaction').classList.add('active'); 
    }
    function closeModal() { 
        document.getElementById('modalTransaction').classList.remove('active'); 
    }

    // Close Modals on Outside Click
    window.onclick = function(event) {
        const logoutModal = document.getElementById('logoutOverlayProfil');
        const transModal = document.getElementById('modalTransaction');
        if (event.target == logoutModal) hideLogoutModal();
        if (event.target == transModal) closeModal();
    }
</script>
@endsection