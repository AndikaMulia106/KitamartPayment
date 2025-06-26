@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Hi {{ auth()->user()->name }}</h2>
        
        <!-- Profil Saya -->
    <div class="bg-white overflow-hidden shadow rounded-lg mb-8 border-t-4 border-yellow-400">
        <div class="px-4 py-5 sm:p-6">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-800">Profil Saya</h3>
                <a href="{{ route('user.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-red-800 font-semibold rounded transition text-sm">
                    <i class="fas fa-edit mr-2"></i> Edit Profil
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-gray-500">Nama</div>
                    <div class="font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Email</div>
                    <div class="font-semibold text-gray-800">{{ auth()->user()->email }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">RFID UID</div>
                    <div class="font-semibold text-gray-800">{{ auth()->user()->rfid }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Unit</div>
                    <div class="font-semibold text-gray-800">{{ auth()->user()->unit }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Role</div>
                    <div class="font-semibold text-gray-800">
                        {{ auth()->user()->is_admin ? 'Admin' : 'User' }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Tanggal Daftar</div>
                    <div class="font-semibold text-gray-800">
                        {{ auth()->user()->created_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Saldo -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8 border-t-4 border-red-600">
            <div class="px-4 py-5 sm:p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Saldo Saya</h3>
                    <p class="mt-1 text-sm text-gray-500">Saldo yang tersedia untuk bertransaksi</p>
                </div>
                <div class="text-3xl font-bold text-yellow-500">
                    Rp {{ number_format(auth()->user()->balance, 2) }}
                </div>
            </div>
        </div>
        
        <!-- Aksi Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('user.transactions') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition border-t-4 border-yellow-400">
                <div class="px-4 py-5 sm:p-6 flex items-center">
                    <div class="flex-shrink-0 bg-yellow-400 rounded-md p-3">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-lg font-medium text-gray-800">Riwayat Transaksi</h3>
                        <p class="mt-1 text-sm text-gray-500">Lihat semua riwayat transaksi</p>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Transaksi Terbaru -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-yellow-400">
                <h3 class="text-lg font-medium text-gray-800">Transaksi Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentTransactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium {{ $transaction->type === 'credit' ? 'text-yellow-700' : 'text-red-700' }}">
                                    Rp {{ number_format($transaction->amount, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucfirst($transaction->type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection