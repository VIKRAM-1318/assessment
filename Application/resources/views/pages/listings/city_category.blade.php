@extends('layouts.app')

@section('title', "{$category->name} in {$cleanCity} - BuzzBazaar")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Combined Header Banner -->
    <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-3xl p-8 sm:p-10 text-slate-950 shadow-lg mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <nav class="flex text-xs text-slate-900/80 mb-2 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('listings.city', $cleanCity) }}" class="hover:underline">{{ $cleanCity }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('listings.category', $category->slug) }}" class="hover:underline">{{ $category->name }}</a>
            </nav>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-950 text-amber-400 flex items-center justify-center font-bold text-lg shadow-sm">
                    <i class="fa-solid fa-tag"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    {{ $category->name }} in {{ $cleanCity }}
                </h1>
            </div>
            <p class="text-sm text-slate-900/90 mt-2 max-w-xl font-medium">
                Showing all verified {{ strtolower($category->name) }} deals, items, and specialized services located in {{ $cleanCity }}.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-4 py-2 rounded-2xl bg-slate-950/20 backdrop-blur-sm border border-slate-950/20 text-slate-950 text-xs font-extrabold">
                {{ $listings->total() }} Listings
            </span>
            <a href="{{ route('listings.create') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-slate-950 hover:bg-slate-900 transition-colors shadow-sm inline-flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-amber-400"></i> Post in {{ $cleanCity }}
            </a>
        </div>
    </div>

    <!-- Subcategories filter in this city -->
    @if($category->subcategories->count() > 0)
        <div class="mb-6 flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-2">Filter Subcategory:</span>
            <a href="{{ route('listings.city_category', [$cleanCity, $category->slug]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ !request('subcategory_id') ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:border-amber-300' }} transition-colors">
                All Subcategories
            </a>
            @foreach($category->subcategories as $sub)
                <a href="{{ route('listings.city_category', [$cleanCity, $category->slug, 'subcategory_id' => $sub->id]) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ request('subcategory_id') == $sub->id ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:border-amber-300' }} transition-colors">
                    {{ $sub->name }}
                </a>
            @endforeach
        </div>
    @endif

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
            <i class="fa-solid fa-box-open text-4xl text-slate-300 mb-4"></i>
            <h3 class="text-lg font-bold text-slate-800">No {{ $category->name }} listings found in {{ $cleanCity }}</h3>
            <p class="text-sm text-slate-500 mt-1">Be the first to list a {{ strtolower($category->name) }} product or service in {{ $cleanCity }}!</p>
            <a href="{{ route('listings.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-400 text-slate-950">
                <i class="fa-solid fa-plus"></i> Post Ad Now
            </a>
        </div>
    @endif

</div>
@endsection
