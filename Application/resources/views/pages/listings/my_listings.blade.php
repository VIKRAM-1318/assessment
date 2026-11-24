@extends('layouts.app')

@section('title', 'My Active Listings - BuzzBazaar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <nav class="flex text-xs text-slate-500 mb-2" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
                <span class="mx-2">/</span>
                <span class="text-slate-800 font-semibold">Dashboard</span>
            </nav>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">My Active Listings</h1>
            <p class="text-xs text-slate-500 mt-1">Manage your posted products and services</p>
        </div>

        <a href="{{ route('listings.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-slate-950 bg-amber-400 hover:bg-amber-500 shadow-sm transition-all">
            <i class="fa-solid fa-plus"></i> Post Another Ad
        </a>
    </div>

    @if($listings->count() > 0)
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="divide-y divide-slate-100">
                @foreach($listings as $item)
                    <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition-colors">
                        
                        <div class="flex items-center gap-4">
                            <img src="{{ $item->image_path ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=300&q=80' }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-20 h-20 rounded-2xl object-cover border border-slate-200 flex-shrink-0">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    @if($item->listing_type === 'service')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase">Service</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 uppercase">Product</span>
                                    @endif
                                    <span class="text-xs text-slate-400">{{ $item->category->name }} &bull; {{ $item->city }}</span>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm">
                                    <a href="{{ route('listings.show', $item->id) }}" class="hover:text-amber-600">
                                        {{ $item->name }}
                                    </a>
                                </h3>
                                <p class="text-base font-extrabold text-slate-900 mt-1">
                                    ₹{{ number_format($item->price, 0) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                            <span class="text-xs text-slate-400 mr-2">
                                <i class="fa-solid fa-eye text-amber-500"></i> {{ $item->views }} views
                            </span>
                            <a href="{{ route('listings.show', $item->id) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-700 hover:bg-slate-200">
                                View Ad
                            </a>
                            <form method="POST" action="{{ route('listings.destroy', $item->id) }}" onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $listings->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl p-16 text-center border border-slate-200">
            <i class="fa-solid fa-layer-group text-4xl text-slate-300 mb-3"></i>
            <h3 class="text-lg font-bold text-slate-800">You haven't posted any listings yet</h3>
            <p class="text-sm text-slate-500 mt-1">List a vehicle, phone, property or service today.</p>
            <a href="{{ route('listings.create') }}" class="mt-4 inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-slate-950 bg-amber-400 hover:bg-amber-500 shadow-md">
                <i class="fa-solid fa-plus"></i> Post Your First Ad
            </a>
        </div>
    @endif

</div>
@endsection
