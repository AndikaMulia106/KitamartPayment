<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Contoh method index
    public function index(Request $request)
    {
        $transactions = \App\Models\Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.transactions', compact('transactions'));
    }
    // API untuk mendapatkan saldo user berdasarkan RFID
    public function getUserBalance(Request $request)
    {
        $rfid = $request->query('rfid');
        $user = User::where('rfid', $rfid)->first();
        if (!$user) {
            return response()->json(['balance' => null], 404);
        }
        return response()->json(['balance' => $user->balance]);
    }

    // Proses transaksi
    public function process(Request $request)
    {
        $request->validate([
            'rfid' => 'required|exists:users,rfid',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = User::where('rfid', $request->rfid)->first();

        if (!$user) {
            return back()->with('error', 'User dengan RFID tidak ditemukan.');
        }

        if ($user->balance < $request->amount) {
            return back()->with('error', 'Saldo user tidak mencukupi.');
        }

        // Kurangi saldo
        $user->balance -= $request->amount;
        $user->save();

        // Catat transaksi
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'debit',
            'description' => 'Transaksi RFID oleh admin',
        ]);

        return back()->with('success', 'Transaksi berhasil! Saldo akhir: Rp ' . number_format($user->balance, 2));
    }
}