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
    if (!$request->hasFile('image')) {
        return response()->json(['error' => 'Gambar tidak ditemukan'], 400);
    }

    try {
        $image = base64_encode(file_get_contents($request->file('image')));
        $apiKey = env('GEMINI_API_KEY');

        // GUNAKAN ENDPOINT /v1/ DAN MODEL gemini-1.5-flash
        $response = Http::post("https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => 'Analyze this receipt image. Extract the information and return ONLY a plain JSON object with these keys: "title" (store name), "amount" (total price as integer, no dots/commas), "category" (choose one: food, shopping, transport, bill, or other), and "date" (YYYY-MM-DD). Do not include markdown formatting or extra text.'
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

        // Cek jika API mengembalikan error
        if (isset($result['error'])) {
            return response()->json(['error' => 'Gemini Error: ' . $result['error']['message']], 500);
        }

        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json(['error' => 'AI gagal memproses gambar.'], 500);
        }

        $rawText = $result['candidates'][0]['content']['parts'][0]['text'];
        
        // Membersihkan string dari karakter aneh dan markdown (```json ...)
        $cleanJson = trim(str_replace(['```json', '```'], '', $rawText));
        $data = json_decode($cleanJson, true);

        if (!$data) {
            return response()->json(['error' => 'Format JSON AI tidak valid.'], 500);
        }

        return response()->json($data);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Sistem Error: ' . $e->getMessage()], 500);
    }
}
}