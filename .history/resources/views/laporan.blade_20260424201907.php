@extends('layouts.app')

@section('styles')
<style>
    .report-container { padding: 20px; }
    
    /* Header & Filter Icons */
    .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .header-actions { display: flex; gap: 10px; } /* Wrapper untuk tombol reset & filter */

    .btn-filter-icon { 
        width: 45px; height: 45px; background: #1A1A1A; border: 1px solid #222; 
        border-radius: 15px; display: flex; align-items: center; justify-content: center; 
        color: #D32F2F; cursor: pointer; transition: 0.3s;
    }
    .btn-filter-icon.reset { color: #555; } /* Warna berbeda untuk reset */
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
    
    /* MODAL FILTER STYLE */
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
        
        <div class="header-actions">
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
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
            <i class="fa-solid fa-wand-magic-sparkles" style="color: #D32F2F;"></i>
            <span style="font-size: 10px; font-weight: 900; color: white; text-transform: uppercase; letter-spacing: 1px;">Montera Insight</span>
        </div>
        <p style="font-size: 0.82rem; color: #aaa; line-height: 1.6; margin: 0;">
            @php
                $ratio = $totalIncome > 0 ? ($totalExpense / $totalIncome) : ($totalExpense > 0 ? 2 : 0);
                $savings = $totalIncome - $totalExpense;
            @endphp

            @if($totalIncome == 0 && $totalExpense == 0)
                Data masih kosong nih. Yuk, mulai catat transaksi pertamamu untuk melihat analisis keuangan di sini!
            @elseif($totalIncome == 0 && $totalExpense > 0)
                <strong style="color: #ff4d4d;">Bahaya!</strong> Kamu tercatat melakukan pengeluaran sebesar <strong>Rp {{ number_format($totalExpense, 0, ',', '.') }}</strong> tanpa adanya pemasukan. Segera cari sumber kas agar saldo tidak minus!
            @elseif($ratio > 1)
                <strong style="color: #ff4d4d;">Defisit Terdeteksi!</strong> Pengeluaranmu <strong>{{ round(($ratio - 1) * 100) }}% lebih besar</strong> dari pemasukan. Kamu menggunakan dana cadangan. Kurangi belanja non-prioritas sekarang juga!
            @elseif($ratio >= 0.9)
                <strong style="color: #f1c40f;">Zona Kuning!</strong> Sisa uangmu hanya tinggal <strong>{{ round((1 - $ratio) * 100) }}%</strong>. Sangat tipis! Hindari pengeluaran besar hingga pemasukan berikutnya tiba.
            @elseif($ratio >= 0.5)
                <strong style="color: #3498db;">Cukup Stabil.</strong> Kamu telah menghabiskan sekitar setengah dari pemasukanmu. Pastikan sisanya dialokasikan untuk tabungan atau investasi sebelum habis terpakai.
            @elseif($ratio > 0 && $ratio < 0.5)
                <strong style="color: #22c55e;">Luar Biasa!</strong> Pengeluaranmu sangat terjaga (di bawah 50%). Kamu punya surplus <strong>Rp {{ number_format($savings, 0, ',', '.') }}</strong>. Waktu yang tepat untuk <i>self-reward</i> tipis-tipis atau tambah investasi!
            @elseif($totalIncome > 0 && $totalExpense == 0)
                <strong style="color: #22c55e;">Sempurna!</strong> Pemasukan utuh 100%. Belum ada pengeluaran tercatat. Pertahankan disiplin ini agar target finansialmu cepat tercapai!
            @endif
        </p>
        
        @if($totalIncome > 0 && $ratio < 0.8)
            <div style="margin-top: 15px; padding-top: 12px; border-top: 1px solid #222; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-check" style="color: #22c55e; font-size: 12px;"></i>
                <span style="font-size: 10px; color: #555; font-weight: bold; text-transform: uppercase;">Skor Kesehatan: Baik</span>
            </div>
        @elseif($totalIncome > 0)
            <div style="margin-top: 15px; padding-top: 12px; border-top: 1px solid #222; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-exclamation" style="color: #D32F2F; font-size: 12px;"></i>
                <span style="font-size: 10px; color: #555; font-weight: bold; text-transform: uppercase;">Skor Kesehatan: Perlu Evaluasi</span>
            </div>
        @endif
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
    function toggleFilterModal(show) {
        const modal = document.getElementById('filterModal');
        if (show) {
            modal.classList.add('active');
        } else {
            modal.classList.remove('active');
        }
    }

    window.onclick = function(event) {
        const modal = document.getElementById('filterModal');
        if (event.target == modal) {
            toggleFilterModal(false);
        }
    }
</script>
@endsection