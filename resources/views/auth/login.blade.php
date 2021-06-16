@extends('layouts.layauth')

@section('title', 'Masuk')

@section('content')

{{-- <x-guest-layout> --}}
    {{-- <x-auth-card> --}}
        {{-- <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot> --}}

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label>Alamat E-mail</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Masukkan E-mail Anda">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Kata Sandi</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Masukkan Kata Sandi Anda">
            </div>

            <!-- Remember Me -->
            {{-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                </label>
            </div> --}}

            <div class="login-checkbox">
                <label>
                    <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                </label>
            </div>
            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Masuk</button>

            {{-- <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Lupa Kata Sandi?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Masuk') }}
                </x-button>
            </div> --}}
        </form>
        {{-- <div class="register-link">
            <p>
                Don't you have account?
                <a href="{{ route('register') }}">Sign Up Here</a>
            </p>
        </div> --}}
    {{-- </x-auth-card> --}}
{{-- </x-guest-layout> --}}
@endsection