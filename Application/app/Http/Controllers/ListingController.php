<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ListingController extends Controller
{
    /**
     * Homepage with hero, categories, cities, and latest products & services
     */
    public function home(Request $request): View
    {
        $categories = Category::withCount('listings')->get();
        
        $featuredCities = Listing::active()
            ->select('city')
            ->distinct()
            ->pluck('city');

        $latestListings = Listing::active()
            ->with(['category', 'subcategory', 'user'])
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Listing::active()
            ->where('listing_type', 'product')
            ->with(['category', 'subcategory'])
            ->latest()
            ->take(6)
            ->get();

        $latestServices = Listing::active()
            ->where('listing_type', 'service')
            ->with(['category', 'subcategory'])
            ->latest()
            ->take(6)
            ->get();

        $totalListings = Listing::active()->count();
        $totalProducts = Listing::active()->where('listing_type', 'product')->count();
        $totalServices = Listing::active()->where('listing_type', 'service')->count();

        return view('pages.home', compact(
            'categories',
            'featuredCities',
            'latestListings',
            'latestProducts',
            'latestServices',
            'totalListings',
            'totalProducts',
            'totalServices'
        ));
    }

    /**
     * Search and Browse all listings with filtering
     */
    public function index(Request $request): View
    {
        $categories = Category::with('subcategories')->get();
        $cities = Listing::active()->select('city')->distinct()->pluck('city');

        $filters = [
            'search' => $request->input('search'),
            'listing_type' => $request->input('listing_type'),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'city' => $request->input('city'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'sort' => $request->input('sort', 'latest'),
        ];

        $listings = Listing::active()
            ->with(['category', 'subcategory', 'user'])
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        return view('pages.listings.index', compact('listings', 'categories', 'cities', 'filters'));
    }

    /**
     * Category-specific listings page: /category/{slug}
     */
    public function category(Category $category, Request $request): View
    {
        $category->load('subcategories');
        $cities = Listing::active()->where('category_id', $category->id)->select('city')->distinct()->pluck('city');

        $filters = [
            'search' => $request->input('search'),
            'listing_type' => $request->input('listing_type'),
            'category_id' => $category->id,
            'subcategory_id' => $request->input('subcategory_id'),
            'city' => $request->input('city'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'sort' => $request->input('sort', 'latest'),
        ];

        $listings = Listing::active()
            ->with(['subcategory', 'user'])
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        return view('pages.listings.category', compact('category', 'listings', 'cities', 'filters'));
    }

    /**
     * City-wise listings page: /city/{city}
     */
    public function city(string $city, Request $request): View
    {
        $categories = Category::all();
        $cleanCity = urldecode($city);

        $filters = [
            'search' => $request->input('search'),
            'listing_type' => $request->input('listing_type'),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'city' => $cleanCity,
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'sort' => $request->input('sort', 'latest'),
        ];

        $listings = Listing::active()
            ->with(['category', 'subcategory', 'user'])
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        return view('pages.listings.city', compact('cleanCity', 'listings', 'categories', 'filters'));
    }

    /**
     * City + Category combined listings page: /city/{city}/category/{category:slug}
     */
    public function cityCategory(string $city, Category $category, Request $request): View
    {
        $cleanCity = urldecode($city);
        $category->load('subcategories');

        $filters = [
            'search' => $request->input('search'),
            'listing_type' => $request->input('listing_type'),
            'category_id' => $category->id,
            'subcategory_id' => $request->input('subcategory_id'),
            'city' => $cleanCity,
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'sort' => $request->input('sort', 'latest'),
        ];

        $listings = Listing::active()
            ->with(['category', 'subcategory', 'user'])
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        return view('pages.listings.city_category', compact('cleanCity', 'category', 'listings', 'filters'));
    }

    /**
     * Individual listing detail page: /listing/{id}
     */
    public function show(Listing $listing): View
    {
        if ($listing->status !== 'active' && (!Auth::check() || Auth::id() !== $listing->user_id)) {
            abort(404);
        }

        // Increment views safely
        $listing->increment('views');
        $listing->load(['category', 'subcategory', 'user']);

        $relatedListings = Listing::active()
            ->where('category_id', $listing->category_id)
            ->where('id', '!=', $listing->id)
            ->with(['category', 'subcategory'])
            ->take(4)
            ->get();

        return view('pages.listings.show', compact('listing', 'relatedListings'));
    }

    /**
     * Form to create a new product/service listing (auth protected)
     */
    public function create(): View
    {
        $categories = Category::with('subcategories')->get();
        $indianStates = config('india_locations.states', []);
        return view('pages.listings.create', compact('categories', 'indianStates'));
    }

    /**
     * Store new listing (all 10 mandatory fields validated & saved)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'listing_type' => ['required', 'in:product,service'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'detail' => ['required', 'string', 'min:10', 'max:5000'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'country' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'area' => ['required', 'string', 'max:150'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999999.99'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'url', 'max:500'],
        ]);

        // Check that subcategory belongs to category
        $subcategory = Subcategory::where('id', $validated['subcategory_id'])
            ->where('category_id', $validated['category_id'])
            ->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('listings', 'public');
            $imagePath = '/storage/' . $imagePath;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        } else {
            // High quality fallback themed image
            $imagePath = $validated['listing_type'] === 'service'
                ? 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80'
                : 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=800&q=80';
        }

        $listing = Listing::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'listing_type' => $validated['listing_type'],
            'name' => $validated['name'],
            'detail' => $validated['detail'],
            'country' => $validated['country'],
            'state' => $validated['state'],
            'city' => $validated['city'],
            'area' => $validated['area'],
            'price' => $validated['price'],
            'image_path' => $imagePath,
            'status' => 'active',
            'views' => 0,
        ]);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Your listing has been published successfully and is now live!');
    }

    /**
     * User's own listings dashboard
     */
    public function myListings(): View
    {
        $listings = Listing::where('user_id', Auth::id())
            ->with(['category', 'subcategory'])
            ->latest()
            ->paginate(10);

        return view('pages.listings.my_listings', compact('listings'));
    }

    /**
     * Delete own listing
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $listing->delete();

        return redirect()->route('listings.my')->with('success', 'Listing removed successfully.');
    }

    /**
     * AJAX endpoint to return subcategories for a category
     */
    public function getSubcategories(Category $category): JsonResponse
    {
        return response()->json($category->subcategories()->select('id', 'name', 'slug')->get());
    }

    /**
     * AJAX endpoint to return all Indian states
     */
    public function getStates(): JsonResponse
    {
        $states = array_keys(config('india_locations.states', []));
        return response()->json($states);
    }

    /**
     * AJAX endpoint to return cities for a given Indian state
     */
    public function getCities(Request $request): JsonResponse
    {
        $state = $request->query('state');
        $all = config('india_locations.states', []);

        if ($state && isset($all[$state])) {
            return response()->json($all[$state]);
        }

        $allCities = [];
        foreach ($all as $cities) {
            $allCities = array_merge($allCities, $cities);
        }
        sort($allCities);
        return response()->json(array_values(array_unique($allCities)));
    }
}
