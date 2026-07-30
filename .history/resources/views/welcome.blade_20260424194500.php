@extends('layouts.app')

@section('styles')
<style>
    /* 1. BALANCE CARD - Gradasi Dinamis */
    .balance-card { 
        margin: 10px 20px; 
        padding: 30px; 
        border-radius: 35px; 
        /* Gradasi dari warna tema ke Hitam Montera */
        background: linear-gradient(135deg, var(--montera-red) 0%, rgba(var(--montera-red-rgb), 0.5) 50%, #121212 100%); 
        box-shadow: 0 20px 40px rgba(var(--montera-red-rgb), 0.3); 
        position: relative; 
        overflow: hidden; 
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .balance-card img { position: absolute; right: -20px; bottom: -20px; width: 150px; opacity: 0.1; transform: rotate(15deg); }
    .card-balance { font-size: 2.2rem; font-weight: 800; margin: 5px 0 25px 0; color: white; }
    
    /* Stats Box Inside Card */
    .card-stats { display: grid; grid-template-cols: 1fr 1fr; gap: 15px; }
    .stat-box { 
        background: rgba(255, 255, 255, 0.1); 
        padding: 12px; 
        border-radius: 18px; 
        border: 1px solid rgba(255, 255, 255, 0.1); 
    }
    
    /* 2. HEADER LIST & TOMBOL FILTER */
    .section-title { padding: 30px 25px 15px; display: flex; justify-content: space-between; align-items: center; }
    .section-title h3 { font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 1px; font-weight: 800; }
    
    .btn-open-filter { 
        width: 40px; 
        height: 40px; 
        border-radius: 12px; 
        background: #161616; 
        border: 1px solid #222; 
        color: var(--montera-red); /* Warna Ikon Filter Ikut Tema */
        display: flex; 
        align-items: center; 
        justify-content: center; 
        cursor: pointer; 
        transition: 0.3s; 
    }
    .btn-open-filter:active { transform: scale(0.9); }

    /* 3. RIWAYAT & DIVIDER */
    .date-divider { 
        padding: 15px 25px 10px; 
        font-size: 10px; 
        color: var(--montera-red); /* Warna Tanggal Ikut Tema */
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: 1.5px; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
    }
    .date-divider::after { content: ''; flex: 1; height: 1px; background: #222; }
    
    .transaction-item { 
        background: #1A1A1A; 
        padding: 18px; 
        border-radius: 25px; 
        display: flex; 
        align-items: center; 
        margin: 0 20px 12px; 
        border: 1px solid #222; 
        transition: transform 0.2s;
    }
    .transaction-item:active { transform: scale(0.98); }
    
    /* Expense Icon Box */
    .icon-expense i { color: var(--montera-red) !important; }

    /* 4. MODAL FILTER STYLE */
    .modal-filter { position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 1500; display: none; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(8px); }
    .modal-filter.active { display: flex; }
    
    .filter-card { background: #121212; width: 100%; max-width: 350px; border-radius: 30px; padding: 30px; border: 1px solid #222; animation: zoomIn 0.3s ease; }
    
    .btn-submit { 
        width: 100%; 
        background: var(--montera-red); /* Tombol Submit Filter Ikut Tema */
        color: white; border: none; padding: 18px; border-radius: 18px; font-weight: 900; 
        transition: 0.3s;
    }
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

   

    <div class="savings-container" style="margin: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 0 5px;">
            <h3 style="font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 1px; font-weight: 800; margin: 0;">Target Tabungan</h3>
            <button onclick="openGoalModal()" style="background: none; border: none; color: var(--montera-red); font-size: 1.2rem; cursor: pointer;">
                <i class="fa-solid fa-circle-plus"></i>
            </button>
        </div>

        @forelse($goals as $goal)
            <div class="savings-card" style="background: #161616; padding: 20px; border-radius: 25px; border: 1px solid #222; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <div>
                        <span style="display: block; font-weight: 800; font-size: 0.9rem; color: white;">{{ $goal->name }}</span>
                        <span style="font-size: 10px; color: #555; font-weight: bold;">Sisa: Rp {{ number_format($goal->target_amount - $goal->current_amount, 0, ',', '.') }}</span>
                    </div>
                    <div style="text-align: right;">
                        <span style="display: block; font-size: 14px; font-weight: 900; color: var(--montera-red);">{{ round(($goal->current_amount / $goal->target_amount) * 100) }}%</span>
                    </div>
                </div>

                <div style="width: 100%; height: 6px; background: #000; border-radius: 10px; overflow: hidden; border: 1px solid #222;">
                    <div style="width: {{ ($goal->current_amount / $goal->target_amount) * 100 }}%; height: 100%; background: var(--montera-red); box-shadow: 0 0 10px var(--montera-red); transition: 1s ease-in-out;"></div>
                </div>

                <div style="background: rgba(var(--montera-red-rgb), 0.03); padding: 12px; border-radius: 15px; border-left: 3px solid var(--montera-red); margin-top: 15px;">
                    <p style="font-size: 10px; color: #aaa; margin: 0; line-height: 1.5;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="color: var(--montera-red); margin-right: 5px;"></i>
                        <span id="advice-{{ $goal->id }}">Menganalisa kas untuk strategi tabungan...</span>
                    </p>
                </div>
            </div>
        @empty
            <div style="background: #161616; padding: 20px; border-radius: 25px; border: 1px dashed #333; text-align: center;">
                <p style="font-size: 11px; color: #555; margin: 0; font-weight: bold;">Belum ada target tabungan. Klik (+) untuk bermimpi!</p>
            </div>
        @endforelse
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
            
            <div class="transaction-item">
                <div class="icon-box {{ $item->type == 'income' ? 'icon-income' : 'icon-expense' }}" style="width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; background: rgba(255,255,255,0.03);">
                    <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}" style="color: {{ $item->type == 'income' ? '#22c55e' : 'var(--montera-red)' }}"></i>
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
            <h3 style="text-align: center; margin-bottom: 25px; font-weight: 900; color: white; letter-spacing: 1px;">FILTER PERIODE</h3>
            <form action="{{ route('home') }}" method="GET">
                <div style="margin-bottom: 20px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase;">Mulai Dari</label>
                    <input type="date" name="start_date" class="input-control" value="{{ request('start_date') }}" style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 18px; margin-top: 8px;">
                </div>
                <div style="margin-bottom: 30px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase;">Sampai Dengan</label>
                    <input type="date" name="end_date" class="input-control" value="{{ request('end_date') }}" style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 18px; margin-top: 8px;">
                </div>
                <button type="submit" class="btn-submit">TERAPKAN FILTER</button>
                <button type="button" onclick="toggleFilterModal(false)" style="width: 100%; background: none; border: none; color: #444; margin-top: 15px; font-weight: bold; cursor: pointer; font-size: 0.8rem;">KEMBALI</button>
            </form>
        </div>
    </div>

    @include('partials.modal_input')
@endsection

@section('scripts')
<script>
    function toggleFilterModal(show) {
        document.getElementById('filterModal').classList.toggle('active', show);
    }
</script>
@endsection