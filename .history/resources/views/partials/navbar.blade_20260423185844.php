<nav class="bottom-nav">
    <a href="{{ route('home') }}" class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i><span>Beranda</span>
    </a>
    <a href="{{ route('laporan') }}" class="nav-btn {{ request()->routeIs('laporan') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-pie"></i><span>Laporan</span>
    </a>
    <div class="add-btn-wrapper">
        <button class="add-btn" onclick="openModal()"><i class="fa-solid fa-plus"></i></button>
    </div>
    <a href="{{ route('profil') }}" class="nav-btn {{ request()->routeIs('profil') ? 'active' : '' }}">
        <i class="fa-solid fa-user"></i><span>Profil</span>
    </a>

    <a href="#" class="nav-btn" onclick="openLogoutModal(event)">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Keluar</span>
    </a>
</nav>

<div id="logout-modal" class="modal-logout-overlay">
    <div class="modal-logout-card">
        <div class="icon-warning">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <h3>Konfirmasi Keluar</h3>
        <p>Apakah Anda yakin ingin mengakhiri sesi ini dan keluar dari aplikasi Montera?</p>
        
        <div class="modal-logout-actions">
            <button class="btn-cancel" onclick="closeLogoutModal()">Batal</button>
            <button class="btn-confirm-logout" onclick="document.getElementById('logout-form').submit();">Keluar</button>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
    /* Style Modal Logout Mewah */
    .modal-logout-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px);
        display: none; /* Sembunyi default */
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 20px;
    }

    .modal-logout-overlay.active { display: flex; }

    .modal-logout-card {
        background: #121212;
        width: 100%;
        max-width: 350px;
        border-radius: 30px;
        padding: 30px;
        text-align: center;
        border: 1px solid #222;
        animation: scaleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes scaleIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .icon-warning {
        width: 60px;
        height: 60px;
        background: rgba(211, 47, 47, 0.1);
        color: #D32F2F;
        font-size: 1.8rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .modal-logout-card h3 { font-weight: 800; margin-bottom: 10px; font-size: 1.2rem; }
    .modal-logout-card p { color: #666; font-size: 0.85rem; line-height: 1.5; margin-bottom: 25px; }

    .modal-logout-actions { display: grid; grid-template-cols: 1fr 1fr; gap: 15px; }

    .btn-cancel {
        background: #1A1A1A;
        color: #aaa;
        border: 1px solid #222;
        padding: 15px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-confirm-logout {
        background: #D32F2F;
        color: white;
        border: none;
        padding: 15px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(211, 47, 47, 0.3);
    }
</style>

<script>
    function openLogoutModal(e) {
        e.preventDefault();
        document.getElementById('logout-modal').classList.add('active');
    }

    function closeLogoutModal() {
        document.getElementById('logout-modal').classList.remove('active');
    }

    // Tutup jika klik area hitam
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('logout-modal');
        if (e.target === modal) closeLogoutModal();
    });
</script>