<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi, urutkan dari yang terbaru
        $transactions = Transaction::orderBy('date', 'desc')->get();

        // Hitung Total Saldo Dinamis
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('welcome', compact('transactions', 'balance', 'totalIncome', 'totalExpense'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'amount' => 'required|numeric',
        'type' => 'required',
        'category' => 'required',
        'date' => 'required|date',
    ]);

    \App\Models\Transaction::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'amount' => $request->amount,
        'type' => $request->type,
        'category' => $request->category,
        'date' => $request->date,
    ]);

    return redirect()->back();
}
    
    public function report()
{
    $totalIncome = Transaction::where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('type', 'expense')->sum('amount');
    
    // Ambil data untuk persentase (opsional)
    $total = $totalIncome + $totalExpense;
    $incomePercent = $total > 0 ? ($totalIncome / $total) * 100 : 0;
    $expensePercent = $total > 0 ? ($totalExpense / $total) * 100 : 0;

    return view('laporan', compact('totalIncome', 'totalExpense', 'incomePercent', 'expensePercent'));
}
}