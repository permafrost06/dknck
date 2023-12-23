@extends('layouts.auth')

@section('page')
<main class="h-[100vh] w-[100vw] flex justify-center md:items-center bg-gradient-to-r from-slate-100 to-slate-400 md:p-10">
    <div class="w-full max-w-xl md:rounded-2xl shadow-lg overflow-hidden">
        <div class="p-10 bg-skin-foreground">
            <h1 class="text-3xl font-medium mb-5">{{ config('app.name') }}</h1>
            <h2 class="border-b pb-5">Login</h2>
            <form class="py-2 space-y-4" action="{{ route('login') }}" method="POST">
                @csrf
                <x-form.alert />
                <x-form.ic-input type="email" name="email" :value="old('email')" placeholder="Your email" label="Email" hint=" ">
                    <x-slot:svg viewBox="0 0 20 20">
                        <path fill="currentColor" d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path fill="currentColor" d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </x-slot:svg>
                </x-form.ic-input>
                <x-form.ic-input type="password" name="password" :value="old('password')" placeholder="Your password" label="Password">
                    <x-slot:svg>
                        <path fill="currentColor" d="M22 19h-6v-4h-2.68c-1.14 2.42-3.6 4-6.32 4c-3.86 0-7-3.14-7-7s3.14-7 7-7c2.72 0 5.17 1.58 6.32 4H24v6h-2v4zm-4-2h2v-4h2v-2H11.94l-.23-.67C11.01 8.34 9.11 7 7 7c-2.76 0-5 2.24-5 5s2.24 5 5 5c2.11 0 4.01-1.34 4.71-3.33l.23-.67H18v4zM7 15c-1.65 0-3-1.35-3-3s1.35-3 3-3s3 1.35 3 3s-1.35 3-3 3zm0-4c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1z" />
                    </x-slot:svg>
                </x-form.ic-input>

                <div class="flex items-center py-2">
                    <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-skin-accent bg-skin-neutral bg-opacity-5 border-skin-neutral border-opacity-10 rounded focus:ring-skin-accent focus:ring-2">
                    <label for="remember" class="ml-2 text-sm font-medium">Remember Me</label>
                </div>

                <div class="text-right pt-5 border-t">
                    <x-button type="submit" class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" viewBox="0 0 8 8">
                            <path fill="currentColor" d="M3 0v1h4v5H3v1h5V0H3zm1 2v1H0v1h4v1l2-1.5L4 2z" />
                        </svg>LOGIN
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection