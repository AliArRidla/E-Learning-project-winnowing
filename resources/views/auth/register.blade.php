@extends('layouts.layauth')

@section('title', 'Daftar')

@section('content')
{{-- <x-guest-layout> --}}
    {{-- <x-auth-card> --}}
        {{-- <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot> --}}

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label>Nama Pengguna</label>
                <input class="au-input au-input--full" type="text" name="name" placeholder="Nama Pengguna">
            </div>

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

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" class="au-input au-input--full" type="password" name="password_confirmation"
                placeholder="Konfirmasi Kata Sandi">
            </div>

            <!-- Confirm Password -->
            {{-- <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div> --}}

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Daftar</button>

            {{-- <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah Daftar?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Daftar') }}
                </x-button>
            </div> --}}
        </form>
        <div class="register-link">
            <p>
                Sudah Punya Akun?
                <a href="{{ route('login') }}">Masuk</a>
            </p>
        </div>
    {{-- </x-auth-card> --}}
{{-- </x-guest-layout> --}}
@endsection