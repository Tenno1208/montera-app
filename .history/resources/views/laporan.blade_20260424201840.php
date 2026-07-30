@extends('layouts.app')

@section('styles')
<style>
    .report-container { padding: 20px; padding-bottom: 100px; }
    
    /* 1. HEADER & FILTER ICONS */
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
    
    /* 2. STAT CARD & CHART (Sama dengan welcome tapi fokus laporan) */
    .stat-card { background: #1A1A1A; padding: 40px 20px; border-radius: 35px; border: 1px solid #222; text-align: center; margin-bottom: 20px; position: relative; overflow: hidden; }
    
    .chart-box { 
        position: relative; width: 180px; height: 180px; margin: 0 auto; border-radius: 50%; 
        /* Grafik Dinamis berdasarkan persentase */
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
    
    .legend-item { background: #161616; padding: 18px; border-radius: 22px; border: 1px solid #222; margin-top: 15px; display: flex; justify-content: space-between; align-items: center; }

    /* 3. LIST TRANSAKSI (Gaya Welcome) */
    .section-title { padding: 20px 5px 15px; font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 1px; font-weight: 800; }
    .transaction-item { 
        background: #1A1A1A; padding: 18px; border-radius: 25px; 
        display: flex; align-items: center; margin-bottom: 12px; 
        border: 1px solid #222; transition: all 0.2s ease; cursor: pointer;
    }
    .transaction-item:active { transform: scale(0.95); background: #222; }

    /* 4. BOTTOM SHEET DETAIL */
    .detail-modal {
        position: fixed; inset: 0; background: rgba(0,0,0,0.8);
        z-index: 2000; display: none; align-items: flex-end; backdrop-filter: blur(4px);
    }
    .detail-modal.active { display: flex; }
    .detail-content {
        background: #121212; width: 100%; border-radius: 35px 35px 0 0;
        padding: 30px; border-top: 2px solid #222;
        transform: translateY(100%); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .detail-modal.active .detail-content { transform: translateY(0); }
    .pull-bar { width: 50px; height: 5px; background: #333; border-radius: 10px; margin: 0 auto 25px; }
    .detail-info-row { display: flex; justify-content: space-between; padding: 18px 0; border-bottom: 1px solid #1a1a1a; }
    .detail-info-row span:first-child { color: #555; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
    .detail-info-row span:last-child { color: white; font-weight: 700; }

    .btn-submit { width: 100%; background: var(--montera-red); color: white; border: none; padding: 18px; border-radius: 18px; font-weight: 900; transition: 0.3s; }

    /* Modal Filter */
    .modal-filter { position: fixed; inset: 0; background: rgba(0,0,0,0.9); z-index: 1500; display: none; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(10px); }
    .modal-filter.active { display: flex; }
    .filter-card { background: #121212; width: 100%; max-width: 350px; border-radius: 35px; padding: 35px; border: 1px solid #222; }
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
                <a href="{{ route('laporan') }}" class="btn-filter-icon reset"><i class="fa-solid fa-rotate-left"></i></a>
            @endif
            <div class="btn-filter-icon" onclick="toggleFilterModal(true)"><i class="fa-solid fa-calendar-days"></i></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="chart-box">
            <div class="chart-inner">
                <span style="font-size: 28px; font-weight: 900; color: white;">{{ round($expensePercent) }}%</span>
                <small style="font-size: 8px; color: var(--montera-red); font-weight: 800; letter-spacing: 1px;">PENGELUARAN</small>
            </div>
        </div>
        
        <div style="margin-top: 35px;">
            <div class="legend-item">
                <span style="font-size: 12px; color: #aaa; font-weight: 600;">Pemasukan</span>
                <span style="font-weight: 900; color: #22c55e;">+Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </div>
            <div class="legend-item">
                <span style="font-size: 12px; color: #aaa; font-weight: 600;">Pengeluaran</span>
                <span style="font-weight: 900; color: white;">-Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="section-title">Detail Transaksi Periode Ini</div>
    <div class="transaction-list">
        @forelse($transactions ?? [] as $item)
            <div class="transaction-item" onclick="showDetail(
                '{{ $item->title }}', '{{ $item->type }}', 
                '{{ number_format($item->amount, 0, ',', '.') }}', '{{ $item->category }}', 
                '{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}',
                '{{ $item->description ?? 'Tidak ada catatan' }}'
            )">
                <div style="width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; background: rgba(255,255,255,0.03);">
                    <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}" 
                       style="color: {{ $item->type == 'income' ? '#22c55e' : 'var(--montera-red)' }}"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 0.9rem; font-weight: 800; margin: 0; color: white;">{{ $item->title }}</p>
                    <p style="font-size: 0.65rem; color: #555; text-transform: uppercase;">{{ $item->category }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 0.95rem; font-weight: 900; color: {{ $item->type == 'income' ? '#22c55e' : '#FFF' }}">
                        {{ number_format($item->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @empty
            <p style="text-align: center; color: #444; padding: 20px;">Data tidak ditemukan.</p>
        @endforelse
    </div>

    <div class="detail-modal" id="detailModal" onclick="closeDetail()">
        <div class="detail-content" onclick="event.stopPropagation()">
            <div class="pull-bar"></div>
            <div style="text-align: center; margin-bottom: 30px;">
                <div id="detIconBox" style="width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i id="detIcon" class="fa-solid fa-2xl"></i>
                </div>
                <h2 id="detAmount" style="font-weight: 900; font-size: 1.8rem; margin: 0;"></h2>
                <p id="detTitle" style="color: #555; font-weight: 700; margin-top: 5px; text-transform: uppercase; font-size: 0.8rem;"></p>
            </div>
            <div class="detail-info-row"><span>Kategori</span><span id="detCategory"></span></div>
            <div class="detail-info-row"><span>Tanggal</span><span id="detDate"></span></div>
            <div class="detail-info-row"><span>Catatan</span><span id="detDesc"></span></div>
            <button onclick="closeDetail()" class="btn-submit" style="margin-top: 30px; background: #1A1A1A; border: 1px solid #333;">TUTUP</button>
        </div>
    </div>

    <div class="modal-filter" id="filterModal">
        <div class="filter-card">
            <h3 style="text-align: center; margin-bottom: 30px; font-weight: 900; color: white;">Atur Periode</h3>
            <form action="{{ route('laporan') }}" method="GET">
                <input type="date" name="start_date" value="{{ request('start_date') }}" required style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 15px; margin-bottom: 15px;">
                <input type="date" name="end_date" value="{{ request('end_date') }}" required style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 15px; margin-bottom: 30px;">
                <button type="submit" class="btn-submit">Terapkan Filter</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFilterModal(show) { document.getElementById('filterModal').classList.toggle('active', show); }

    function showDetail(title, type, amount, category, date, desc) {
        const modal = document.getElementById('detailModal');
        const iconBox = document.getElementById('detIconBox');
        const icon = document.getElementById('detIcon');
        const amountEl = document.getElementById('detAmount');

        if(type === 'income') {
            iconBox.style.background = 'rgba(34, 197, 94, 0.1)';
            icon.style.color = '#22c55e';
            icon.className = 'fa-solid fa-arrow-trend-up fa-2xl';
            amountEl.style.color = '#22c55e';
            amountEl.innerText = '+ Rp ' + amount;
        } else {
            iconBox.style.background = 'rgba(230, 0, 0, 0.1)';
            icon.style.color = 'var(--montera-red)';
            icon.className = 'fa-solid fa-arrow-trend-down fa-2xl';
            amountEl.style.color = 'white';
            amountEl.innerText = '- Rp ' + amount;
        }

        document.getElementById('detTitle').innerText = title;
        document.getElementById('detCategory').innerText = category;
        document.getElementById('detDate').innerText = date;
        document.getElementById('detDesc').innerText = desc;

        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');
        modal.classList.remove('active');
        setTimeout(() => modal.style.display = 'none', 300);
    }
</script>
@endsection