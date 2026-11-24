@extends('layouts.app')

@section('title', "Classifieds and Services in {$cleanCity} - BuzzBazaar")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- City Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-lg mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <nav class="flex text-xs text-slate-400 mb-2" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-400">Home</a>
                <span class="mx-2">/</span>
                <span class="text-amber-400 font-semibold">{{ $cleanCity }}</span>
            </nav>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Classifieds & Services in {{ $cleanCity }}
                </h1>
            </div>
            <p class="text-sm text-slate-300 mt-2 max-w-xl">
                Browse verified local products, electronics, cars, apartments, and services in {{ $cleanCity }}.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-bold">
                {{ $listings->total() }} Local Ads
            </span>
            <a href="{{ route('listings.create') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs text-slate-950 bg-amber-400 hover:bg-amber-500 transition-colors shadow-sm inline-flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Post in {{ $cleanCity }}
            </a>
        </div>
    </div>

    <!-- City + Category Quick Links -->
    <div class="mb-8 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
            Filter by Category in {{ $cleanCity }}:
        </h3>
        <div class="flex flex-wrap gap-2">
            @foreach($categories as $cat)
                <a href="{{ route('listings.city_category', [$cleanCity, $cat->slug]) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 hover:bg-amber-50 hover:border-amber-300 transition-colors">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Listings Grid -->
    @if($listings->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($listings as $listing)
                <x-listing-card :listing="$listing" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $listings->links() }}
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
            <i class="fa-solid fa-map-location-dot text-4xl text-slate-300 mb-4"></i>
            <h3 class="text-lg font-bold text-slate-800">No listings found in {{ $cleanCity }}</h3>
            <p class="text-sm text-slate-500 mt-1">Be the first to post a product or service in {{ $cleanCity }}!</p>
            <a href="{{ route('listings.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-400 text-slate-950">
                <i class="fa-solid fa-plus"></i> Post Ad Now
            </a>
        </div>
    @endif

</div>
@endsection
