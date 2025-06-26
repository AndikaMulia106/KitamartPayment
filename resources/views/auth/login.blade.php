@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="w-full max-w-md">
        <div class="mb-4 text-lg font-bold text-red-600 text-center">
            {{ __('Login to RFID Payment System') }}
        </div>
        <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-lg shadow-md border-t-4 border-red-600">
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-red-600" />
                <x-text-input id="email" class="block mt-1 w-full border-yellow-400 focus:border-red-600" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('PIN')" class="text-red-600" />
                <x-text-input id="password" class="block mt-1 w-full border-yellow-400 focus:border-red-600" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
            </div>
            <!-- Remember Me & Button -->
            <div class="flex items-center justify-between mt-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-yellow-400 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                    <span class="ms-2 text-sm text-yellow-700">{{ __('Remember me') }}</span>
                </label>
                <x-primary-button class="bg-red-600 hover:bg-yellow-500 text-white">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection