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
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'date' => 'required|date',
        ]);

        // Simpan ke Database
        Transaction::create($request->all());

        return redirect()->back()-
        >with('success', 'Catatan berhasil ditambahkan!');
    }
}