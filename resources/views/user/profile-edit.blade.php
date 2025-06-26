@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="py-6">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Profil Saya</h2>
        <form method="POST" action="{{ route('user.profile.update') }}" class="bg-white shadow rounded-lg p-6 border-t-4 border-yellow-400">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">RFID UID</label>
                <input type="text" name="rfid" value="{{ old('rfid', auth()->user()->rfid) }}" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('rfid') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                <select name="unit" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">-- Pilih Unit --</option>
                    <option value="SMAIT Abu Bakar Yogyakarta" {{ old('unit', auth()->user()->unit) == 'SMAIT Abu Bakar Yogyakarta' ? 'selected' : '' }}>SMAIT Abu Bakar Yogyakarta</option>
                    <option value="SMAIT Abu Bakar Boarding School Kulon Progo" {{ old('unit', auth()->user()->unit) == 'SMAIT Abu Bakar Boarding School Kulon Progo' ? 'selected' : '' }}>SMAIT Abu Bakar Boarding School Kulon Progo</option>
                    <option value="Lainnya" {{ old('unit', auth()->user()->unit) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('unit') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (opsional)</label>
                <input type="password" name="password" class="block w-full rounded-md border-gray-300 shadow-sm">
                @error('password') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('user.dashboard') }}" class="mr-4 text-sm text-gray-600 hover:underline">Batal</a>
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-red-800 font-bold py-2 px-4 rounded transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection