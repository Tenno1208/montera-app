<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    $userId = auth()->id();
    $query = Transaction::where('user_id', $userId);

    // Filter berdasarkan tanggal (Jika ada)
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('date', [$request->start_date, $request->end_date]);
    }

    $transactions = $query->orderBy('date', 'desc')->get();

    // Hitung stats berdasarkan hasil filter
    $totalIncome = $transactions->where('type', 'income')->sum('amount');
    $totalExpense = $transactions->where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;

    
    return view('welcome', compact('transactions', 'balance', 'totalIncome', 'totalExpense','goals'));
}

public function report(Request $request)
{
    $userId = auth()->id();
    $query = Transaction::where('user_id', $userId);

    // Filter tanggal untuk laporan
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('date', [$request->start_date, $request->end_date]);
    }

    $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
    $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
    
    $total = $totalIncome + $totalExpense;
    $incomePercent = $total > 0 ? ($totalIncome / $total) * 100 : 0;
    $expensePercent = $total > 0 ? ($totalExpense / $total) * 100 : 0;

    return view('laporan', compact('totalIncome', 'totalExpense', 'incomePercent', 'expensePercent'));
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

public function scanNota(Request $request)
{
    if (!$request->hasFile('image')) {
        return response()->json(['error' => 'Gambar tidak ditemukan'], 400);
    }

    try {
        $image = base64_encode(file_get_contents($request->file('image')));
        $apiKey = env('GEMINI_API_KEY');

        // Menggunakan model gemini-2.5-flash sesuai hasil pengecekan tadi
        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => 'Analyze this receipt. Return ONLY plain JSON: {"title": "store name", "amount": 10000, "category": "food/shopping/transport/other", "date": "YYYY-MM-DD"}. No markdown, no extra text.'
                        ],
                        [
                            'inline_data' => [
                                'mime_type' => 'image/jpeg',
                                'data' => $image
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $result = $response->json();

        // Cek error dari API
        if (isset($result['error'])) {
            return response()->json(['error' => 'AI Error: ' . $result['error']['message']], 500);
        }

        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json(['error' => 'Gagal membaca teks nota.'], 500);
        }

        $rawText = $result['candidates'][0]['content']['parts'][0]['text'];
        
        // Membersihkan jika AI memberikan format ```json ... ```
        $cleanJson = trim(str_replace(['```json', '```'], '', $rawText));
        $data = json_decode($cleanJson, true);

        if (!$data) {
            return response()->json(['error' => 'Format data AI tidak dikenali.'], 500);
        }

        return response()->json($data);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Sistem Error: ' . $e->getMessage()], 500);
    }
}
}