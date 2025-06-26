@extends('layouts.app')

@section('title', 'Transaksi Saya')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-red-700 mb-6">Daftar Transaksi Saya</h2>
        <div class="bg-white shadow rounded-lg p-6 border-t-4 border-red-600">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 text-sm font-bold {{ $trx->type == 'debit' ? 'text-red-700' : 'text-yellow-700' }}">
                                Rp {{ number_format($trx->amount, 2) }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($trx->type) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $trx->description }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection