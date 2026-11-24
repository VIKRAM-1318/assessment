@extends('layouts.app')

@section('title', 'Post New Listing - BuzzBazaar Marketplace')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex text-xs text-slate-500 mb-2" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800 font-semibold">Post Ad</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Post Your Ad on BuzzBazaar</h1>
        <p class="text-sm text-slate-500 mt-1">Fill in the 10 mandatory fields below to publish your product or service</p>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        
        <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data" class="p-6 sm:p-10 space-y-8">
            @csrf

            <!-- 1. MANDATORY FIELD: Product / Service Selection -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                    <span class="text-amber-600 mr-1">1.</span> Select Listing Type <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:border-amber-400 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-box text-blue-600"></i> Physical Product
                            </span>
                            <input type="radio" name="listing_type" value="product" {{ old('listing_type', 'product') === 'product' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                        </div>
                        <p class="text-xs text-slate-500">Selling a physical item (Car, Smartphone, Furniture, Laptop, Real Estate, etc.)</p>
                    </label>

                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all hover:border-amber-400 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-handshake-angle text-emerald-600"></i> Professional Service
                            </span>
                            <input type="radio" name="listing_type" value="service" {{ old('listing_type') === 'service' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                        </div>
                        <p class="text-xs text-slate-500">Offering skills, consultancy, software development, design, tutoring, repair, etc.</p>
                    </label>
                </div>
                @error('listing_type')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-slate-100">

            <!-- 2 & 3. MANDATORY FIELDS: Category & Subcategory -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                        <span class="text-amber-600 mr-1">2.</span> Category <span class="text-rose-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" required class="w-full px-4 py-3 rounded-xl border @error('category_id') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all font-medium">
                        <option value="">-- Choose Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', request('category_id')) == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subcategory (Dynamically populated) -->
                <div>
                    <label for="subcategory_id" class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                        <span class="text-amber-600 mr-1">3.</span> Subcategory <span class="text-rose-500">*</span>
                    </label>
                    <select id="subcategory_id" name="subcategory_id" required class="w-full px-4 py-3 rounded-xl border @error('subcategory_id') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all font-medium">
                        <option value="">-- Select Category First --</option>
                    </select>
                    @error('subcategory_id')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 4. MANDATORY FIELD: Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                    <span class="text-amber-600 mr-1">4.</span> Listing Name / Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. 2023 Royal Enfield Meteor 350 or Full Stack Laravel Web Development"
                       class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all">
                <span class="text-[11px] text-slate-400 mt-1 block">Mention key details like brand, model, condition, or service specialization.</span>
                @error('name')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 5. MANDATORY FIELD: Detail -->
            <div>
                <label for="detail" class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                    <span class="text-amber-600 mr-1">5.</span> Listing Detail / Description <span class="text-rose-500">*</span>
                </label>
                <textarea id="detail" name="detail" rows="5" required
                          placeholder="Include full specifications, warranty, condition, features, deliverables, terms, and reasons for selling..."
                          class="w-full px-4 py-3 rounded-xl border @error('detail') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm transition-all leading-relaxed">{{ old('detail') }}</textarea>
                <span class="text-[11px] text-slate-400 mt-1 block">Minimum 10 characters. Detailed listings receive 3x more inquiries.</span>
                @error('detail')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 6. MANDATORY FIELD: Price -->
            <div>
                <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                    <span class="text-amber-600 mr-1">6.</span> Price (₹) <span class="text-rose-500">*</span>
                </label>
                <div class="relative max-w-sm">
                    <span class="absolute left-4 top-3 text-sm font-bold text-slate-500">₹</span>
                    <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price') }}" required
                           placeholder="0.00"
                           class="w-full pl-8 pr-4 py-3 rounded-xl border @error('price') border-rose-500 @else border-slate-200 @enderror focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm font-bold transition-all">
                </div>
                @error('price')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-slate-100">

            <!-- 7, 8, 9, 10. MANDATORY FIELDS: Country, State, City, Area -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-amber-500"></i> Location Breakdown (Fields 7 - 10)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    
                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-xs font-semibold text-slate-700 mb-1">
                            <span class="text-amber-600 mr-0.5">7.</span> Country <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="country" name="country" value="{{ old('country', 'India') }}" required
                               class="w-full px-3 py-2.5 rounded-xl border @error('country') border-rose-500 @else border-slate-200 @enderror text-xs focus:border-amber-500">
                        @error('country')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-xs font-semibold text-slate-700 mb-1">
                            <span class="text-amber-600 mr-0.5">8.</span> State <span class="text-rose-500">*</span>
                        </label>
                        <select id="state" name="state" required
                                class="w-full px-3 py-2.5 rounded-xl border @error('state') border-rose-500 @else border-slate-200 @enderror text-xs focus:border-amber-500 bg-white">
                            <option value="">-- Select Indian State / UT --</option>
                            @php
                                $statesList = array_keys(config('india_locations.states', []));
                            @endphp
                            @foreach($statesList as $st)
                                <option value="{{ $st }}" {{ old('state', 'Karnataka') == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-xs font-semibold text-slate-700 mb-1">
                            <span class="text-amber-600 mr-0.5">9.</span> City <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="city" name="city" list="cities-list" value="{{ old('city', 'Bangalore') }}" required
                               placeholder="Select or type city..."
                               class="w-full px-3 py-2.5 rounded-xl border @error('city') border-rose-500 @else border-slate-200 @enderror text-xs focus:border-amber-500">
                        <datalist id="cities-list">
                            <!-- Populated dynamically via JS -->
                        </datalist>
                        @error('city')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Area -->
                    <div>
                        <label for="area" class="block text-xs font-semibold text-slate-700 mb-1">
                            <span class="text-amber-600 mr-0.5">10.</span> Area / Locality <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="area" name="area" value="{{ old('area') }}" required
                               placeholder="e.g. Indiranagar"
                               class="w-full px-3 py-2.5 rounded-xl border @error('area') border-rose-500 @else border-slate-200 @enderror text-xs focus:border-amber-500">
                        @error('area')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Optional Media / Photo Upload -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                    Photos / Media
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="image" class="block text-xs font-semibold text-slate-600 mb-1">Upload Photo from Device</label>
                        <input type="file" id="image" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-900 hover:file:bg-amber-200">
                        <span class="text-[10px] text-slate-400 block mt-1">PNG, JPG, WEBP up to 5MB.</span>
                        @error('image')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image_url" class="block text-xs font-semibold text-slate-600 mb-1">Or Paste Image URL</label>
                        <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200">
                        <span class="text-[10px] text-slate-400 block mt-1">Optional direct web image link.</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500">
                    By posting, you confirm this listing complies with BuzzBazaar's safety policies.
                </p>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-xl hover:shadow-amber-500/25 transition-all">
                    Publish Listing Now
                </button>
            </div>

        </form>

    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');
        const oldSubcategoryId = "{{ old('subcategory_id') }}";

        function loadSubcategories(categoryId) {
            if (!categoryId) {
                subcategorySelect.innerHTML = '<option value="">-- Select Category First --</option>';
                return;
            }

            subcategorySelect.innerHTML = '<option value="">Loading subcategories...</option>';

            fetch(`/api/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    subcategorySelect.innerHTML = '<option value="">-- Choose Subcategory --</option>';
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name;
                        if (oldSubcategoryId && sub.id == oldSubcategoryId) {
                            option.selected = true;
                        }
                        subcategorySelect.appendChild(option);
                    });
                })
                .catch(err => {
                    console.error('Error fetching subcategories:', err);
                    subcategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
                });
        }

        categorySelect.addEventListener('change', function () {
            loadSubcategories(this.value);
        });

        // Trigger on initial page load if category already selected
        if (categorySelect.value) {
            loadSubcategories(categorySelect.value);
        }

        // Indian State -> Cities Dynamic Loader
        const stateSelect = document.getElementById('state');
        const cityInput = document.getElementById('city');
        const citiesDatalist = document.getElementById('cities-list');

        function loadCitiesForState(stateName) {
            if (!stateName) return;
            fetch(`/api/locations/cities?state=${encodeURIComponent(stateName)}`)
                .then(response => response.json())
                .then(cities => {
                    citiesDatalist.innerHTML = '';
                    cities.forEach(cityName => {
                        const option = document.createElement('option');
                        option.value = cityName;
                        citiesDatalist.appendChild(option);
                    });
                })
                .catch(err => console.error('Error fetching cities:', err));
        }

        stateSelect.addEventListener('change', function () {
            loadCitiesForState(this.value);
            cityInput.value = '';
        });

        if (stateSelect.value) {
            loadCitiesForState(stateSelect.value);
        }
    });
</script>
@endpush
@endsection
