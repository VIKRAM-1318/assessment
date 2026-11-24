@extends('layouts.app')

@section('title', 'Create Account - BuzzBazaar Marketplace')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-200 shadow-xl">
        
        <div class="text-center mb-8">
            <div class="inline-flex w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-amber-400 items-center justify-center text-slate-950 font-bold mb-3 shadow-md">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Create your account</h2>
            <p class="text-sm text-slate-500 mt-1">Join thousands of verified buyers and sellers on BuzzBazaar</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Full Name</label>
                <div class="relative">
                    <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-slate-400"></i>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="e.g. Arjun Sharma"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('name') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all">
                </div>
                @error('name')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Address</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-slate-400"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           placeholder="you@domain.com"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all">
                </div>
                @error('email')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password (Min 8 Characters)</label>
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

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Confirm Password</label>
                <div class="relative">
                    <i class="fa-solid fa-shield-check absolute left-3.5 top-3.5 text-slate-400"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-lg hover:shadow-amber-500/25 transition-all">
                Register & Start Trading
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:underline">Log in here</a>
        </div>
    </div>
</div>
@endsection
