@extends('layouts.app')

@section('title', 'Welcome')
@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-red-700 mb-6">
                Kitamart - Sistem Pembayaran RFID
            </h1>
            <p class="text-xl text-gray-700 max-w-3xl mx-auto mb-10">
                A modern solution for cashless payments using RFID technology. Manage your balance and transactions effortlessly.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-yellow-500 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-red-700 bg-yellow-100 hover:bg-yellow-200 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <i class="fas fa-user-plus mr-2"></i> Register
                        </a>
                    @endif
                @else
                    <a href="{{ route(auth()->user()->is_admin ? 'admin.dashboard' : 'user.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-yellow-500 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection