<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'todayTransactions' => Transaction::whereDate('created_at', today())
                ->where(function($q) {
                    $q->where('type', 'debit')
                    ->orWhere(function($q2) {
                        $q2->where('type', 'credit')
                            ->whereHas('user', function($q3) {
                                $q3->where('is_admin', 0);
                            });
                    });
                })
                ->count(),
            'totalBalance' => User::sum('balance'),
            'recentTransactions' => Transaction::with('user')
                ->where(function($q) {
                    $q->where('type', 'debit')
                    ->orWhere(function($q2) {
                        $q2->where('type', 'credit')
                            ->whereHas('user', function($q3) {
                                $q3->where('is_admin', 0);
                            });
                    });
                })
                ->latest()
                ->take(10)
                ->get()
                    ]);
    }
}