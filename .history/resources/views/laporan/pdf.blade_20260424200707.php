<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan Montera</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #e60000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #e60000; margin: 0; }
        .summary { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #f8f8f8; }
        .text-income { color: #22c55e; font-weight: bold; }
        .text-expense { color: #e60000; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>MONTERA KAS</h1>
        <p>Laporan Riwayat Transaksi</p>
        <small>Periode: {{ $periode }}</small>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td><strong>Total Pemasukan:</strong></td>
                <td class="text-income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                <td><strong>Total Pengeluaran:</strong></td>
                <td class="text-expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</td>
                <td>{{ $t->title }}</td>
                <td>{{ $t->category }}</td>
                <td>{{ ucfirst($t->type) }}</td>
                <td class="{{ $t->type == 'income' ? 'text-income' : 'text-expense' }}">
                    {{ $t->type == 'income' ? '+' : '-' }} {{ number_format($t->amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $date }}
    </div>
</body>
</html>