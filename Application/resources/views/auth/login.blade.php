@extends('layouts.app')

@section('title', 'Log In - BuzzBazaar Marketplace')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-200 shadow-xl">
        
        <div class="text-center mb-8">
            <div class="inline-flex w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-amber-400 items-center justify-center text-slate-950 font-bold mb-3 shadow-md">
                <i class="fa-solid fa-arrow-right-to-bracket text-xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Welcome back</h2>
            <p class="text-sm text-slate-500 mt-1">Access your saved listings, inquiries, and messages</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Address</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-slate-400"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="you@domain.com"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all">
                </div>
                @error('email')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Password</label>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400"></i>
                    <input id="password" type="password" name="password" required
                           placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('password') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all">
                </div>
                @error('password')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-amber-500 border-slate-300 rounded focus:ring-amber-400">
                <label for="remember" class="ml-2 block text-xs text-slate-600 font-medium">Keep me signed in</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-lg hover:shadow-amber-500/25 transition-all">
                Sign In to Account
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
            Don't have an account yet? 
            <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:underline">Register free</a>
        </div>
    </div>
</div>
@endsection
