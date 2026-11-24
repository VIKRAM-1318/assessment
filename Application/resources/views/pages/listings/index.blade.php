@extends('layouts.app')

@section('title', 'Browse Listings - BuzzBazaar Marketplace')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex text-xs text-slate-500 mb-2" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
                <span class="mx-2">/</span>
                <span class="text-slate-800 font-semibold">Browse Listings</span>
            </nav>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                All Available Classifieds & Services
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Showing {{ $listings->total() }} matching result(s)
            </p>
        </div>
    </div>

    <!-- Layout with Sidebar & Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filter Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm sticky top-28">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <h3 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-amber-500"></i> Filters
                    </h3>
                    @if(request()->anyFilled(['search', 'city', 'category_id', 'subcategory_id', 'listing_type', 'min_price', 'max_price']))
                        <a href="{{ route('listings.index') }}" class="text-xs font-bold text-rose-600 hover:underline">
                            Reset All
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('listings.index') }}" class="space-y-5">
                    
                    <!-- Search Keyword -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Keywords</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or detail..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-200">
                    </div>

                    <!-- Listing Type -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Listing Type</label>
                        <select name="listing_type" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-amber-500">
                            <option value="">All Types (Products & Services)</option>
                            <option value="product" {{ request('listing_type') == 'product' ? 'selected' : '' }}>Products Only</option>
                            <option value="service" {{ request('listing_type') == 'service' ? 'selected' : '' }}>Services Only</option>
                        </select>
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">City</label>
                        <select name="city" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-amber-500">
                            <option value="">All Cities</option>
                            @foreach($cities as $c)
                                <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Category</label>
                        <select name="category_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-amber-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Price Range (₹)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Sort By</label>
                        <select name="sort" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-amber-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newly Listed</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Viewed</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-bold text-xs text-slate-950 bg-amber-400 hover:bg-amber-500 shadow-sm transition-colors">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Listings Grid -->
        <div class="lg:col-span-3">
            @if($listings->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($listings as $listing)
                        <x-listing-card :listing="$listing" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $listings->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
                    <i class="fa-solid fa-magnifying-glass text-4xl text-slate-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-slate-800">No matching listings found</h3>
                    <p class="text-sm text-slate-500 mt-1">Try adjusting your filters, location, or search keywords.</p>
                    <a href="{{ route('listings.index') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white">
                        Clear All Filters
                    </a>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
