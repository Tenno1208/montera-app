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
        text-decoration: none;
    }
    .btn-filter-icon.reset { color: #555; } 
    .btn-filter-icon.pdf { color: #f1c40f; border-color: rgba(241, 196, 15, 0.2); }
    .btn-filter-icon:active { transform: scale(0.9); background: #222; }
    
    /* Stat Card */
    .stat-card { background: #1A1A1A; padding: 40px 20px; border-radius: 35px; border: 1px solid #222; text-align: center; margin-bottom: 20px; position: relative; overflow: hidden; }
    
    /* Background Glow Effect */
    .stat-card::after {
        content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(var(--montera-red-rgb), 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    .chart-box { 
        position: relative; width: 180px; height: 180px; margin: 0 auto; border-radius: 50%; 
        background: conic-gradient(#22c55e 0% {{ $incomePercent }}%, var(--montera-red) {{ $incomePercent }}% 100%); 
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 30px rgba(var(--montera-red-rgb), 0.15);
        z-index: 1;
    }
    .chart-inner { 
        width: 135px; height: 135px; background: #1A1A1A; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; flex-direction: column; 
        box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
    }
    
    /* Legend Row */
    .legend-item { background: #161616; padding: 18px; border-radius: 22px; border: 1px solid #222; margin-top: 15px; display: flex; justify-content: space-between; align-items: center; }
    
    /* Modal Filter Style */
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

    .filter-input-group label { display: block; font-size: 10px; color: #555; font-weight: 800; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
    .filter-input-group input { 
        width: 100%; background: #0A0A0A; border: 1px solid #222; 
        color: white; padding: 15px; border-radius: 15px; font-size: 14px; outline: none;
    }

    /* AI Tips */
    .tips-card {
        background: linear-gradient(to right, #1A1A1A, #0F0F0F);
        padding: 25px; border-radius: 25px; 
        border-left: 5px solid var(--montera-red);
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="report-container">
    <div class="report-header">
        <div>
            <h2 style="font-weight: 900; letter-spacing: -1.5px; margin: 0; font-size: 1.8rem;">Analisis <span style="color: var(--montera-red);">Kas</span></h2>
            <p style="font-size: 10px; color: #555; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; margin-top: 5px;">
                <i class="fa-solid fa-clock-rotate-left"></i> 
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M') . ' - ' . \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Semua Periode' }}
            </p>
        </div>
        
        <div class="header-actions">
            <a href="{{ route('laporan.pdf', request()->query()) }}" class="btn-filter-icon pdf" title="Download PDF">
                <i class="fa-solid fa-file-pdf"></i>
            </a>

            @if(request('start_date'))
                <a href="{{ route('laporan') }}" class="btn-filter-icon reset" title="Reset Filter">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            @endif

            <div class="btn-filter-icon" onclick="toggleFilterModal(true)" title="Atur Periode">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="chart-box">
            <div class="chart-inner">
                <span style="font-size: 28px; font-weight: 900; color: white;">{{ round($expensePercent) }}%</span>
                <small style="font-size: 8px; color: var(--montera-red); font-weight: 800; letter-spacing: 1px;">PENGELUARAN</small>
            </div>
        </div>
        
        <div style="margin-top: 35px; position: relative; z-index: 1;">
            <div class="legend-item">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                    <span style="font-size: 12px; color: #aaa; font-weight: 600;">Pemasukan</span>
                </div>
                <span style="font-weight: 900; color: #22c55e;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </div>
            <div class="legend-item">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 8px; height: 8px; background: var(--montera-red); border-radius: 50%;"></div>
                    <span style="font-size: 12px; color: #aaa; font-weight: 600;">Pengeluaran</span>
                </div>
                <span style="font-weight: 900; color: white;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="tips-card">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
            <i class="fa-solid fa-wand-magic-sparkles" style="color: var(--montera-red);"></i>
            <span style="font-size: 10px; font-weight: 900; color: white; text-transform: uppercase; letter-spacing: 1px;">Montera Insight</span>
        </div>
        <p style="font-size: 0.82rem; color: #aaa; line-height: 1.6; margin: 0;">
            @php
                $ratio = $totalIncome > 0 ? ($totalExpense / $totalIncome) : ($totalExpense > 0 ? 2 : 0);
                $savings = $totalIncome - $totalExpense;
            @endphp

            @if($totalIncome == 0 && $totalExpense == 0)
                Data masih kosong nih. Yuk, mulai catat transaksi pertamamu!
            @elseif($totalIncome == 0 && $totalExpense > 0)
                <strong style="color: var(--montera-red);">Bahaya!</strong> Pengeluaran tanpa pemasukan terdeteksi.
            @elseif($ratio > 1)
                <strong style="color: var(--montera-red);">Defisit!</strong> Pengeluaranmu lebih besar dari pemasukan.
            @elseif($ratio >= 0.5)
                <strong style="color: #3498db;">Stabil.</strong> Kamu menghabiskan sekitar setengah dari pemasukanmu.
            @else
                <strong style="color: #22c55e;">Luar Biasa!</strong> Surplus sebesar <strong>Rp {{ number_format($savings, 0, ',', '.') }}</strong> tersedia.
            @endif
        </p>
    </div>

    <div class="modal-filter" id="filterModal">
        <div class="filter-card">
            <h3 style="text-align: center; margin-bottom: 30px; font-weight: 900; color: white;">Atur Periode</h3>
            <form action="{{ route('laporan') }}" method="GET">
                <div class="filter-input-group">
                    <label>Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" required>
                </div>
                <div class="filter-input-group" style="margin-bottom: 35px; margin-top: 15px;">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" required>
                </div>
                <button type="submit" style="width: 100%; background: var(--montera-red); color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900; cursor: pointer;">
                    Terapkan Filter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFilterModal(show) {
        document.getElementById('filterModal').classList.toggle('active', show);
    }
</script>
@endsection