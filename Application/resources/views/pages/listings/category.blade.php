@extends('layouts.app')

@section('title', "{$category->name} Classifieds & Services - BuzzBazaar")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Category Hero Header -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <nav class="flex text-xs text-slate-500 mb-2" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('listings.index') }}" class="hover:text-amber-600">Categories</a>
                <span class="mx-2">/</span>
                <span class="text-slate-800 font-semibold">{{ $category->name }}</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $category->name }}
            </h1>
            <p class="text-sm text-slate-500 mt-1 max-w-xl">
                {{ $category->description ?? "Explore verified {$category->name} listings and services across India." }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-4 py-2 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
                {{ $listings->total() }} Active Ads
            </span>
            <a href="{{ route('listings.create', ['category_id' => $category->id]) }}" class="px-5 py-2.5 rounded-xl font-bold text-xs text-slate-950 bg-amber-400 hover:bg-amber-500 transition-colors shadow-sm inline-flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Post in this Category
            </a>
        </div>
    </div>

    <!-- Subcategories Pill Filter -->
    @if($category->subcategories->count() > 0)
        <div class="mb-6 flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-2">Subcategories:</span>
            <a href="{{ route('listings.category', $category->slug) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ !request('subcategory_id') ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:border-amber-300' }} transition-colors">
                All
            </a>
            @foreach($category->subcategories as $sub)
                <a href="{{ route('listings.category', [$category->slug, 'subcategory_id' => $sub->id]) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ request('subcategory_id') == $sub->id ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:border-amber-300' }} transition-colors">
                    {{ $sub->name }}
                </a>
            @endforeach
        </div>
    @endif

    <!-- City Filter Pills for this category -->
    @if(count($cities) > 0)
        <div class="mb-8 p-4 bg-slate-100/70 rounded-2xl border border-slate-200 flex flex-wrap items-center gap-2 text-xs">
            <span class="font-bold text-slate-700 mr-2"><i class="fa-solid fa-location-dot text-amber-500 mr-1"></i> Cities with {{ $category->name }}:</span>
            @foreach($cities as $city)
                <a href="{{ route('listings.city_category', [$city, $category->slug]) }}" class="px-3 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:border-amber-400 font-medium transition-colors">
                    {{ $city }}
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
            <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-4"></i>
            <h3 class="text-lg font-bold text-slate-800">No listings found in {{ $category->name }}</h3>
            <p class="text-sm text-slate-500 mt-1">Be the first to create an ad in this category!</p>
            <a href="{{ route('listings.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-400 text-slate-950">
                <i class="fa-solid fa-plus"></i> Post Ad Now
            </a>
        </div>
    @endif

</div>
@endsection
