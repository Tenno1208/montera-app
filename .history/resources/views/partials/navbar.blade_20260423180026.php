<style>
    .bottom-nav { position: fixed; bottom: 25px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 400px; height: 75px; background: rgba(18, 18, 18, 0.95); border-radius: 30px; display: flex; justify-content: space-around; align-items: center; border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 15px 35px rgba(0,0,0,0.5); z-index: 100; }
    .nav-btn { color: #444; font-size: 1.3rem; border: none; background: none; cursor: pointer; text-align: center; }
    .nav-btn.active { color: #D32F2F; }
    .nav-btn span { display: block; font-size: 10px; font-weight: bold; margin-top: 2px; }
    .add-btn { width: 60px; height: 60px; background: #D32F2F; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -45px; border: 5px solid #0F0F0F; font-size: 1.5rem; box-shadow: 0 10px 20px rgba(211, 47, 47, 0.4); }
</style>

<nav class="bottom-nav">
    <button class="nav-btn active">
        <i class="fa-solid fa-house"></i>
        <span>Beranda</span>
    </button>
    
    <button class="add-btn" onclick="openModal()">
        <i class="fa-solid fa-plus"></i>
    </button>
    
    <button class="nav-btn">
        <i class="fa-solid fa-chart-pie"></i>
        <span>Laporan</span>
    </button>
</nav>