@extends('layouts.app')

@section('title', 'BuzzBazaar - Buy & Sell Products & Services in India')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-b from-amber-50 via-white to-slate-50 border-b border-slate-200 py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-8">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-200/60 text-amber-900 border border-amber-300 mb-4">
                <i class="fa-solid fa-sparkles text-amber-600"></i> Next-Gen Classifieds & Services
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Buy, Sell & Hire with Confidence Across <span class="text-amber-500 underline decoration-amber-400 decoration-wavy decoration-2">India</span>
            </h1>
            <p class="mt-4 text-slate-600 text-sm sm:text-base leading-relaxed">
                Explore thousands of verified cars, electronics, properties, and professional on-demand services in your local city.
            </p>
        </div>

        <!-- Quick Metrics -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-4xl mx-auto mb-10">
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center">
                <p class="text-2xl font-extrabold text-slate-900">{{ $totalListings }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-0.5">Active Listings</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center">
                <p class="text-2xl font-extrabold text-blue-600">{{ $totalProducts }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-0.5">Physical Products</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center">
                <p class="text-2xl font-extrabold text-emerald-600">{{ $totalServices }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-0.5">Professional Services</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center">
                <p class="text-2xl font-extrabold text-amber-500">{{ count($featuredCities) }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-0.5">Top Cities</p>
            </div>
        </div>

        <!-- Quick City Selector Cards -->
        <div class="flex flex-wrap items-center justify-center gap-2 text-xs">
            <span class="text-slate-500 font-bold mr-2"><i class="fa-solid fa-map-pin text-amber-500 mr-1"></i> Popular Cities:</span>
            @foreach($featuredCities as $city)
                <a href="{{ route('listings.city', $city) }}" class="px-3.5 py-1.5 rounded-full bg-white border border-slate-200 hover:border-amber-400 hover:bg-amber-50 text-slate-700 font-medium transition-all shadow-sm">
                    {{ $city }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Category Grid Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Explore Categories</h2>
            <p class="text-sm text-slate-500 mt-1">Browse verified ads grouped by category</p>
        </div>
        <a href="{{ route('listings.index') }}" class="text-sm font-bold text-amber-600 hover:text-amber-700 flex items-center gap-1">
            View All <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
        @php
            $catIcons = [
                'vehicles' => 'fa-car',
                'electronics-appliances' => 'fa-laptop',
                'real-estate-properties' => 'fa-city',
                'jobs-professional-services' => 'fa-briefcase',
                'home-furniture' => 'fa-couch',
                'education-classes' => 'fa-graduation-cap',
            ];
            $catColors = [
                'vehicles' => 'bg-blue-50 text-blue-600 border-blue-200',
                'electronics-appliances' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                'real-estate-properties' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                'jobs-professional-services' => 'bg-amber-50 text-amber-600 border-amber-200',
                'home-furniture' => 'bg-rose-50 text-rose-600 border-rose-200',
                'education-classes' => 'bg-purple-50 text-purple-600 border-purple-200',
            ];
        @endphp

        @foreach($categories as $category)
            <a href="{{ route('listings.category', $category->slug) }}" class="group bg-white p-5 rounded-2xl border border-slate-200 hover:border-amber-400 hover:shadow-lg transition-all flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-2xl {{ $catColors[$category->slug] ?? 'bg-amber-50 text-amber-600 border-amber-200' }} border flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition-transform">
                    <i class="fa-solid {{ $catIcons[$category->slug] ?? 'fa-cube' }}"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-800 group-hover:text-amber-600 transition-colors">
                    {{ $category->name }}
                </h3>
                <span class="text-xs text-slate-400 mt-1 font-medium">
                    {{ $category->listings_count }} ads
                </span>
            </a>
        @endforeach
    </div>
</section>

<!-- Latest Recommendations Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Fresh Recommendations</h2>
            <p class="text-sm text-slate-500 mt-1">Recently posted products and professional services</p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex items-center gap-2">
            <a href="{{ route('listings.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-white shadow-sm">
                All Listings
            </a>
            <a href="{{ route('listings.index', ['listing_type' => 'product']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 transition-colors">
                Products ({{ $totalProducts }})
            </a>
            <a href="{{ route('listings.index', ['listing_type' => 'service']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 transition-colors">
                Services ({{ $totalServices }})
            </a>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($latestListings as $listing)
            <x-listing-card :listing="$listing" />
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                <i class="fa-solid fa-box-open text-4xl text-slate-300 mb-3"></i>
                <h3 class="text-base font-bold text-slate-700">No listings posted yet</h3>
                <p class="text-sm text-slate-500 mt-1">Be the first to post a product or service!</p>
                <a href="{{ route('listings.create') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm text-slate-950 bg-amber-400 hover:bg-amber-500">
                    <i class="fa-solid fa-plus"></i> Post Ad Now
                </a>
            </div>
        @endforelse
    </div>
</section>

<!-- Featured Services Spotlight -->
<section class="bg-amber-500/10 border-y border-amber-200/60 py-14 my-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="inline-flex items-center gap-1 text-xs font-extrabold text-amber-700 uppercase tracking-widest">
                    <i class="fa-solid fa-award"></i> On-Demand Freelancers & Agencies
                </span>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Professional Services Spotlight</h2>
            </div>
            <a href="{{ route('listings.index', ['listing_type' => 'service']) }}" class="text-sm font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                Explore All Services <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestServices->take(3) as $service)
                <div class="bg-white p-6 rounded-3xl border border-amber-200/80 shadow-md flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-emerald-600 text-white">
                                <i class="fa-solid fa-handshake-angle text-[10px]"></i> Professional Service
                            </span>
                            <span class="text-xs font-bold text-slate-400">
                                {{ $service->city }}
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 line-clamp-2">
                            <a href="{{ route('listings.show', $service->id) }}" class="hover:text-amber-600">
                                {{ $service->name }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed mb-4">
                            {{ $service->detail }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Starting from</span>
                            <span class="text-lg font-extrabold text-slate-900">₹{{ number_format($service->price, 0) }}</span>
                        </div>
                        <a href="{{ route('listings.show', $service->id) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white">
                            Contact Specialist
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-6">
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8 shadow-xl">
        <div class="max-w-xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-slate-950 uppercase tracking-wider mb-3">
                Sell Faster & Smarter
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Have something to sell or a service to offer?</h2>
            <p class="text-slate-300 text-sm mt-2 leading-relaxed">
                Reach verified local buyers across India in minutes. Free ad posting with zero commissions!
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('listings.create') }}" class="px-8 py-4 rounded-2xl font-extrabold text-base text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-xl hover:shadow-amber-500/30 transition-all inline-flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-lg"></i>
                <span>POST FREE LISTING NOW</span>
            </a>
        </div>
    </div>
</section>
@endsection
