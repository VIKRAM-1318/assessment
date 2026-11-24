@props(['listing'])

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-amber-300 transition-all duration-200 flex flex-col group">
    <!-- Image with Badges -->
    <a href="{{ route('listings.show', $listing->id) }}" class="relative aspect-[4/3] overflow-hidden bg-slate-100 block">
        <img src="{{ $listing->image_path ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80' }}" 
             alt="{{ $listing->name }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        
        <!-- Type Badge (Product vs Service) -->
        <div class="absolute top-3 left-3 flex flex-wrap gap-1">
            @if($listing->listing_type === 'service')
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-emerald-600 text-white shadow-sm">
                    <i class="fa-solid fa-handshake-angle text-[10px]"></i> Service
                </span>
            @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-blue-600 text-white shadow-sm">
                    <i class="fa-solid fa-box text-[10px]"></i> Product
                </span>
            @endif
        </div>

        <!-- Category Badge -->
        <div class="absolute bottom-3 left-3">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-900/80 backdrop-blur-sm text-white">
                {{ $listing->category->name ?? 'General' }}
            </span>
        </div>
    </a>

    <!-- Card Body -->
    <div class="p-4 flex flex-col flex-1">
        <!-- Price Display -->
        <div class="flex items-baseline justify-between mb-1.5">
            <span class="text-xl font-extrabold text-slate-900 tracking-tight">
                ₹{{ number_format($listing->price, 0) }}
            </span>
            <span class="text-[11px] text-slate-400 font-medium">
                {{ $listing->created_at->diffForHumans(null, true) }} ago
            </span>
        </div>

        <!-- Name / Title -->
        <h3 class="font-semibold text-slate-800 text-sm mb-2 line-clamp-2 group-hover:text-amber-600 transition-colors">
            <a href="{{ route('listings.show', $listing->id) }}">
                {{ $listing->name }}
            </a>
        </h3>

        <!-- Location (City, Area) -->
        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <div class="flex items-center gap-1 truncate max-w-[190px]">
                <i class="fa-solid fa-location-dot text-amber-500 flex-shrink-0"></i>
                <span class="truncate">{{ $listing->area }}, {{ $listing->city }}</span>
            </div>
            <a href="{{ route('listings.show', $listing->id) }}" class="text-amber-600 font-bold hover:underline flex items-center gap-1">
                View <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>
