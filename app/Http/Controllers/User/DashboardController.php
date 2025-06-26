<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard', [
            'recentTransactions' => auth()->user()
                ->transactions()
                ->latest()
                ->take(5)
                ->get()
        ]);
    }
}