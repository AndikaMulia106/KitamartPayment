<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil transaksi user yang sedang login
        $transactions = auth()->user()->transactions()->latest()->paginate(10);

        return view('user.transactions', compact('transactions'));
    }
}