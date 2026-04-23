@extends('layouts.app')

@section('styles')
<style>
    .report-container { padding: 20px; }
    .stat-card { 
        background: #1A1A1A; 
        padding: 25px; 
        border-radius: 30px; 
        margin-bottom: 20px; 
        border: 1px solid #222;
        text-align: center;
    }
    .chart-box {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 30px auto;
        border-radius: 50%;
        background: conic-gradient(
            #22c55e 0% {{ $incomePercent }}%, 
            #D32F2F {{ $incomePercent }}% 100%
        );
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .chart-inner {
        width: 110px;
        height: 110px;
        background: #1A1A1A;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        color: #555;
        text-align: center;
    }
    .legend-item {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        background: #161616;
        border-radius: 20px;
        margin-bottom: 10px;
    }
    .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 8px; }
</style>
@endsection

@section('content')
<div class="report-container">
    <h2 style="margin-bottom: 20px; font-weight: 800;">Analisis Keuangan</h2>

    <div class="stat-card">
        <p style="font-size: 12px; color: #555; text-transform: uppercase; letter-spacing: 2px;">Struktur Kas</p>
        
        <div class="chart-box">
            <div class="chart-inner">
                MONTERA<br>STATS
            </div>
        </div>

        <div style="display: flex; justify-content: space-around; margin-top: 20px;">
            <div>
                <p style="font-size: 10px; color: #555;">PEMASUKAN</p>
                <p style="color: #22c55e; font-weight: bold;">{{ round($incomePercent) }}%</p>
            </div>
            <div>
                <p style="font-size: 10px; color: #555;">PENGELUARAN</p>
                <p style="color: #D32F2F; font-weight: bold;">{{ round($expensePercent) }}%</p>
            </div>
        </div>
    </div>

    <div class="legend-item">
        <span><span class="dot" style="background: #22c55e;"></span> Pemasukan</span>
        <span style="font-weight: bold; color: #22c55e;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
    </div>

    <div class="legend-item">
        <span><span class="dot" style="background: #D32F2F;"></span> Pengeluaran</span>
        <span style="font-weight: bold; color: #ff4d4d;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
    </div>

    <div class="stat-card" style="margin-top: 30px; background: linear-gradient(to right, #1a1a1a, #000);">
        <p style="font-size: 11px; color: #D32F2F; font-weight: bold;">TIPS MONTERA</p>
        <p style="font-size: 13px; margin-top: 10px; color: #aaa;">
            @if($totalExpense > $totalIncome)
                Pengeluaranmu lebih besar dari pemasukan. Yuk, lebih hemat lagi!
            @else
                Keuanganmu sehat! Pertahankan rasio menabungmu bulan ini.
            @endif
        </p>
    </div>
</div>

@include('partials.modal_input') 
@endsection

@section('scripts')
<script>
    function openModal() { document.getElementById('modalTransaction').classList.add('active'); }
    function closeModal() { document.getElementById('modalTransaction').classList.remove('active'); }
</script>
@endsection