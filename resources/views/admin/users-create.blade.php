@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="py-6">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
         {{-- Notifikasi sukses dan warning --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="mb-4 p-3 rounded bg-yellow-100 text-yellow-800">{!! session('warning') !!}</div>
        @endif
        
        <h2 class="text-2xl font-semibold text-red-700 mb-6">Tambah User Baru</h2>
        <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white shadow rounded-lg p-6 border-t-4 border-yellow-400">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" class="block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">PIN</label>
                <input type="password" name="password" class="block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">RFID UID</label>
                <input type="text" name="rfid" class="block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                <select name="unit" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">-- Pilih Unit --</option>
                    <option value="SMAIT Abu Bakar Yogyakarta">SMAIT Abu Bakar Yogyakarta</option>
                    <option value="SMAIT Abu Bakar Boarding School Kulon Progo">SMAIT Abu Bakar Boarding School Kulon Progo</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Saldo Awal</label>
                <input type="number" name="balance" min="0" step="0.01" class="block w-full rounded-md border-gray-300 shadow-sm" value="0" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="is_admin" class="block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-red-700 hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded transition w-full md:w-auto">
                    Tambah User
                </button>
            </div>
        </form>
        <!-- Import Excel -->
        <div class="mt-8">
            <div class="flex items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-700 mr-4">Import User dari Excel</h3>
                <a href="{{ asset('template/template-import-user.xlsx') }}" class="inline-flex items-center px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-red-800 font-semibold rounded text-sm transition" download>
                    <i class="fas fa-download mr-2"></i> Download Template
                </a>
            </div>
            <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" class="bg-yellow-50 p-4 rounded-lg shadow-inner">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls" required class="block mb-3">
                <button type="submit" class="bg-red-700 hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded transition">
                    Import Excel
                </button>
            </form>
        </div>
    </div>
</div>
@endsection