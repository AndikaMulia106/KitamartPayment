@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="w-full max-w-md">
        <form method="POST" action="{{ route('register') }}" class="bg-white p-8 rounded-lg shadow-md border-t-4 border-yellow-400">
            @csrf
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-red-600" />
                <x-text-input id="name" class="block mt-1 w-full border-yellow-400 focus:border-red-600" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-red-600" />
                <x-text-input id="email" class="block mt-1 w-full border-yellow-400 focus:border-red-600" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
            </div>
            <!-- RFID UID -->
            <div class="mt-4">
                <x-input-label for="rfid" :value="__('RFID UID')" class="text-red-600" />
                <x-text-input id="rfid" class="block mt-1 w-full border-yellow-400 focus:border-red-600" type="text" name="rfid" :value="old('rfid')" required autocomplete="off" />
                <x-input-error :messages="$errors->get('rfid')" class="mt-2 text-red-600" />
            </div>
            <!-- Unit -->
            <div class="mt-4">
                <x-input-label for="unit" :value="__('Unit')" class="text-red-600" />
                <select id="unit" name="unit" class="block mt-1 w-full border-yellow-400 focus:border-red-600" required>
                    <option value="">-- Pilih Unit --</option>
                    <option value="SMAIT Abu Bakar Yogyakarta">SMAIT Abu Bakar Yogyakarta</option>
                    <option value="SMAIT Abu Bakar Boarding School Kulon Progo">SMAIT Abu Bakar Boarding School Kulon Progo</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <x-input-error :messages="$errors->get('unit')" class="mt-2 text-red-600" />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('PIN')" class="text-red-600" />
                <x-text-input id="password" class="block mt-1 w-full border-yellow-400 focus:border-red-600" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
            </div>
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-red-600" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full border-yellow-400 focus:border-red-600" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-yellow-700 hover:text-red-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button class="ms-4 bg-yellow-400 hover:bg-red-600 text-white">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection