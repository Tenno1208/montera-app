<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Pastikan modelmu benar
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('date', 'desc')->get();
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $total = $totalIncome + $totalExpense;

        $incomePercent = $total > 0 ? ($totalIncome / $total) * 100 : 0;
        $expensePercent = $total > 0 ? ($totalExpense / $total) * 100 : 0;

        return view('laporan', compact('transactions', 'totalIncome', 'totalExpense', 'incomePercent', 'expensePercent'));
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::query();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $data = [
            'transactions' => $query->orderBy('date', 'asc')->get(),
            'totalIncome'  => $query->clone()->where('type', 'income')->sum('amount'),
            'totalExpense' => $query->clone()->where('type', 'expense')->sum('amount'),
            'periode'      => $request->start_date ? $request->start_date . ' s/d ' . $request->end_date : 'Semua Periode',
            'date'         => Carbon::now()->translatedFormat('d F Y')
        ];

        $pdf = Pdf::loadView('laporan.pdf', $data);
        return $pdf->download('Laporan_Keuangan_Montera.pdf');
    }
}