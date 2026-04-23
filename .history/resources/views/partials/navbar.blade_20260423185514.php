<style>
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
        justify-content: space-between; /* Ubah ke space-between agar lebih presisi */
        align-items: center; 
        padding: 0 20px;
        border: 1px solid rgba(255, 255, 255, 0.05); 
        box-shadow: 0 15px 35px rgba(0,0,0,0.5); 
        z-index: 100; 
        backdrop-filter: blur(10px);
    }
    
    .nav-btn { 
        color: #444; 
        font-size: 1.2rem; 
        border: none; 
        background: none; 
        cursor: pointer; 
        text-align: center; 
        text-decoration: none;
        flex: 1; /* Memberikan ruang yang sama antar menu */
        transition: 0.3s;
    }
    
    .nav-btn.active { color: #D32F2F; }
    
    .nav-btn span { 
        display: block; 
        font-size: 9px; 
        font-weight: 800; 
        margin-top: 4px; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .add-btn-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .add-btn { 
        width: 60px; 
        height: 60px; 
        background: linear-gradient(135deg, #D32F2F 0%, #9B1C1C 100%); 
        color: white; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        margin-top: -50px; 
        border: 6px solid #0F0F0F; 
        font-size: 1.5rem; 
        box-shadow: 0 10px 20px rgba(211, 47, 47, 0.4); 
        transition: 0.3s;
    }
    
    .add-btn:active { transform: scale(0.9); }
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
    
    <a href="#" class="nav-btn"> <i class="fa-solid fa-user"></i>
        <span>Profil</span>
    </a>

    <a href="#" class="nav-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Keluar</span>
    </a>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>