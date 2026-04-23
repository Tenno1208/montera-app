@extends('layouts.app')

@section('styles')
<style>
    .report-container { padding: 20px; }
    
    /* Header & Filter Icon */
    .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .btn-filter-icon { 
        width: 45px; height: 45px; background: #1A1A1A; border: 1px solid #222; 
        border-radius: 15px; display: flex; align-items: center; justify-content: center; 
        color: #D32F2F; cursor: pointer; transition: 0.3s;
    }
    .btn-filter-icon:active { transform: scale(0.9); background: #222; }
    
    /* Chart Section */
    .stat-card { background: #1A1A1A; padding: 40px 20px; border-radius: 35px; border: 1px solid #222; text-align: center; margin-bottom: 20px; }
    .chart-box { 
        position: relative; width: 180px; height: 180px; margin: 0 auto; border-radius: 50%; 
        background: conic-gradient(#22c55e 0% {{ $incomePercent }}%, #D32F2F {{ $incomePercent }}% 100%); 
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 30px rgba(211, 47, 47, 0.1);
    }
    .chart-inner { 
        width: 135px; height: 135px; background: #1A1A1A; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; flex-direction: column; 
        box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
    }
    
    /* Legend Row */
    .legend-item { background: #161616; padding: 18px; border-radius: 22px; border: 1px solid #222; margin-top: 15px; display: flex; justify-content: space-between; align-items: center; }
    
    /* MODAL FILTER STYLE (PENTING: Tadi Bagian Ini yang Kurang Lengkap) */
    .modal-filter { 
        position: fixed; inset: 0; background: rgba(0,0,0,0.9); 
        z-index: 2000; display: none; align-items: center; justify-content: center; 
        padding: 20px; backdrop-filter: blur(10px); 
    }
    .modal-filter.active { display: flex; }
    
    .filter-card { 
        background: #121212; width: 100%; max-width: 350px; 
        border-radius: 35px; padding: 35px; border: 1px solid #222; 
        animation: modalFade 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes modalFade {
        from { opacity: 0; transform: translateY(20px) scale(0.9); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .filter-input-group { margin-bottom: 20px; }
    .filter-input-group label { display: block; font-size: 10px; color: #555; font-weight: 800; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
    .filter-input-group input { 
        width: 100%; background: #0A0A0A; border: 1px solid #222; 
        color: white; padding: 15px; border-radius: 15px; font-size: 14px; outline: none;
    }
    .filter-input-group input:focus { border-color: #D32F2F; }

    /* AI Tips */
    .tips-card {
        background: linear-gradient(to right, #1A1A1A, #0F0F0F);
        padding: 25px; border-radius: 25px; border-left: 5px solid #D32F2F; margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="report-container">
    <div class="report-header">
        <div>
            <h2 style="font-weight: 900; letter-spacing: -1.5px; margin: 0; font-size: 1.8rem;">Analisis <span style="color: #D32F2F;">Kas</span></h2>
            <p style="font-size: 10px; color: #555; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; margin-top: 5px;">
                <i class="fa-solid fa-clock-rotate-left"></i> 
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M') . ' - ' . \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Semua Periode' }}
            </p>
        </div>
        <div class="btn-filter-icon" onclick="toggleFilterModal(true)">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="chart-box">
            <div class="chart-inner">
                <span style="font-size: 28px; font-weight: 900; color: white;">{{ round($expensePercent) }}%</span>
                <small style="font-size: 8px; color: #D32F2F; font-weight: 800; letter-spacing: 1px;">PENGELUARAN</small>
            </div>
        </div>
        
        <div style="margin-top: 35px;">
            <div class="legend-item">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                    <span style="font-size: 12px; color: #aaa; font-weight: 600;">Pemasukan</span>
                </div>
                <span style="font-weight: 900; color: #22c55e;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </div>
            <div class="legend-item">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 8px; height: 8px; background: #D32F2F; border-radius: 50%;"></div>
                    <span style="font-size: 12px; color: #aaa; font-weight: 600;">Pengeluaran</span>
                </div>
                <span style="font-weight: 900; color: white;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="tips-card">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
            <i class="fa-solid fa-wand-magic-sparkles" style="color: #D32F2F;"></i>
            <span style="font-size: 10px; font-weight: 900; color: white; text-transform: uppercase;">Montera Insight</span>
        </div>
        <p style="font-size: 0.8rem; color: #666; line-height: 1.6; margin: 0;">
            @if($totalExpense > $totalIncome)
                Dompetmu dalam bahaya! Pengeluaran melebihi pemasukan. Coba kurangi belanja yang tidak perlu.
            @elseif($totalIncome > 0 && ($totalExpense / $totalIncome) < 0.4)
                Keren! Tabunganmu bulan ini sangat sehat. Teruskan pola hidup hematmu!
            @else
                Kondisi keuanganmu cukup stabil. Jangan lupa sisihkan untuk dana darurat ya!
            @endif
        </p>
    </div>

    <div class="modal-filter" id="filterModal">
        <div class="filter-card">
            <h3 style="text-align: center; margin-bottom: 30px; font-weight: 900; color: white; letter-spacing: -1px;">Atur Periode</h3>
            
            <form action="{{ route('laporan') }}" method="GET">
                <div class="filter-input-group">
                    <label>Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" required>
                </div>
                
                <div class="filter-input-group" style="margin-bottom: 35px;">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" required>
                </div>
                
                <button type="submit" style="width: 100%; background: #D32F2F; color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 10px 20px rgba(211, 47, 47, 0.2);">
                    Terapkan Filter
                </button>
                
                <button type="button" onclick="toggleFilterModal(false)" style="width: 100%; background: none; border: none; color: #444; margin-top: 15px; font-weight: bold; font-size: 12px; cursor: pointer;">
                    Tutup
                </button>
            </form>
        </div>
    </div>
</div>

@include('partials.modal_input') 
@endsection

@section('scripts')
<script>
    // Fungsi untuk memicu modal filter
    function toggleFilterModal(show) {
        const modal = document.getElementById('filterModal');
        if (show) {
            modal.classList.add('active');
        } else {
            modal.classList.remove('active');
        }
    }

    // Menutup modal jika klik di area background
    window.onclick = function(event) {
        const modal = document.getElementById('filterModal');
        if (event.target == modal) {
            toggleFilterModal(false);
        }
    }
</script>
@endsection