<style>
    header { padding: 25px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(10px); z-index: 10; }
    .logo-section { display: flex; align-items: center; gap: 12px; }
    .logo-img { width: 45px; height: 45px; object-fit: contain; }
    .brand-name h1 { font-size: 1.2rem; font-weight: 900; letter-spacing: -1px; margin-bottom: -4px; }
    .brand-name p { font-size: 0.6rem; color: #D32F2F; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; }
    .profile-btn { color: #444; font-size: 1.5rem; background: none; border: none; }
</style>

<header>
    <div class="logo-section">
        <img src="{{ asset('img/logo-montera.png') }}" alt="M" class="logo-img">
        <div class="brand-name">
            <h1>MONTERA</h1>
            <p>Premium</p>
        </div>
    </div>
    <button class="profile-btn"><i class="fa-solid fa-user-circle"></i></button>
</header>