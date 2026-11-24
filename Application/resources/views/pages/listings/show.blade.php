@extends('layouts.app')

@section('title', "{$listing->name} - BuzzBazaar")
@section('meta_description', Str::limit(strip_tags($listing->detail), 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumb -->
    <nav class="flex flex-wrap text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('listings.city', $listing->city) }}" class="hover:text-amber-600">{{ $listing->city }}</a>
        <span class="mx-2">/</span>
        <a href="{{ route('listings.category', $listing->category->slug) }}" class="hover:text-amber-600">{{ $listing->category->name }}</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $listing->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Columns: Image & Listing Details -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Main Image Viewer -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm relative">
                <div class="aspect-[16/10] bg-slate-900 flex items-center justify-center overflow-hidden">
                    <img src="{{ $listing->image_path ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=1200&q=80' }}" 
                         alt="{{ $listing->name }}" 
                         class="w-full h-full object-cover">
                </div>

                <!-- Floating Badges -->
                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                    @if($listing->listing_type === 'service')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-600 text-white shadow-md">
                            <i class="fa-solid fa-handshake-angle text-xs"></i> Verified Service
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-600 text-white shadow-md">
                            <i class="fa-solid fa-box text-xs"></i> Verified Product
                        </span>
                    @endif
                </div>

                <div class="absolute bottom-4 right-4 bg-slate-900/80 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-2">
                    <i class="fa-solid fa-eye text-amber-400"></i> {{ $listing->views }} views
                </div>
            </div>

            <!-- Description & Details Section -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                
                <h2 class="text-xl font-extrabold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-file-lines text-amber-500"></i> Description & Overview
                </h2>

                <div class="prose max-w-none text-slate-700 text-sm leading-relaxed whitespace-pre-line mb-8">
                    {{ $listing->detail }}
                </div>

                <!-- All 10 Field Breakdown Table -->
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">
                    Mandatory Field Specifications
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">1. Listing Type:</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $listing->listing_type }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">2. Category:</span>
                        <a href="{{ route('listings.category', $listing->category->slug) }}" class="font-bold text-amber-600 hover:underline">
                            {{ $listing->category->name }}
                        </a>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">3. Subcategory:</span>
                        <span class="font-bold text-slate-900">{{ $listing->subcategory->name }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">4. Country:</span>
                        <span class="font-bold text-slate-900">{{ $listing->country }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">5. State:</span>
                        <span class="font-bold text-slate-900">{{ $listing->state }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">6. City:</span>
                        <a href="{{ route('listings.city', $listing->city) }}" class="font-bold text-amber-600 hover:underline">
                            {{ $listing->city }}
                        </a>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">7. Area:</span>
                        <span class="font-bold text-slate-900">{{ $listing->area }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">8. Posted Date:</span>
                        <span class="font-bold text-slate-900">{{ $listing->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- Right 1 Column: Price, Seller & Contact -->
        <div class="space-y-6">
            
            <!-- Price Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Listed Price</span>
                <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1 mb-2">
                    ₹{{ number_format($listing->price, 2) }}
                </div>
                
                <h1 class="text-lg font-bold text-slate-800 mb-4 leading-snug">
                    {{ $listing->name }}
                </h1>

                <div class="flex items-center gap-2 text-xs text-slate-500 mb-6">
                    <i class="fa-solid fa-location-dot text-amber-500"></i>
                    <span>{{ $listing->area }}, {{ $listing->city }}, {{ $listing->state }}</span>
                </div>

                <!-- Call to Action Buttons -->
                <div class="space-y-3">
                    <button onclick="alert('Seller Contact Details:\nName: {{ $listing->user->name }}\nEmail: {{ $listing->user->email }}\nLocation: {{ $listing->area }}, {{ $listing->city }}')" class="w-full py-3.5 px-4 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-lg hover:shadow-amber-500/25 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-phone"></i>
                        <span>Show Contact Info</span>
                    </button>

                    <button onclick="alert('Inquiry notification delivered to {{ $listing->user->name }}.')" class="w-full py-3 px-4 rounded-xl font-bold text-xs text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-comments"></i>
                        <span>Send Chat Message</span>
                    </button>
                </div>
            </div>

            <!-- Seller Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Seller Information</h3>
                
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-amber-400 to-amber-500 text-slate-950 font-extrabold flex items-center justify-center text-lg border border-amber-300 shadow-sm">
                        {{ strtoupper(substr($listing->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-sm flex items-center gap-1.5">
                            {{ $listing->user->name }}
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs" title="Verified User"></i>
                        </h4>
                        <p class="text-xs text-slate-400">Member since {{ $listing->user->created_at->format('M Y') }}</p>
                    </div>
                </div>

                <div class="p-3 rounded-xl bg-slate-50 text-xs text-slate-600 flex items-center justify-between">
                    <span>Verified Email:</span>
                    <span class="font-bold text-slate-800">{{ $listing->user->email }}</span>
                </div>
            </div>

            <!-- Safety Guidelines Box (OLX style) -->
            <div class="bg-amber-50/70 rounded-3xl border border-amber-200/80 p-6 text-slate-700">
                <h3 class="text-xs font-bold uppercase tracking-wider text-amber-900 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-amber-600"></i> Safety Guidelines
                </h3>
                <ul class="space-y-2 text-xs leading-relaxed text-slate-600">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                        <span>Meet in a safe, public place like a coffee shop or mall.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                        <span>Inspect the item or verify service credentials before paying.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                        <span>Never transfer advance money to unverified bank accounts.</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>

    <!-- Related Category Listings -->
    @if($relatedListings->count() > 0)
        <div class="mt-16 pt-10 border-t border-slate-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Similar Listings in {{ $listing->category->name }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Other items you might be interested in</p>
                </div>
                <a href="{{ route('listings.category', $listing->category->slug) }}" class="text-xs font-bold text-amber-600 hover:underline">
                    View More <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedListings as $rel)
                    <x-listing-card :listing="$rel" />
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
