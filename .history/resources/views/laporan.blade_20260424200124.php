@extends('layouts.app')

@section('styles')
<style>
    .report-container { padding: 20px; padding-bottom: 100px; }
    
    /* Header & Filter Icons */
    .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .header-actions { display: flex; gap: 10px; } 

    .btn-filter-icon { 
        width: 45px; height: 45px; background: #1A1A1A; border: 1px solid #222; 
        border-radius: 15px; display: flex; align-items: center; justify-content: center; 
        color: var(--montera-red); cursor: pointer; transition: 0.3s;
    }
    .btn-filter-icon.reset { color: #555; } 
    .btn-filter-icon:active { transform: scale(0.9); background: #222; }
    
    /* 1. VARIASI BARU: Mini Stat Cards */
    .mini-stats-grid { display: grid; grid-template-cols: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
    .mini-card { 
        background: #1A1A1A; padding: 15px; border-radius: 20px; border: 1px solid #222;
        display: flex; flex-direction: column; gap: 5px;
    }
    .mini-card i { font-size: 14px; margin-bottom: 5px; }
    .mini-card span { font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .mini-card h4 { margin: 0; font-size: 0.95rem; font-weight: 900; color: white; }

    /* 2. Chart Section - Enhanced */
    .stat-card { 
        background: radial-gradient(circle at top left, #1d1d1d, #121212); 
        padding: 40px 20px; border-radius: 35px; border: 1px solid #222; 
        text-align: center; margin-bottom: 20px; position: relative; overflow: hidden;
    }
    .stat-card::before {
        content: ''; position: absolute; top: -50px; right: -50px; width: 150px; height: 150px;
        background: var(--montera-red); filter: blur(100px); opacity: 0.05;
    }

    .chart-box { 
        position: relative; width: 200px; height: 200px; margin: 0 auto; border-radius: 50%; 
        background: conic-gradient(#22c55e 0% {{ $incomePercent }}%, var(--montera-red) {{ $incomePercent }}% 100%); 
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        transition: 0.5s;
    }
    .chart-inner { 
        width: 155px; height: 155px; background: #121212; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; flex-direction: column; 
        border: 2px solid #1A1A1A;
    }
    
    /* 3. Legend Row - Variasi Baru */
    .legend-container { margin-top: 35px; display: flex; flex-direction: column; gap: 10px; }
    .legend-item { 
        background: rgba(255,255,255,0.02); padding: 20px; border-radius: 25px; 
        border: 1px solid rgba(255,255,255,0.03); display: flex; justify-content: space-between; align-items: center; 
    }
    .indicator-pill {
        padding: 4px 12px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase;
    }
    
    /* Modal Filter */
    .modal-filter { 
        position: fixed; inset: 0; background: rgba(0,0,0,0.9); 
        z-index: 2000; display: none; align-items: center; justify-content: center; 
        padding: 20px; backdrop-filter: blur(10px); 
    }
    .modal-filter.active { display: flex; }
    .filter-card { 
        background: #121212; width: 100%; max-width: 350px; 
        border-radius: 35px; padding: 35px; border: 1px solid #222; 
    }

    /* AI Tips */
    .tips-card {
        background: #1A1A1A; padding: 25px; border-radius: 25px; 
        border-bottom: 4px solid var(--montera-red); margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="report-container">
    <div class="report-header">
        <div>
            <h2 style="font-weight: 900; letter-spacing: -1.5px; margin: 0; font-size: 1.8rem;">Laporan <span style="color: var(--montera-red);">Kas</span></h2>
            <p style="font-size: 10px; color: #555; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; margin-top: 5px;">
                <i class="fa-solid fa-calendar-check"></i> 
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M') . ' - ' . \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Ringkasan Selamanya' }}
            </p>
        </div>
        
        <div class="header-actions">
            @if(request('start_date'))
                <a href="{{ route('laporan') }}" class="btn-filter-icon reset" title="Reset">
                    <i class="fa-solid fa-rotate"></i>
                </a>
            @endif

            <div class="btn-filter-icon" onclick="toggleFilterModal(true)">
                <i class="fa-solid fa-sliders"></i>
            </div>
        </div>
    </div>

    <div class="mini-stats-grid">
        <div class="mini-card">
            <i class="fa-solid fa-arrow-down" style="color: #22c55e;"></i>
            <span>Masuk</span>
            <h4>{{ number_format($totalIncome, 0, ',', '.') }}</h4>
        </div>
        <div class="mini-card">
            <i class="fa-solid fa-arrow-up" style="color: var(--montera-red);"></i>
            <span>Keluar</span>
            <h4>{{ number_format($totalExpense, 0, ',', '.') }}</h4>
        </div>
    </div>

    <div class="stat-card">
        <div class="chart-box">
            <div class="chart-inner">
                <span style="font-size: 10px; color: #555; font-weight: 800; letter-spacing: 2px; margin-bottom: 5px;">EXPENSE</span>
                <span style="font-size: 32px; font-weight: 900; color: white;">{{ round($expensePercent) }}%</span>
            </div>
        </div>
        
        <div class="legend-container">
            <div class="legend-item">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="indicator-pill" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">Income</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 900; color: white; font-size: 1.1rem;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                    <div style="font-size: 9px; color: #555; font-weight: 700;">{{ round($incomePercent) }}% dari total</div>
                </div>
            </div>

            <div class="legend-item">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="indicator-pill" style="background: rgba(230, 0, 0, 0.1); color: var(--montera-red);">Expense</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 900; color: white; font-size: 1.1rem;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                    <div style="font-size: 9px; color: #555; font-weight: 700;">{{ round($expensePercent) }}% dari total</div>
                </div>
            </div>
        </div>
    </div>

    <div class="tips-card">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
            <div style="background: var(--montera-red); width: 25px; height: 25px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-lightbulb" style="color: white; font-size: 12px;"></i>
            </div>
            <span style="font-size: 11px; font-weight: 900; color: white; letter-spacing: 1px;">STRATEGI KEUANGAN</span>
        </div>
        <p style="font-size: 0.85rem; color: #888; line-height: 1.6; margin: 0;">
            @php
                $ratio = $totalIncome > 0 ? ($totalExpense / $totalIncome) : ($totalExpense > 0 ? 2 : 0);
            @endphp

            @if($totalIncome == 0 && $totalExpense == 0)
                Mulai catat transaksi untuk mendapatkan insight keuangan otomatis di sini.
            @elseif($ratio > 1)
                Kondisi <strong style="color: var(--montera-red);">Defisit</strong>. Pengeluaran melebihi pemasukan. Segera tinjau ulang pengeluaran variabel Anda bulan ini.
            @elseif($ratio >= 0.5)
                Pengeluaran <strong style="color: #f1c40f;">Cukup Tinggi</strong>. Pastikan setidaknya 20% pemasukan dialokasikan untuk dana darurat sebelum konsumsi lainnya.
            @else
                Kesehatan keuangan <strong style="color: #22c55e;">Sangat Baik</strong>. Anda berhasil menyisihkan lebih dari 50% pemasukan. Pertahankan ritme ini!
            @endif
        </p>
    </div>

    <div class="modal-filter" id="filterModal">
        <div class="filter-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h3 style="margin: 0; font-weight: 900; color: white;">Filter Periode</h3>
                <i class="fa-solid fa-xmark" onclick="toggleFilterModal(false)" style="color: #555; cursor: pointer;"></i>
            </div>
            <form action="{{ route('laporan') }}" method="GET">
                <div class="filter-input-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 10px; color: #555; font-weight: 800; margin-bottom: 8px;">DARI</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" required 
                        style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 15px; outline: none;">
                </div>
                <div class="filter-input-group" style="margin-bottom: 35px;">
                    <label style="display: block; font-size: 10px; color: #555; font-weight: 800; margin-bottom: 8px;">SAMPAI</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" required
                        style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 15px; outline: none;">
                </div>
                <button type="submit" style="width: 100%; background: var(--montera-red); color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900; cursor: pointer;">
                    Tampilkan Laporan
                </button>
            </form>
        </div>
    </div>
</div>

@include('partials.modal_input') 
@endsection

@section('scripts')
<script>
    function toggleFilterModal(show) {
        const modal = document.getElementById('filterModal');
        if(show) {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
        } else {
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }
    }
</script>
@endsection