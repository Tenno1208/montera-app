@extends('layouts.app')

@section('styles')
<style>
    .profil-container { padding: 20px; }
    
    /* Header Profil */
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

    /* Statistik Singkat */
    .user-stats { 
        display: grid; 
        grid-template-cols: 1fr; 
        gap: 15px; 
        margin-bottom: 30px; 
    }
    
    .stat-box { 
        background: #161616; 
        padding: 20px; 
        border-radius: 25px; 
        border: 1px solid #222;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .stat-info span { display: block; }
    .stat-label { font-size: 10px; font-weight: 800; color: #444; text-transform: uppercase; letter-spacing: 1px; }
    .stat-value { font-size: 1rem; font-weight: 800; color: white; margin-top: 2px; }
    .stat-icon { width: 40px; height: 40px; background: rgba(255,255,255,0.03); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #D32F2F; }

    /* Menu Aksi */
    .action-list { display: flex; flex-direction: column; gap: 10px; }
    .action-item { 
        padding: 20px; 
        background: #161616; 
        border-radius: 20px; 
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
    .action-content i { color: #D32F2F; width: 20px; text-align: center; }
    .action-content span { font-size: 0.9rem; font-weight: 700; }
    
    .logout-btn { color: #ff4d4d !important; margin-top: 10px; }
    .logout-btn i { color: #ff4d4d !important; }
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

    <div class="user-stats">
        <div class="stat-box">
            <div class="stat-info">
                <span class="stat-label">Total Aktivitas</span>
                <span class="stat-value">{{ $transactionCount }} Transaksi</span>
            </div>
            <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
        </div>
    </div>

    <div class="action-list">
        <div style="padding: 10px 5px; font-size: 10px; font-weight: 800; color: #444; text-transform: uppercase;">Pengaturan Akun</div>
        
        <a href="#" class="action-item">
            <div class="action-content">
                <i class="fa-solid fa-user-pen"></i>
                <span>Edit Profil</span>
            </div>
            <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #333;"></i>
        </a>

        <a href="#" class="action-item">
            <div class="action-content">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Keamanan</span>
            </div>
            <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #333;"></i>
        </a>

        <a href="#" class="action-item logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="action-content">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Keluar dari Aplikasi</span>
            </div>
        </a>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection