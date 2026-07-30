<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Pastikan modelmu benar
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{

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