@extends('layouts.app')

@section('styles')
<style>
    /* Filter Bar Style */
    .filter-container { margin: 0 20px 20px; background: #161616; padding: 15px; border-radius: 20px; border: 1px solid #222; }
    .filter-form { display: grid; grid-template-cols: 1fr 1fr auto; gap: 10px; align-items: flex-end; }
    .filter-input { background: #0F0F0F; border: 1px solid #333; color: white; padding: 8px; border-radius: 10px; font-size: 11px; outline: none; }
    .btn-filter { background: #D32F2F; color: white; border: none; padding: 10px; border-radius: 10px; cursor: pointer; }

    /* Riwayat Mewah */
    .date-divider { padding: 10px 25px; font-size: 11px; color: #D32F2F; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 10px; }
    .date-divider::after { content: ''; flex: 1; height: 1px; background: #222; }
    
    .transaction-item { background: #1A1A1A; padding: 18px; border-radius: 25px; display: flex; align-items: center; margin: 0 20px 12px; border: 1px solid #222; }
    .icon-box { width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; }
    .icon-income { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
    .icon-expense { background: rgba(211, 47, 47, 0.1); color: #D32F2F; }
    .trans-info { flex: 1; }
    .trans-title { font-size: 0.9rem; font-weight: bold; color: white; }
    .trans-cat { font-size: 0.65rem; color: #555; text-transform: uppercase; font-weight: 700; }
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
                <label style="font-size: 9px; color: #555; font-weight: bold;">DARI</label>
                <input type="date" name="start_date" class="filter-input" value="{{ request('start_date') }}">
            </div>
            <div>
                <label style="font-size: 9px; color: #555; font-weight: bold;">SAMPAI</label>
                <input type="date" name="end_date" class="filter-input" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn-filter"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <div class="section-title">
        <h3>Riwayat Transaksi</h3>
        @if(request('start_date'))
            <a href="{{ route('home') }}" style="font-size: 10px; color: #D32F2F; text-decoration: none;">Reset Filter</a>
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
            <div style="text-align: center; padding: 50px 20px;">
                <p style="color: #444; font-size: 0.8rem; font-weight: bold;">Tidak ada data ditemukan</p>
            </div>
        @endforelse
    </div>

    @include('partials.modal_input')
@endsection