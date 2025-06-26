@extends('layouts.app')

@section('title', 'Tambah Saldo User')

@section('content')
<div class="py-6">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-4 p-3 rounded bg-yellow-100 text-yellow-800">
                {!! session('warning') !!}
            </div>
        @endif
        <h2 class="text-2xl font-semibold text-red-700 mb-6">Tambah Saldo User</h2>
        <form method="POST" action="{{ route('admin.users.add-saldo.process') }}" class="bg-white shadow rounded-lg p-6 border-t-4 border-yellow-400">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih User</label>
                <select name="user_id" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Tambah Saldo</label>
                <input type="number" name="amount" min="1" step="0.01" class="block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (opsional)</label>
                <input type="text" name="description" class="block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-red-800 font-bold py-2 px-4 rounded transition w-full md:w-auto">
                    Tambah Saldo
                </button>
            </div>
        </form>

        <hr class="my-8">

        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Import Tambah Saldo via Excel</h3>
            <a href="{{ asset('template/template-import-saldo.xlsx') }}" class="inline-flex items-center px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-red-800 font-semibold rounded text-sm transition mb-2" download>
                <i class="fas fa-download mr-2"></i> Download Template
            </a>
            <form method="POST" action="{{ route('admin.users.add-saldo.import') }}" enctype="multipart/form-data" class="bg-yellow-50 p-4 rounded-lg shadow-inner mt-2">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls" required class="block mb-3">
                <button type="submit" class="bg-red-700 hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded transition">
                    Import Saldo
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
