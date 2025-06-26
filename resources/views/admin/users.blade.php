@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-red-700 mb-6">Manage Users</h2>
        <p class="text-yellow-700 mb-6">Lihat daftar user, tambah user baru, atau tambah saldo user.</p>

        <!-- Pesan sukses/error -->
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="flex gap-4 mb-6">
            <a href="{{ route('admin.users.create') }}" class="bg-yellow-400 hover:bg-yellow-300 text-red-800 font-bold py-2 px-4 rounded transition">Tambah User</a>
            <a href="{{ route('admin.users.add-saldo') }}" class="bg-yellow-400 hover:bg-yellow-300 text-red-800 font-bold py-2 px-4 rounded transition">Tambah Saldo User</a>
        </div>

        <!-- Tabel User -->
        <div class="bg-white shadow rounded-lg p-6 border-t-4 border-red-600">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar User</h3>
            <!-- Filter Unit -->
            <form method="GET" action="{{ route('admin.users') }}" class="mb-6 flex items-center gap-2">
                <label for="unit" class="text-sm font-medium text-gray-700">Filter Unit:</label>
                <select name="unit" id="unit" class="rounded border-gray-300" onchange="this.form.submit()">
                    <option value="">Semua Unit</option>
                    <option value="SMAIT Abu Bakar Yogyakarta" {{ request('unit') == 'SMAIT Abu Bakar Yogyakarta' ? 'selected' : '' }}>SMAIT Abu Bakar Yogyakarta</option>
                    <option value="SMAIT Abu Bakar Boarding School Kulon Progo" {{ request('unit') == 'SMAIT Abu Bakar Boarding School Kulon Progo' ? 'selected' : '' }}>SMAIT Abu Bakar Boarding School Kulon Progo</option>
                    <option value="Lainnya" {{ request('unit') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </form>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">RFID UID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Saldo</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->rfid }}</td>
                            <td class="px-4 py-2">{{ $user->unit }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($user->balance, 2) }}</td>
                            <td class="px-4 py-2">
                                @if($user->is_admin)
                                    <span class="px-2 py-1 rounded bg-yellow-400 text-red-800 text-xs font-semibold">Admin</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-gray-200 text-gray-800 text-xs font-semibold">User</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-xs text-gray-500">{{ $user->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection