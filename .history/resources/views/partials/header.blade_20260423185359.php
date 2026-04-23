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
        z-index: 100; 
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .logo-section { display: flex; align-items: center; gap: 12px; }
    .logo-img { width: 42px; height: 42px; object-fit: contain; filter: drop-shadow(0 0 8px rgba(211, 47, 47, 0.3)); }
    .brand-name h1 { font-size: 1.1rem; font-weight: 900; letter-spacing: -1px; margin-bottom: -4px; color: white; }
    .brand-name p { font-size: 0.55rem; color: #D32F2F; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
    
    /* Style Profile Mewah */
    .user-profile { display: flex; align-items: center; gap: 12px; background: none; border: none; cursor: pointer; padding: 0; }
    .user-info { text-align: right; }
    .user-info .greet { display: block; font-size: 9px; color: #555; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    .user-info .name { display: block; font-size: 11px; color: white; font-weight: 800; }
    
    .avatar-circle { 
        width: 40px; 
        height: 40px; 
        background: linear-gradient(135deg, #1A1A1A 0%, #000000 100%); 
        border: 1px solid #222; 
        border-radius: 14px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        color: #D32F2F; 
        font-weight: 800;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
</style>

<header>
    <div class="logo-section">
        <img src="{{ asset('img/logo-montera.png') }}" alt="M" class="logo-img">
        <div class="brand-name">
            <h1>MONTERA</h1>
            <p>Premium</p>
        </div>
    </div>

    @auth
    <div class="user-profile">
        <div class="user-info">
            <span class="greet">Halo,</span>
            <span class="name">{{ explode(' ', Auth::user()->name)[0] }}</span> </div>
        <div class="avatar-circle">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }} </div>
    </div>
    @endauth

    @guest
    <a href="{{ route('login') }}" class="profile-btn">
        <i class="fa-solid fa-user-circle"></i>
    </a>
    @endguest
</header>