@extends('layouts.app')

@section('styles')
<style>
    .report-container { padding: 20px; }
    
    /* Filter Laporan */
    .filter-report { display: flex; gap: 10px; margin-bottom: 25px; background: #161616; padding: 12px; border-radius: 20px; border: 1px solid #222; }
    .filter-report input { flex: 1; background: transparent; border: none; color: white; font-size: 11px; outline: none; }
    .btn-update { background: #D32F2F; color: white; border: none; padding: 8px 15px; border-radius: 12px; font-size: 10px; font-weight: bold; cursor: pointer; }

    .stat-card { 
        background: #1A1A1A; padding: 30px 20px; border-radius: 35px; 
        margin-bottom: 20px; border: 1px solid #222; text-align: center;
    }
    
    /* Donut Chart Style */
    .chart-box {
        position: relative; width: 180px; height: 180px; margin: 20px auto; border-radius: 50%;
        background: conic-gradient(
            #22c55e 0% {{ $incomePercent }}%, 
            #D32F2F {{ $incomePercent }}% 100%
        );
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 30px rgba(211, 47, 47, 0.1);
    }
    .chart-inner {
        width: 135px; height: 135px; background: #1A1A1A; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
    }
    .chart-inner span { font-size: 20px; font-weight: 900; color: white; }
    .chart-inner small { font-size: 8px; color: #555; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; }

    .legend-grid { display: grid; grid-template-cols: 1fr 1fr; gap: 12px; margin-top: 30px; }
    .legend-item { background: #161616; padding: 15px; border-radius: 22px; border: 1px solid #222; }
    .legend-label { font-size: 9px; color: #555; font-weight: 800; margin-bottom: 5px; display: block; text-transform: uppercase; }
    .legend-value { font-size: 0.85rem; font-weight: 800; }
    
    .tips-card {
        background: linear-gradient(to right, #1A1A1A, #0F0F0F);
        padding: 25px; border-radius: 25px; border-left: 5px solid #D32F2F; margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="report-container">
    <h2 style="margin-bottom: 5px; font-weight: 900; letter-spacing: -1px;">Analisis <span style="color: #D32F2F;">Kas</span></h2>
    <p style="font-size: 11px; color: #555; margin-bottom: 25px;">Tinjau struktur keuangan Anda berdasarkan periode.</p>

    <form action="{{ route('laporan') }}" method="GET" class="filter-report">
        <input type="date" name="start_date" value="{{ request('start_date') }}">
        <i class="fa-solid fa-arrow-right" style="color: #333; font-size: 10px; margin-top: 5px;"></i>
        <input type="date" name="end_date" value="{{ request('end_date') }}">
        <button type="submit" class="btn-update">UPDATE</button>
    </form>

    <div class="stat-card">
        <div class="chart-box">
            <div class="chart-inner">
                <small>Struktur</small>
                <span>{{ round($expensePercent) }}%</span>
                <small>Pengeluaran</small>
            </div>
        </div>

        <div class="legend-grid">
            <div class="legend-item">
                <span class="legend-label">Total Masuk</span>
                <span class="legend-value" style="color: #22c55e;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </div>
            <div class="legend-item">
                <span class="legend-label">Total Keluar</span>
                <span class="legend-value" style="color: #ff4d4d;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="tips-card">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
            <i class="fa-solid fa-lightbulb" style="color: #D32F2F;"></i>
            <span style="font-size: 11px; font-weight: 900; color: white; text-transform: uppercase;">Montera Intelligence</span>
        </div>
        <p style="font-size: 0.85rem; color: #aaa; line-height: 1.5;">
            @if($totalExpense > $totalIncome)
                Waspada! Pengeluaran Anda <strong>{{ round($expensePercent - 50) }}% lebih tinggi</strong> dari batas aman. Segera kurangi pengeluaran kategori tidak mendesak.
            @elseif($totalIncome > 0 && ($totalExpense / $totalIncome) < 0.5)
                Luar biasa! Anda berhasil menghemat <strong>lebih dari 50%</strong> pemasukan. Ini saat yang tepat untuk menambah investasi.
            @else
                Kondisi keuangan Anda stabil. Pertahankan rasio pengeluaran agar tidak melebihi pemasukan di sisa bulan ini.
            @endif
        </p>
    </div>
</div>

@include('partials.modal_input') 
@endsection