@extends('layouts.app')

@section('styles')
<style>
    /* Card & Stats tetap sama seperti sebelumnya */
    .balance-card { margin: 10px 20px; padding: 30px; border-radius: 35px; background: linear-gradient(135deg, #D32F2F 0%, #7B1111 50%, #121212 100%); box-shadow: 0 20px 40px rgba(211, 47, 47, 0.3); position: relative; overflow: hidden; }
    .balance-card img { position: absolute; right: -20px; bottom: -20px; width: 150px; opacity: 0.1; transform: rotate(15deg); }
    .card-balance { font-size: 2.2rem; font-weight: 800; margin: 5px 0 25px 0; }
    .card-stats { display: grid; grid-template-cols: 1fr 1fr; gap: 15px; }
    .stat-box { background: rgba(255, 255, 255, 0.1); padding: 12px; border-radius: 18px; border: 1px solid rgba(255, 255, 255, 0.1); }
    
    /* Header List & Tombol Filter */
    .section-title { padding: 30px 25px 15px; display: flex; justify-content: space-between; align-items: center; }
    .section-title h3 { font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 1px; font-weight: 800; }
    .btn-open-filter { width: 40px; height: 40px; border-radius: 12px; background: #161616; border: 1px solid #222; color: #D32F2F; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; }
    .btn-open-filter:active { transform: scale(0.9); }

    /* Riwayat & Divider */
    .date-divider { padding: 15px 25px 10px; font-size: 10px; color: #D32F2F; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; display: flex; align-items: center; gap: 10px; }
    .date-divider::after { content: ''; flex: 1; height: 1px; background: #222; }
    .transaction-item { background: #1A1A1A; padding: 18px; border-radius: 25px; display: flex; align-items: center; margin: 0 20px 12px; border: 1px solid #222; }
    
    /* MODAL FILTER STYLE */
    .modal-filter { position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 1500; display: none; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(5px); }
    .modal-filter.active { display: flex; }
    .filter-card { background: #121212; width: 100%; max-width: 350px; border-radius: 30px; padding: 30px; border: 1px solid #222; animation: zoomIn 0.3s ease; }
    @keyframes zoomIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
</style>
@endsection

@section('content')
    <div class="balance-card">
        <img src="{{ asset('img/logo-montera.png') }}">
        <span style="font-size: 0.7rem; text-transform: uppercase; opacity: 0.7; font-weight: 600;">Saldo Saat Ini</span>
        <div class="card-balance">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</div>
        <div class="card-stats">
            <div class="stat-box"><small style="font-size: 9px; color: #555;">PEMASUKAN</small><br><span style="color: #22c55e; font-weight: bold;">+{{ number_format($totalIncome ?? 0, 0, ',', '.') }}</span></div>
            <div class="stat-box"><small style="font-size: 9px; color: #555;">PENGELUARAN</small><br><span style="color: #ff4d4d; font-weight: bold;">-{{ number_format($totalExpense ?? 0, 0, ',', '.') }}</span></div>
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
            <div class="transaction-item">
                <div class="icon-box {{ $item->type == 'income' ? 'icon-income' : 'icon-expense' }}" style="width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; background: rgba(255,255,255,0.05);">
                    <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}" style="color: {{ $item->type == 'income' ? '#22c55e' : '#D32F2F' }}"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 0.9rem; font-weight: bold; margin: 0;">{{ $item->title }}</p>
                    <p style="font-size: 0.65rem; color: #555; text-transform: uppercase; font-weight: 700;">{{ $item->category }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 0.95rem; font-weight: 900; color: {{ $item->type == 'income' ? '#22c55e' : '#FFF' }}">
                        {{ $item->type == 'income' ? '+' : '-' }} {{ number_format($item->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @empty
            <p style="text-align: center; color: #444; padding: 40px;">Belum ada transaksi</p>
        @endforelse
    </div>

    <div class="modal-filter" id="filterModal">
        <div class="filter-card">
            <h3 style="text-align: center; margin-bottom: 25px; font-weight: 900;">FILTER PERIODE</h3>
            <form action="{{ route('home') }}" method="GET">
                <div style="margin-bottom: 20px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800;">DARI TANGGAL</label>
                    <input type="date" name="start_date" class="input-control" value="{{ request('start_date') }}" style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 15px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 30px;">
                    <label style="font-size: 10px; color: #555; font-weight: 800;">SAMPAI TANGGAL</label>
                    <input type="date" name="end_date" class="input-control" value="{{ request('end_date') }}" style="width: 100%; background: #1A1A1A; border: 1px solid #333; color: white; padding: 15px; border-radius: 15px; margin-top: 5px;">
                </div>
                <button type="submit" class="btn-submit" style="width: 100%; background: #D32F2F; color: white; border: none; padding: 18px; border-radius: 18px; font-weight: 900;">TERAPKAN FILTER</button>
                <button type="button" onclick="toggleFilterModal(false)" style="width: 100%; background: none; border: none; color: #444; margin-top: 15px; font-weight: bold; cursor: pointer;">BATAL</button>
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