<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan Monetra</title>
    <style>
        /* Menggunakan font standar yang aman untuk PDF */
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #333; 
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        
        /* Header Banner */
        .header { 
            background-color: #1a1a1a; 
            color: white; 
            padding: 30px; 
            border-bottom: 5px solid #e60000;
        }
        .header h1 { 
            margin: 0; 
            font-size: 24px; 
            letter-spacing: 2px;
            color: #ffffff;
        }
        .header p { margin: 5px 0 0; opacity: 0.7; font-size: 12px; }

        .container { padding: 20px 40px; }

        /* Status Cards Simulation */
        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .stat-card { 
            background: #f9f9f9; 
            border: 1px solid #eee; 
            padding: 15px; 
            text-align: center;
            border-radius: 10px;
        }
        .stat-label { font-size: 10px; color: #888; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
        .stat-value { font-size: 16px; font-weight: bold; }

        /* Table Style */
        .main-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .main-table th { 
            background-color: #f2f2f2; 
            color: #555; 
            text-transform: uppercase; 
            font-size: 10px; 
            padding: 12px 10px;
            border-bottom: 2px solid #ddd;
            text-align: left;
        }
        .main-table td { 
            padding: 12px 10px; 
            font-size: 11px; 
            border-bottom: 1px solid #eee;
        }
        .main-table tr:nth-child(even) { background-color: #fafafa; }

        /* Typography & Colors */
        .text-income { color: #22c55e; }
        .text-expense { color: #e60000; }
        .badge {
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-income { background-color: #e8f9ee; color: #22c55e; }
        .badge-expense { background-color: #fde8e8; color: #e60000; }

        .footer { 
            margin-top: 50px; 
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center; 
            font-size: 10px; 
            color: #aaa;
        }
        .periode-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MONTERA <span style="color: #e60000;">KAS</span></h1>
        <p>Laporan Manajemen Keuangan Pribadi</p>
    </div>

    <div class="container">
        <div class="periode-info">
            <strong>Periode:</strong> {{ $periode }} <br>
            <strong>Dicetak:</strong> {{ $date }}
        </div>

        <table class="stats-table">
            <tr>
                <td width="32%" style="padding-right: 10px;">
                    <div class="stat-card">
                        <div class="stat-label">Total Pemasukan</div>
                        <div class="stat-value text-income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                    </div>
                </td>
                <td width="32%" style="padding: 0 5px;">
                    <div class="stat-card">
                        <div class="stat-label">Total Pengeluaran</div>
                        <div class="stat-value text-expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                    </div>
                </td>
                <td width="32%" style="padding-left: 10px;">
                    <div class="stat-card" style="border-left: 4px solid #1a1a1a;">
                        <div class="stat-label">Selisih (Net)</div>
                        <div class="stat-value" style="color: #333;">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th width="15%">Tanggal</th>
                    <th width="35%">Deskripsi</th>
                    <th width="20%">Kategori</th>
                    <th width="10%">Tipe</th>
                    <th width="20%" style="text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->date)->translatedFormat('d M Y') }}</td>
                    <td><strong>{{ $t->title }}</strong></td>
                    <td>{{ $t->category }}</td>
                    <td>
                        <span class="badge {{ $t->type == 'income' ? 'badge-income' : 'badge-expense' }}">
                            {{ $t->type == 'income' ? 'Masuk' : 'Keluar' }}
                        </span>
                    </td>
                    <td style="text-align: right;" class="{{ $t->type == 'income' ? 'text-income' : 'text-expense' }}">
                        <strong>{{ $t->type == 'income' ? '+' : '-' }} {{ number_format($t->amount, 0, ',', '.') }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem Montera Kas pada {{ $date }}.<br>
            &copy; 2026 Montera Finance Developer.
        </div>
    </div>
</body>
</html>