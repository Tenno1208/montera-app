<style>
    /* 1. NAVBAR CONTAINER */
    .bottom-nav { 
        position: fixed; 
        bottom: 25px; 
        left: 50%; 
        transform: translateX(-50%); 
        width: 92%; 
        max-width: 420px; 
        height: 75px; 
        background: rgba(18, 18, 18, 0.95); 
        border-radius: 30px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        padding: 0 20px;
        border: 1px solid rgba(255, 255, 255, 0.05); 
        box-shadow: 0 15px 35px rgba(0,0,0,0.5); 
        z-index: 100; 
        backdrop-filter: blur(10px);
    }
    
    /* 2. BUTTON STYLE */
    .nav-btn { 
        color: #444; 
        font-size: 1.2rem; 
        border: none; 
        background: none; 
        cursor: pointer; 
        text-align: center; 
        text-decoration: none;
        flex: 1; 
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    /* WARNA ACTIVE DINAMIS */
    .nav-btn.active { color: var(--montera-red); }
    
    .nav-btn span { 
        display: block; 
        font-size: 9px; 
        font-weight: 800; 
        margin-top: 4px; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* 3. TOMBOL TAMBAH (TENGAH) */
    .add-btn-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .add-btn { 
        width: 62px; 
        height: 62px; 
        /* Gradient mengikuti personalisasi */
        background: linear-gradient(135deg, var(--montera-red) 0%, #000 150%); 
        color: white; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        margin-top: -55px; 
        border: 6px solid #0F0F0F; 
        font-size: 1.5rem; 
        /* Shadow mengikuti personalisasi dengan variabel RGB */
        box-shadow: 0 10px 20px rgba(var(--montera-red-rgb, 211, 47, 47), 0.4); 
        transition: 0.3s;
    }
    
    .add-btn:active { transform: scale(0.9); }

    /* 4. MODAL LOGOUT STYLE */
    .logout-overlay {
        position: fixed; inset: 0; background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px);
        display: none; align-items: center; justify-content: center; z-index: 2000; padding: 20px;
    }
    .logout-overlay.active { display: flex; }

    .logout-card {
        background: #121212; width: 100%; max-width: 320px; border-radius: 35px; padding: 30px;
        text-align: center; border: 1px solid #222;
        animation: popUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes popUp {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .logout-icon {
        width: 55px; height: 55px;
        background: rgba(var(--montera-red-rgb, 211, 47, 47), 0.1);
        color: var(--montera-red);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 1.5rem;
    }

    .btn-batal { background: #1A1A1A; color: #777; border: 1px solid #222; padding: 14px; border-radius: 15px; font-weight: bold; cursor: pointer; }
    
    /* Tombol Keluar Ikut Tema */
    .btn-keluar { 
        background: var(--montera-red); 
        color: white; border: none; padding: 14px; border-radius: 15px; 
        font-weight: 900; cursor: pointer; transition: 0.3s;
    }
</style>

<nav class="bottom-nav">
    <a href="{{ route('home') }}" class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>Beranda</span>
    </a>
    
    <a href="{{ route('laporan') }}" class="nav-btn {{ request()->routeIs('laporan') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-pie"></i>
        <span>Laporan</span>
    </a>

    <div class="add-btn-wrapper">
        <button class="add-btn" onclick="openModal()">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>
    
    <a href="{{ route('profil') }}" class="nav-btn {{ request()->routeIs('profil') ? 'active' : '' }}">
        <i class="fa-solid fa-user"></i>
        <span>Profil</span>
    </a>

    <a href="#" class="nav-btn" onclick="showLogoutConfirm(event)">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Keluar</span>
    </a>
</nav>

<div class="logout-overlay" id="logoutOverlay">
    <div class="logout-card">
        <div class="logout-icon">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <h3 style="color: white; font-weight: 900;">Yakin Ingin Keluar?</h3>
        <p>Sesi Anda akan berakhir. Pastikan semua catatan keuangan sudah tersimpan.</p>
        <div class="logout-actions">
            <button class="btn-batal" onclick="hideLogoutConfirm()">Batal</button>
            <button class="btn-keluar" onclick="confirmLogout()">Keluar</button>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    // FUNGSI TEMA UNTUK NAVBAR (Ambil dari LocalStorage)
    function syncNavbarTheme() {
        const savedColor = localStorage.getItem('montera_theme_red') || '#D32F2F';
        document.documentElement.style.setProperty('--montera-red', savedColor);
        
        // Konversi ke RGB untuk efek Shadow/Glow
        const r = parseInt(savedColor.slice(1, 3), 16);
        const g = parseInt(savedColor.slice(3, 5), 16);
        const b = parseInt(savedColor.slice(5, 7), 16);
        document.documentElement.style.setProperty('--montera-red-rgb', `${r}, ${g}, ${b}`);
    }

    // Jalankan sinkronisasi saat load
    syncNavbarTheme();

    function showLogoutConfirm(e) {
        e.preventDefault();
        document.getElementById('logoutOverlay').classList.add('active');
    }

    function hideLogoutConfirm() {
        document.getElementById('logoutOverlay').classList.remove('active');
    }

    function confirmLogout() {
        document.getElementById('logout-form').submit();
    }

    window.addEventListener('click', function(e) {
        const overlay = document.getElementById('logoutOverlay');
        if (e.target == overlay) hideLogoutConfirm();
    });
</script>