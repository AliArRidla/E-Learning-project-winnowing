@extends('layouts.layauth')

@section('title', 'Verify Email')

@section('content')
{{-- <x-guest-layout> --}}
    {{-- <x-auth-card> --}}
        {{-- <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot> --}}

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Halo! E-mail verifikasi telah dikirim. Silakan logout terlebih dahulu lalu cek kotak masuk email Anda untuk melakukan konfirmasi!') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Tautan verifikasi baru sudah terkirim ke e-mail yang Anda daftarkan pada halaman registrasi. Silakan cek kotak masuk e-mail Anda!') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    {{-- </x-auth-card> --}}
{{-- </x-guest-layout> --}}
@endsection