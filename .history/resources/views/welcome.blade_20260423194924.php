@extends('layouts.app')

@section('styles')
<style>
    /* Card Saldo Utama */
    .balance-card { 
        margin: 10px 20px; padding: 30px; border-radius: 35px; 
        background: linear-gradient(135deg, #D32F2F 0%, #7B1111 50%, #121212 100%); 
        box-shadow: 0 20px 40px rgba(211, 47, 47, 0.3); position: relative; overflow: hidden;
    }
    .balance-card img { position: absolute; right: -20px; bottom: -20px; width: 150px; opacity: 0.1; transform: rotate(15deg); pointer-events: none; }
    .card-label { font-size: 0.7rem; text-transform: uppercase; opacity: 0.7; font-weight: 600; letter-spacing: 1px; }
    .card-balance { font-size: 2.2rem; font-weight: 800; margin: 5px 0 25px 0; letter-spacing: -1.5px; }
    
    .card-stats { display: grid; grid-template-cols: 1fr 1fr; gap: 15px; }
    .stat-box { background: rgba(255, 255, 255, 0.1); padding: 12px; border-radius: 18px; border: 1px solid rgba(255, 255, 255, 0.1); }
    .stat-label { font-size: 0.6rem; text-transform: uppercase; opacity: 0.6; display: block; margin-bottom: 2px; }
    
    /* Filter Bar */
    .filter-container { margin: 0 20px 20px; background: #161616; padding: 15px; border-radius: 25px; border: 1px solid #222; }
    .filter-form { display: grid; grid-template-cols: 1fr 1fr auto; gap: 10px; align-items: flex-end; }
    .filter-input { background: #0F0F0F; border: 1px solid #333; color: white; padding: 10px; border-radius: 12px; font-size: 11px; outline: none; width: 100%; box-sizing: border-box; }
    .btn-filter { background: #D32F2F; color: white; border: none; padding: 10px 15px; border-radius: 12px; cursor: pointer; height: 38px; transition: 0.3s; }
    .btn-filter:active { transform: scale(0.9); }

    /* Riwayat & Tanggal */
    .section-title { padding: 10px 25px 15px; display: flex; justify-content: space-between; align-items: center; }
    .section-title h3 { font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 1px; font-weight: 800; }
    
    .date-divider { padding: 15px 25px 10px; font-size: 10px; color: #D32F2F; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; display: flex; align-items: center; gap: 10px; }
    .date-divider::after { content: ''; flex: 1; height: 1px; background: #222; }
    
    .transaction-item { background: #1A1A1A; padding: 18px; border-radius: 25px; display: flex; align-items: center; margin: 0 20px 12px; border: 1px solid #222; transition: 0.3s; }
    .transaction-item:active { background: #222; transform: translateY(-2px); }
    
    .icon-box { width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 1.1rem; }
    .icon-income { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
    .icon-expense { background: rgba(211, 47, 47, 0.1); color: #D32F2F; }
    
    .trans-info { flex: 1; }
    .trans-title { font-size: 0.9rem; font-weight: bold; color: white; margin: 0; }
    .trans-cat { font-size: 0.65rem; color: #555; text-transform: uppercase; font-weight: 700; margin-top: 2px; }
    .amount-val { font-size: 0.95rem; font-weight: 900; }
</style>
@endsection

@section('content')
    <div class="balance-card">
        <img src="{{ asset('img/logo-montera.png') }}">
        <span class="card-label">Saldo Saat Ini</span>
        <div class="card-balance">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</div>
        
        <div class="card-stats">
            <div class="stat-box">
                <span class="stat-label">Pemasukan</span>
                <span style="color: #22c55e; font-weight: bold;">+{{ number_format($totalIncome ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Pengeluaran</span>
                <span style="color: #ff4d4d; font-weight: bold;">-{{ number_format($totalExpense ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="filter-container">
        <form action="{{ route('home') }}" method="GET" class="filter-form">
            <div>
                <label style="font-size: 9px; color: #444; font-weight: 900; margin-left: 5px;">DARI</label>
                <input type="date" name="start_date" class="filter-input" value="{{ request('start_date') }}">
            </div>
            <div>
                <label style="font-size: 9px; color: #444; font-weight: 900; margin-left: 5px;">SAMPAI</label>
                <input type="date" name="end_date" class="filter-input" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn-filter"><i class="fa-solid fa-sliders"></i></button>
        </form>
    </div>

    <div class="section-title">
        <h3>Riwayat Keuangan</h3>
        @if(request('start_date'))
            <a href="{{ route('home') }}" style="font-size: 10px; color: #D32F2F; text-decoration: none; font-weight: bold;">RESET</a>
        @endif
    </div>

    <div class="transaction-list">
        @php $currentDate = null; @endphp
        @forelse($transactions ?? [] as $item)
            @if($currentDate != $item->date)
                <div class="date-divider">
                    {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}
                </div>
                @php $currentDate = $item->date; @endphp
            @endif

            <div class="transaction-item">
                <div class="icon-box {{ $item->type == 'income' ? 'icon-income' : 'icon-expense' }}">
                    <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                </div>
                <div class="trans-info">
                    <p class="trans-title">{{ $item->title }}</p>
                    <p class="trans-cat">{{ $item->category }}</p>
                </div>
                <div class="trans-amount">
                    <p class="amount-val" style="color: {{ $item->type == 'income' ? '#22c55e' : '#FFFFFF' }}">
                        {{ $item->type == 'income' ? '+' : '-' }} {{ number_format($item->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px 20px;">
                <i class="fa-solid fa-box-open" style="font-size: 3rem; color: #1A1A1A; margin-bottom: 15px;"></i>
                <p style="color: #444; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Belum ada data</p>
            </div>
        @endforelse
    </div>

    @include('partials.modal_input')
@endsection