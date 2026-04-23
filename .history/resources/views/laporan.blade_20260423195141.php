@extends('layouts.app')

@section('styles')
<style>
    .report-container { padding: 20px; }
    .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .btn-filter-icon { width: 45px; height: 45px; background: #1A1A1A; border: 1px solid #222; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: #D32F2F; cursor: pointer; }
    
    .stat-card { background: #1A1A1A; padding: 40px 20px; border-radius: 35px; border: 1px solid #222; text-align: center; }
    .chart-box { position: relative; width: 180px; height: 180px; margin: 0 auto; border-radius: 50%; background: conic-gradient(#22c55e 0% {{ $incomePercent }}%, #D32F2F {{ $incomePercent }}% 100%); display: flex; align-items: center; justify-content: center; }
    .chart-inner { width: 135px; height: 135px; background: #1A1A1A; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-direction: column; }
    
    .legend-item { background: #161616; padding: 18px; border-radius: 22px; border: 1px solid #222; margin-top: 15px; display: flex; justify-content: space-between; }
</style>
@endsection

@section('content')
<div class="report-container">
    <div class="report-header">
        <div>
            <h2 style="font-weight: 900; letter-spacing: -1px; margin: 0;">Analisis <span style="color: #D32F2F;">Kas</span></h2>
            <p style="font-size: 10px; color: #555; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">
                {{ request('start_date') ? request('start_date').' s/d '.request('end_date') : 'Semua Periode' }}
            </p>
        </div>
        <div class="btn-filter-icon" onclick="toggleFilterModal(true)">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="chart-box">
            <div class="chart-inner">
                <span style="font-size: 24px; font-weight: 900;">{{ round($expensePercent) }}%</span>
                <small style="font-size: 8px; color: #555; font-weight: 800;">PENGELUARAN</small>
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <div class="legend-item">
                <span style="font-size: 12px; color: #22c55e; font-weight: bold;">Pemasukan</span>
                <span style="font-weight: 900;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </div>
            <div class="legend-item">
                <span style="font-size: 12px; color: #D32F2F; font-weight: bold;">Pengeluaran</span>
                <span style="font-weight: 900;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="modal-filter" id="filterModal">
        <div class="filter-card">
            <h3 style="text-align: center; margin-bottom: 25px; font-weight: 900;">FILTER LAPORAN</h3>
            <form action="{{ route('laporan') }}" method="GET">
                <div style="margin-bottom: 20px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800;">DARI</label>
                    <input type="date" name="start_date" class="filter-input" value="{{ request('start_date') }}" style="width:100%; background:#1A1A1A; border:1px solid #333; color:white; padding:15px; border-radius:15px; margin-top:5px;">
                </div>
                <div style="margin-bottom: 30px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800;">SAMPAI</label>
                    <input type="date" name="end_date" class="filter-input" value="{{ request('end_date') }}" style="width:100%; background:#1A1A1A; border:1px solid #333; color:white; padding:15px; border-radius:15px; margin-top:5px;">
                </div>
                <button type="submit" class="btn-submit" style="width:100%; background:#D32F2F; color:white; border:none; padding:18px; border-radius:18px; font-weight:900;">LIHAT ANALISIS</button>
                <button type="button" onclick="toggleFilterModal(false)" style="width:100%; background:none; border:none; color:#444; margin-top:15px; font-weight:bold;">TUTUP</button>
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