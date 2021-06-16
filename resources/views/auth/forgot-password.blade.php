@extends('layouts.layauth')

@section('title', 'Lupa Kata Sandi')

@section('content')

{{-- <x-guest-layout> --}}
    {{-- <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot> --}}

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Apakah Anda lupa password Anda? Silahkan isi dengan email yang telah Anda daftarkan pada sistem kami, kami akan mengirimkan link untuk melakukan reset password.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label>Alamat E-mail</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Masukkan Alamat E-mail Anda" id="email" required autofocus>
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Email Password Reset Link</button> --}}
                <x-button>
                    {{ __('Pengaturan Ulang Email dan Kata Sandi') }}
                </x-button>
            </div>
        </form>
    {{-- </x-auth-card> --}}
{{-- </x-guest-layout> --}}
@endsection