<style>
    header { 
        padding: 20px 25px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        position: sticky; 
        top: 0; 
        background: rgba(15, 15, 15, 0.8); 
        backdrop-filter: blur(15px); 
        -webkit-backdrop-filter: blur(15px);
        z-index: 1000; 
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    /* LOGO SECTION - Ikut Personalisasi */
    .logo-section { display: flex; align-items: center; gap: 12px; }
    .logo-img { 
        width: 42px; height: 42px; object-fit: contain; 
        /* Shadow logo mengikuti warna tema */
        filter: drop-shadow(0 0 8px rgba(var(--montera-red-rgb, 211, 47, 47), 0.3)); 
    }
    .brand-name h1 { font-size: 1.1rem; font-weight: 900; letter-spacing: -1px; margin-bottom: -4px; color: white; }
    .brand-name p { 
        font-size: 0.55rem; 
        color: var(--montera-red); /* Berubah dinamis */
        font-weight: 800; letter-spacing: 2px; text-transform: uppercase; 
    }
    
    /* Profile Wrapper */
    .profile-wrapper { position: relative; }

    .user-profile { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        background: none; 
        border: none; 
        cursor: pointer; 
        padding: 5px;
        border-radius: 18px;
        transition: 0.3s;
    }
    .user-profile:active { background: rgba(255,255,255,0.05); transform: scale(0.95); }

    .user-info { text-align: right; }
    .user-info .greet { display: block; font-size: 9px; color: #555; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    .user-info .name { display: block; font-size: 11px; color: white; font-weight: 800; }
    
    /* AVATAR - Ikut Personalisasi */
    .avatar-circle { 
        width: 40px; 
        height: 40px; 
        background: linear-gradient(135deg, #1A1A1A 0%, #000000 100%); 
        border: 1px solid #222; 
        border-radius: 14px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        color: var(--montera-red); /* Inisial nama ikut warna tema */
        font-weight: 800;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        transition: 0.3s;
    }

    /* DROPDOWN MENU MEWAH */
    .profile-dropdown {
        position: absolute;
        top: 60px;
        right: 0;
        width: 200px;
        background: #161616;
        border: 1px solid #222;
        border-radius: 22px;
        padding: 10px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        display: none; 
        z-index: 1001;
        transform-origin: top right;
        animation: dropAnim 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes dropAnim {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .profile-dropdown.active { display: block; }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #aaa;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 15px;
        transition: 0.3s;
    }

    .dropdown-item i { width: 16px; color: #555; transition: 0.3s; }
    .dropdown-item:hover, .dropdown-item:active { background: #1f1f1f; color: white; }
    
    /* Hover ikon ikut personalisasi */
    .dropdown-item:hover i { color: var(--montera-red); }

    .dropdown-divider { height: 1px; background: #222; margin: 8px 10px; }
</style>

<header>
    <div class="logo-section">
        <img src="{{ asset('img/logo-montera.png') }}" alt="M" class="logo-img">
        <div class="brand-name">
            <h1>MONETRA</h1>
            <p>Premium</p>
        </div>
    </div>

    @auth
    <div class="profile-wrapper">
        <div class="user-profile" onclick="toggleDropdown(event)">
            <div class="user-info">
                <span class="greet">Halo,</span>
                <span class="name">{{ explode(' ', Auth::user()->name)[0] }}</span>
            </div>
            <div class="avatar-circle">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>

        <div class="profile-dropdown" id="profileDropdown">
            <a href="{{ route('profil') }}" class="dropdown-item">
                <i class="fa-solid fa-user-gear"></i>
                <span>Profil Saya</span>
            </a>
            <a href="{{ route('laporan') }}" class="dropdown-item">
                <i class="fa-solid fa-chart-line"></i>
                <span>Analisis Kas</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" style="color: #ff4d4d;" onclick="showLogoutConfirm(event)">
                <i class="fa-solid fa-right-from-bracket" style="color: #ff4d4d;"></i>
                <span>Keluar</span>
            </a>
        </div>
    </div>
    @endauth

    @guest
    <a href="{{ route('login') }}" class="profile-btn">
        <i class="fa-solid fa-user-circle"></i>
    </a>
    @endguest
</header>

<script>
    // FUNGSI TEMA UNTUK HEADER (Ambil dari LocalStorage)
    function syncHeaderTheme() {
        const savedColor = localStorage.getItem('montera_theme_red') || '#D32F2F';
        document.documentElement.style.setProperty('--montera-red', savedColor);
        
        // Konversi ke RGB untuk efek Glow pada Logo
        const r = parseInt(savedColor.slice(1, 3), 16);
        const g = parseInt(savedColor.slice(3, 5), 16);
        const b = parseInt(savedColor.slice(5, 7), 16);
        document.documentElement.style.setProperty('--montera-red-rgb', `${r}, ${g}, ${b}`);
    }

    // Jalankan saat load
    syncHeaderTheme();

    function toggleDropdown(event) {
        event.stopPropagation();
        document.getElementById('profileDropdown').classList.toggle('active');
    }

    // Tutup dropdown jika klik di mana saja
    window.addEventListener('click', function() {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
        }
    });
</script>