<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller {
    public function index() {
        return response()->json(Transaction::latest()->get());
    }

    public function store(Request $request) {
        $trx = Transaction::create($request->all());
        return response()->json($trx);
    }
}
