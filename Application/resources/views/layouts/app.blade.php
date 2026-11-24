<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BuzzBazaar - Buy & Sell Products & Services Across India')</title>
    <meta name="description" content="@yield('meta_description', 'India\'s fastest-growing OLX-inspired marketplace for verified products, vehicles, electronics, properties, and professional services.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        amber: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        navy: {
                            800: '#0f172a',
                            900: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased bg-slate-50">

    <!-- Top Announcement Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-1.5 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-slate-950 uppercase tracking-wide">
                    Verified Platform
                </span>
                <span>India's Premier Marketplace for Products & Professional Services</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-slate-400"><i class="fa-solid fa-shield-halved text-amber-400 mr-1"></i> 100% Safe Deals</span>
                <span class="hidden sm:inline text-slate-400"><i class="fa-solid fa-headset text-amber-400 mr-1"></i> 24/7 Verified Support</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo & Brand -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-amber-400 flex items-center justify-center text-slate-950 shadow-md group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-cube text-xl"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold tracking-tight text-slate-900">Buzz<span class="text-amber-500">Bazaar</span></span>
                            <span class="block text-[10px] font-semibold text-slate-400 tracking-wider uppercase -mt-1">Classifieds & Services</span>
                        </div>
                    </a>
                </div>

                <!-- Global Search & City Selector -->
                <div class="hidden md:flex flex-1 max-w-3xl items-center gap-2">
                    <!-- City Dropdown -->
                    <form action="{{ route('listings.index') }}" method="GET" class="flex flex-1 items-center bg-slate-100 rounded-xl border border-slate-200 focus-within:border-amber-500 focus-within:ring-2 focus-within:ring-amber-200 transition-all p-1">
                        
                        <div class="relative w-48 flex-shrink-0 border-r border-slate-300">
                            <i class="fa-solid fa-location-dot absolute left-3 top-3.5 text-amber-500"></i>
                            <select name="city" onchange="this.form.submit()" class="w-full pl-9 pr-7 py-2 bg-transparent text-sm font-semibold text-slate-700 focus:outline-none cursor-pointer appearance-none">
                                <option value="">All India</option>
                                <optgroup label="Top Metros">
                                    <option value="Bangalore" {{ request('city') == 'Bangalore' ? 'selected' : '' }}>Bangalore</option>
                                    <option value="Mumbai" {{ request('city') == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                                    <option value="New Delhi" {{ request('city') == 'New Delhi' ? 'selected' : '' }}>New Delhi</option>
                                    <option value="Hyderabad" {{ request('city') == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                                    <option value="Chennai" {{ request('city') == 'Chennai' ? 'selected' : '' }}>Chennai</option>
                                    <option value="Kolkata" {{ request('city') == 'Kolkata' ? 'selected' : '' }}>Kolkata</option>
                                    <option value="Pune" {{ request('city') == 'Pune' ? 'selected' : '' }}>Pune</option>
                                    <option value="Ahmedabad" {{ request('city') == 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                                </optgroup>
                                <optgroup label="North & West India">
                                    <option value="Jaipur" {{ request('city') == 'Jaipur' ? 'selected' : '' }}>Jaipur</option>
                                    <option value="Lucknow" {{ request('city') == 'Lucknow' ? 'selected' : '' }}>Lucknow</option>
                                    <option value="Chandigarh" {{ request('city') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                    <option value="Gurgaon" {{ request('city') == 'Gurgaon' ? 'selected' : '' }}>Gurgaon</option>
                                    <option value="Noida" {{ request('city') == 'Noida' ? 'selected' : '' }}>Noida</option>
                                    <option value="Surat" {{ request('city') == 'Surat' ? 'selected' : '' }}>Surat</option>
                                    <option value="Indore" {{ request('city') == 'Indore' ? 'selected' : '' }}>Indore</option>
                                </optgroup>
                                <optgroup label="South & East India">
                                    <option value="Kochi" {{ request('city') == 'Kochi' ? 'selected' : '' }}>Kochi</option>
                                    <option value="Coimbatore" {{ request('city') == 'Coimbatore' ? 'selected' : '' }}>Coimbatore</option>
                                    <option value="Visakhapatnam" {{ request('city') == 'Visakhapatnam' ? 'selected' : '' }}>Visakhapatnam</option>
                                    <option value="Patna" {{ request('city') == 'Patna' ? 'selected' : '' }}>Patna</option>
                                    <option value="Bhubaneswar" {{ request('city') == 'Bhubaneswar' ? 'selected' : '' }}>Bhubaneswar</option>
                                    <option value="Guwahati" {{ request('city') == 'Guwahati' ? 'selected' : '' }}>Guwahati</option>
                                </optgroup>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-xs text-slate-400 pointer-events-none"></i>
                        </div>

                        <!-- Keyword Input -->
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Find Cars, Mobile Phones, Services, Apartments..." class="w-full px-4 py-2 bg-transparent text-sm text-slate-800 placeholder-slate-400 focus:outline-none">
                        </div>

                        <!-- Listing Type Filter -->
                        <div class="hidden lg:block w-32 border-l border-slate-300 px-1">
                            <select name="listing_type" onchange="this.form.submit()" class="w-full py-2 bg-transparent text-xs font-medium text-slate-600 focus:outline-none cursor-pointer">
                                <option value="">All Types</option>
                                <option value="product" {{ request('listing_type') == 'product' ? 'selected' : '' }}>Products Only</option>
                                <option value="service" {{ request('listing_type') == 'service' ? 'selected' : '' }}>Services Only</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-sm font-semibold transition-colors duration-150 flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-magnifying-glass text-xs text-amber-400"></i>
                            <span>Search</span>
                        </button>
                    </form>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 py-1.5 px-3 rounded-lg hover:bg-slate-100 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center border border-amber-300">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:inline text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1 hidden group-hover:block hover:block z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs text-slate-400 font-medium">Signed in as</p>
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('listings.my') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-amber-50 hover:text-amber-700 font-medium">
                                    <i class="fa-solid fa-layer-group text-slate-400 text-xs"></i> My Listings
                                </a>
                                <a href="{{ route('listings.create') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-amber-50 hover:text-amber-700 font-medium">
                                    <i class="fa-solid fa-plus-circle text-slate-400 text-xs"></i> Post New Ad
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-medium">
                                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-amber-600 px-3 py-2 rounded-lg hover:bg-slate-100 transition-colors">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="hidden sm:inline text-sm font-semibold text-slate-600 hover:text-slate-900 px-3 py-2">
                            Register
                        </a>
                    @endauth

                    <!-- OLX Style Sell Button -->
                    <a href="{{ route('listings.create') }}" class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-extrabold text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-md hover:shadow-amber-500/25 transition-all duration-200 border-2 border-slate-900">
                        <i class="fa-solid fa-plus font-black"></i>
                        <span>POST AD</span>
                    </a>
                </div>

            </div>
        </div>

        <!-- Category Secondary Navigation Bar -->
        <nav class="bg-white border-t border-slate-100 shadow-inner overflow-x-auto scrollbar-none">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center space-x-6 py-2.5 text-sm whitespace-nowrap">
                    <a href="{{ route('listings.index') }}" class="font-bold text-slate-900 hover:text-amber-600 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-ul text-amber-500 text-xs"></i>
                        <span>All Categories</span>
                    </a>
                    
                    @php
                        $navCategories = \App\Models\Category::all();
                    @endphp
                    @foreach($navCategories as $cat)
                        <a href="{{ route('listings.category', $cat->slug) }}" class="text-slate-600 hover:text-amber-600 font-medium transition-colors">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm mb-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-lg"></i>
                    <p class="text-sm font-semibold text-rose-800">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl shadow-sm mb-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-info text-blue-500 text-lg"></i>
                    <p class="text-sm font-semibold text-blue-800">{{ session('info') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-400 hover:text-blue-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 pb-16">
        @yield('content')
    </main>

    <!-- Professional Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                
                <!-- Brand Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center text-slate-950 font-bold">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        <span class="text-xl font-extrabold text-white">Buzz<span class="text-amber-500">Bazaar</span></span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4 max-w-sm">
                        BuzzBazaar is India's modern online marketplace for buying, selling, and discovering verified local products, electronics, vehicles, real estate, and on-demand professional services.
                    </p>
                    <div class="flex items-center space-x-3 text-slate-400">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-amber-400 border border-slate-700">
                            <i class="fa-solid fa-shield-check"></i> 100% Verified Listings
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-emerald-400 border border-slate-700">
                            <i class="fa-solid fa-map-location-dot"></i> Pan-India Coverage
                        </span>
                    </div>
                </div>

                <!-- Popular Categories -->
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Popular Categories</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('listings.category', 'vehicles') }}" class="hover:text-amber-400 transition-colors">Vehicles & Cars</a></li>
                        <li><a href="{{ route('listings.category', 'electronics-appliances') }}" class="hover:text-amber-400 transition-colors">Electronics & Mobiles</a></li>
                        <li><a href="{{ route('listings.category', 'real-estate-properties') }}" class="hover:text-amber-400 transition-colors">Real Estate & Rentals</a></li>
                        <li><a href="{{ route('listings.category', 'jobs-professional-services') }}" class="hover:text-amber-400 transition-colors">Jobs & Services</a></li>
                        <li><a href="{{ route('listings.category', 'home-furniture') }}" class="hover:text-amber-400 transition-colors">Home & Furniture</a></li>
                    </ul>
                </div>

                <!-- Trending Locations -->
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Trending Locations</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('listings.city', 'Bangalore') }}" class="hover:text-amber-400 transition-colors">Bangalore Classifieds</a></li>
                        <li><a href="{{ route('listings.city', 'Mumbai') }}" class="hover:text-amber-400 transition-colors">Mumbai Classifieds</a></li>
                        <li><a href="{{ route('listings.city', 'New Delhi') }}" class="hover:text-amber-400 transition-colors">New Delhi Classifieds</a></li>
                        <li><a href="{{ route('listings.city', 'Hyderabad') }}" class="hover:text-amber-400 transition-colors">Hyderabad Classifieds</a></li>
                        <li><a href="{{ route('listings.city', 'Pune') }}" class="hover:text-amber-400 transition-colors">Pune Classifieds</a></li>
                    </ul>
                </div>

                <!-- Company & Trust -->
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Company & Safety</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="#" class="hover:text-amber-400 transition-colors">About BuzzBazaar</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Trust & Safety Guidelines</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Community Help Center</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-slate-800 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} BuzzBazaar Technologies Pvt. Ltd. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 sm:mt-0">
                    <span class="hover:text-slate-400 cursor-pointer">Security Policy</span>
                    <span class="hover:text-slate-400 cursor-pointer">Terms of Service</span>
                    <span class="hover:text-slate-400 cursor-pointer">Privacy Notice</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
