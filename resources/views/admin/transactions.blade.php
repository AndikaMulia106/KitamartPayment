@extends('layouts.app')

@section('title', 'Admin Transactions')

@section('content')
<div class="py-6">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-red-700 mb-6">Transaksi RFID</h2>
        <p class="text-yellow-700 mb-6">Silakan tempelkan kartu RFID user, masukkan nominal transaksi, lalu proses.</p>

        <!-- Pesan sukses/error -->
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
        @endif

        <!-- Form Transaksi -->
        <form method="POST" action="{{ route('admin.transactions.process') }}" class="bg-white shadow rounded-lg p-6 border-t-4 border-yellow-400">
            @csrf
            <div class="mb-4">
                <label for="rfid" class="block text-sm font-medium text-gray-700 mb-1">RFID UID</label>
                <input type="text" name="rfid" id="rfid" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500" placeholder="Tempelkan kartu RFID di reader..." required autofocus>
                <small class="text-gray-500">RFID akan terisi otomatis jika reader terhubung.</small>
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Nominal Transaksi</label>
                <input type="number" name="amount" id="amount" min="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Masukkan nominal" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Saldo Akhir User</label>
                <input type="text" id="final_balance" class="block w-full rounded-md border-gray-200 bg-gray-100" readonly placeholder="Akan tampil setelah RFID terbaca dan nominal diisi">
            </div>
            <button type="submit" class="w-full bg-red-700 hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded transition">
                Proses Transaksi
            </button>
        </form>
    </div>
</div>

<script>
    // Simulasi AJAX untuk mendapatkan saldo user berdasarkan RFID
    document.getElementById('rfid').addEventListener('change', function() {
        const rfid = this.value;
        const amountInput = document.getElementById('amount');
        const finalBalanceInput = document.getElementById('final_balance');
        if(rfid.length > 0) {
            fetch(`/admin/api/user-balance?rfid=${rfid}`)
                .then(res => res.json())
                .then(data => {
                    amountInput.value = '';
                    finalBalanceInput.value = data.balance !== undefined && data.balance !== null ? data.balance : '';
                });
        }
    });

    document.getElementById('amount').addEventListener('input', function() {
        const amount = parseInt(this.value) || 0;
        const rfid = document.getElementById('rfid').value;
        const finalBalanceInput = document.getElementById('final_balance');
        if(rfid.length > 0 && amount > 0) {
            fetch(`/admin/api/user-balance?rfid=${rfid}`)
                .then(res => res.json())
                .then(data => {
                    if(data.balance !== undefined && data.balance !== null) {
                        finalBalanceInput.value = data.balance - amount;
                    }
                });
        }
    });
</script>
@endsection