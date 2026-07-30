<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsGoalController extends Controller
{
    public function store(Request $request) {
    $request->validate([
        'name' => 'required',
        'target_amount' => 'required|numeric',
        'deadline' => 'required|date',
    ]);

    \App\Models\SavingsGoal::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'target_amount' => $request->target_amount,
        'current_amount' => 0, // Awalnya nol
        'deadline' => $request->deadline,
    ]);

    return back()->with('success', 'Target tabungan berhasil dibuat!');
}
}
