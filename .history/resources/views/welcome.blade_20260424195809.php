@extends('layouts.app')

@section('styles')
<style>
    /* 1. BALANCE CARD */
    .balance-card { 
        margin: 10px 20px; 
        padding: 30px; 
        border-radius: 35px; 
        background: linear-gradient(135deg, var(--montera-red) 0%, rgba(var(--montera-red-rgb), 0.5) 50%, #121212 100%); 
        box-shadow: 0 20px 40px rgba(var(--montera-red-rgb), 0.3); 
        position: relative; 
        overflow: hidden; 
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .balance-card img { position: absolute; right: -20px; bottom: -20px; width: 150px; opacity: 0.1; transform: rotate(15deg); }
    .card-balance { font-size: 2.2rem; font-weight: 800; margin: 5px 0 25px 0; color: white; }
    
    .card-stats { display: grid; grid-template-cols: 1fr 1fr; gap: 15px; }
    .stat-box { 
        background: rgba(255, 255, 255, 0.1); 
        padding: 12px; 
        border-radius: 18px; 
        border: 1px solid rgba(255, 255, 255, 0.1); 
    }
    
    /* 2. HEADER & FILTERS */
    .section-title { padding: 30px 25px 15px; display: flex; justify-content: space-between; align-items: center; }
    .section-title h3 { font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 1px; font-weight: 800; }
    
    .btn-open-filter { 
        width: 40px; height: 40px; border-radius: 12px; background: #161616; 
        border: 1px solid #222; color: var(--montera-red); display: flex; 
        align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; 
    }
    .btn-open-filter:active { transform: scale(0.9); }

    /* 3. TRANSACTION ITEMS */
    .date-divider { 
        padding: 15px 25px 10px; font-size: 10px; color: var(--montera-red); 
        font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; 
        display: flex; align-items: center; gap: 10px; 
    }
    .date-divider::after { content: ''; flex: 1; height: 1px; background: #222; }
    
    .transaction-item { 
        background: #1A1A1A; padding: 18px; border-radius: 25px; 
        display: flex; align-items: center; margin: 0 20px 12px; 
        border: 1px solid #222; transition: all 0.2s ease;
        cursor: pointer;
    }
    .transaction-item:active { transform: scale(0.95); background: #222; }

    /* 4. MODAL FILTER & BASE */
    .modal-filter { 
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); 
        z-index: 1500; display: none; align-items: center; 
        justify-content: center; padding: 20px; backdrop-filter: blur(8px); 
    }
    .modal-filter.active { display: flex; }
    .filter-card { background: #121212; width: 100%; max-width: 350px; border-radius: 30px; padding: 30px; border: 1px solid #222; }
    
    .btn-submit { 
        width: 100%; background: var(--montera-red); color: white; border: none; 
        padding: 18px; border-radius: 18px; font-weight: 900; transition: 0.3s;
    }

    /* 5. BOTTOM SHEET DETAIL (NEW) */
    .detail-modal {
        position: fixed; inset: 0; background: rgba(0,0,0,0.8);
        z-index: 2000; display: none; align-items: flex-end; backdrop-filter: blur(4px);
    }
    .detail-modal.active { display: flex; }
    .detail-content {
        background: #121212; width: 100%; border-radius: 35px 35px 0 0;
        padding: 30px 30px 50px; border-top: 2px solid #222;
        transform: translateY(100%); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .detail-modal.active .detail-content { transform: translateY(0); }
    .pull-bar { width: 50px; height: 5px; background: #333; border-radius: 10px; margin: 0 auto 25px; }
    .detail-info-row {
        display: flex; justify-content: space-between; padding: 18px 0;
        border-bottom: 1px solid #1a1a1a;
    }
    .detail-info-row span:first-child { color: #555; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
    .detail-info-row span:last-child { color: white; font-weight: 700; font-size: 0.95rem; text-align: right; }
</style>
@endsection

@section('content')
    <div class="balance-card">
        <img src="{{ asset('img/logo-montera.png') }}">
        <span style="font-size: 0.7rem; text-transform: uppercase; opacity: 0.8; font-weight: 600; color: white;">Saldo Saat Ini</span>
        <div class="card-balance">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</div>
        
        <div class="card-stats">
            <div class="stat-box">
                <small style="font-size: 9px; color: #aaa; font-weight: 800;">PEMASUKAN</small><br>
                <span style="color: #22c55e; font-weight: 900; font-size: 1.1rem;">+{{ number_format($totalIncome ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="stat-box">
                <small style="font-size: 9px; color: #aaa; font-weight: 800;">PENGELUARAN</small><br>
                <span style="color: #ffffff; font-weight: 900; font-size: 1.1rem;">-{{ number_format($totalExpense ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="section-title">
        <h3>Riwayat Transaksi</h3>
        <div style="display: flex; gap: 10px;">
            @if(request('start_date'))
                <a href="{{ route('home') }}" class="btn-open-filter" style="color: #555;"><i class="fa-solid fa-rotate-left"></i></a>
            @endif
            <div class="btn-open-filter" onclick="toggleFilterModal(true)">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>
    </div>

    <div class="transaction-list">
        @php $currentDate = null; @endphp
        @forelse($transactions ?? [] as $item)
            @if($currentDate != $item->date)
                <div class="date-divider">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</div>
                @php $currentDate = $item->date; @endphp
            @endif
            
            <div class="transaction-item" onclick="showDetail(
                '{{ $item->title }}', 
                '{{ $item->type }}', 
                '{{ number_format($item->amount, 0, ',', '.') }}', 
                '{{ $item->category }}', 
                '{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}',
                '{{ $item->description ?? 'Tidak ada catatan' }}'
            )">
                <div class="icon-box" style="width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; background: rgba(255,255,255,0.03);">
                    <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}" 
                       style="color: {{ $item->type == 'income' ? '#22c55e' : 'var(--montera-red)' }}"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 0.9rem; font-weight: 800; margin: 0; color: white;">{{ $item->title }}</p>
                    <p style="font-size: 0.65rem; color: #555; text-transform: uppercase; font-weight: 700;">{{ $item->category }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 0.95rem; font-weight: 900; color: {{ $item->type == 'income' ? '#22c55e' : '#FFF' }}">
                        {{ $item->type == 'income' ? '+' : '-' }} {{ number_format($item->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px 20px;">
                <i class="fa-solid fa-box-open" style="font-size: 2rem; color: #1a1a1a; margin-bottom: 15px;"></i>
                <p style="color: #444; font-size: 0.8rem; font-weight: bold;">Belum ada catatan transaksi</p>
            </div>
        @endforelse
    </div>

    <div class="modal-filter" id="filterModal">
        <div class="filter-card">
            <h3 style="text-align: center; margin-bottom: 25px; font-weight: 900; color: white;">FILTER PERIODE</h3>
            <form action="{{ route('home') }}" method="GET">
                <div style="margin-bottom: 20px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800;">MULAARI</label>
                    <input type="date" name="start_date" class="input-control" value="{{ request('start_date') }}" style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 18px; margin-top: 8px;">
                </div>
                <div style="margin-bottom: 30px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800;">SAMPAI</label>
                    <input type="date" name="end_date" class="input-control" value="{{ request('end_date') }}" style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 18px; margin-top: 8px;">
                </div>
                <button type="submit" class="btn-submit">TERAPKAN</button>
                <button type="button" onclick="toggleFilterModal(false)" style="width: 100%; background: none; border: none; color: #444; margin-top: 15px; font-weight: bold;">BATAL</button>
            </form>
        </div>
    </div>

    <div class="detail-modal" id="detailModal" onclick="closeDetail()">
        <div class="detail-content" onclick="event.stopPropagation()">
            <div class="pull-bar"></div>
            <div style="text-align: center; margin-bottom: 30px;">
                <div id="detIconBox" style="width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i id="detIcon" class="fa-solid fa-2xl"></i>
                </div>
                <h2 id="detAmount" style="color: white; font-weight: 900; font-size: 1.8rem; margin: 0;"></h2>
                <p id="detTitle" style="color: #555; font-weight: 700; margin-top: 5px; text-transform: uppercase; font-size: 0.8rem;"></p>
            </div>

            <div class="detail-info-row">
                <span>Kategori</span>
                <span id="detCategory"></span>
            </div>
            <div class="detail-info-row">
                <span>Tanggal</span>
                <span id="detDate"></span>
            </div>
            <div class="detail-info-row">
                <span>Catatan</span>
                <span id="detDesc"></span>
            </div>

            <button onclick="closeDetail()" class="btn-submit" style="margin-top: 30px; background: #1A1A1A; border: 1px solid #333;">TUTUP</button>
        </div>
    </div>

    @include('partials.modal_input')
@endsection

@section('scripts')
<script>
    function toggleFilterModal(show) {
        document.getElementById('filterModal').classList.toggle('active', show);
    }

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