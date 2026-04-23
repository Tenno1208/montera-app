@extends('layouts.app')

@section('styles')
<style>
    .balance-card { margin: 10px 20px; padding: 30px; border-radius: 35px; background: linear-gradient(135deg, #D32F2F 0%, #7B1111 50%, #121212 100%); box-shadow: 0 20px 40px rgba(211, 47, 47, 0.3); }
    .card-label { font-size: 0.7rem; text-transform: uppercase; opacity: 0.7; font-weight: 600; letter-spacing: 1px; }
    .card-balance { font-size: 2.2rem; font-weight: 800; margin: 5px 0 25px 0; }
    .card-stats { display: grid; grid-template-cols: 1fr 1fr; gap: 15px; }
    .stat-box { background: rgba(255, 255, 255, 0.1); padding: 12px; border-radius: 18px; }
    .stat-label { font-size: 0.6rem; text-transform: uppercase; opacity: 0.6; display: block; }
    
    .section-title { padding: 30px 25px 15px; display: flex; justify-content: space-between; }
    .section-title h3 { font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 1px; }
    
    .transaction-item { background: #1A1A1A; padding: 18px; border-radius: 25px; display: flex; align-items: center; margin: 0 20px 12px; border: 1px solid #222; }
    .icon-box { width: 45px; height: 45px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; }
    .icon-income { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
    .icon-expense { background: rgba(211, 47, 47, 0.1); color: #D32F2F; }
    .trans-info { flex: 1; }
    .trans-title { font-size: 0.9rem; font-weight: bold; }
    .trans-cat { font-size: 0.65rem; color: #555; text-transform: uppercase; }
    .amount-val { font-size: 0.9rem; font-weight: 900; text-align: right; }
</style>
@endsection

@section('content')
    <div class="balance-card">
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

    <div class="section-title">
        <h3>Aktivitas Keuangan</h3>
        <i class="fa-solid fa-calendar-days text-gray-500"></i>
    </div>

    @forelse($transactions ?? [] as $item)
    <div class="transaction-item">
        <div class="icon-box {{ $item->type == 'income' ? 'icon-income' : 'icon-expense' }}">
            <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
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
    <p style="text-align: center; color: #444; margin-top: 20px;">Belum ada transaksi.</p>
    @endforelse

    <div class="modal" id="modalTransaction">
        <div class="modal-content">
            <h2 style="text-align: center; margin-bottom: 25px;">Catat Transaksi</h2>
            <form action="{{ route('store') }}" method="POST">
                @csrf
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <label style="flex: 1; text-align: center; padding: 10px; background: #D32F2F; border-radius: 10px; font-size: 12px; font-weight: bold;">
                        <input type="radio" name="type" value="expense" checked> PENGELUARAN
                    </label>
                    <label style="flex: 1; text-align: center; padding: 10px; background: #22c55e; border-radius: 10px; font-size: 12px; font-weight: bold;">
                        <input type="radio" name="type" value="income"> PEMASUKAN
                    </label>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-size: 10px; color: #555;">NOMINAL (RP)</label>
                    <input type="number" name="amount" class="input-control" placeholder="0" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-size: 10px; color: #555;">KETERANGAN</label>
                    <input type="text" name="title" class="input-control" placeholder="Beli Makan, Gaji, dll" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-size: 10px; color: #555;">KATEGORI</label>
                    <input type="text" name="category" class="input-control" placeholder="Makanan, Hobby, dll" required>
                </div>

                <button type="submit" class="btn-submit">SIMPAN DATA</button>
                <button type="button" onclick="closeModal()" style="width: 100%; background: none; border: none; color: #555; margin-top: 15px; font-weight: bold;">BATAL</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openModal() { document.getElementById('modalTransaction').classList.add('active'); }
    function closeModal() { document.getElementById('modalTransaction').classList.remove('active'); }
</script>
@endsection