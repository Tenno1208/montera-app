<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
{
    $userId = auth()->id();

    // Jika tidak login, arahkan ke login (tambahan keamanan)
    if (!$userId) return redirect()->route('login');

    // Ambil transaksi milik user yang login saja
    $transactions = Transaction::where('user_id', $userId)
                                ->orderBy('date', 'desc')
                                ->get();

    // Hitung saldo milik user yang login saja
    $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;

    return view('welcome', compact('transactions', 'balance', 'totalIncome', 'totalExpense'));
}

    public function store(Request $request)
{
    try {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required',
            'category' => 'required',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Berhasil disimpan!');
    } catch (\Exception $e) {
        // Ini akan menghentikan aplikasi dan memunculkan pesan error DB jika ada
        dd($e->getMessage()); 
    }
}
    
    public function report()
{
    $userId = auth()->id();

    $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
    
    $total = $totalIncome + $totalExpense;
    $incomePercent = $total > 0 ? ($totalIncome / $total) * 100 : 0;
    $expensePercent = $total > 0 ? ($totalExpense / $total) * 100 : 0;

    return view('laporan', compact('totalIncome', 'totalExpense', 'incomePercent', 'expensePercent'));
}



public function scanNota(Request $request)
{
    $apiKey = env('GEMINI_API_KEY');
    // Kita tanya Google: "Eh, akun saya boleh pakai model apa saja?"
    $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");
    
    return response()->json($response->json());
}
}