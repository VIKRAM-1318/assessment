<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;
    private Subcategory $subcategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'icon' => 'cpu-chip',
            'description' => 'Gadgets and appliances',
        ]);

        $this->subcategory = Subcategory::create([
            'category_id' => $this->category->id,
            'name' => 'Laptops',
            'slug' => 'laptops',
            'description' => 'Portable computers',
        ]);
    }

    public function test_homepage_loads_successfully_and_displays_listings(): void
    {
        $listing = Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'MacBook Air M2 Silver',
            'detail' => 'Brand new sealed box with Apple warranty and invoice included.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Koramangala',
            'price' => 85000.00,
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('BuzzBazaar');
        $response->assertSee('MacBook Air M2 Silver');
        $response->assertSee('Bangalore');
    }

    public function test_browse_listings_page_filters_by_search_and_type(): void
    {
        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'Dell XPS 15 4K Screen',
            'detail' => 'High performance laptop for gaming and development.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Whitefield',
            'price' => 120000.00,
            'status' => 'active',
        ]);

        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'service',
            'name' => 'Laptop Hardware Repair Service',
            'detail' => 'Chip-level motherboard repair service with doorstep pickup.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'HSR Layout',
            'price' => 1500.00,
            'status' => 'active',
        ]);

        // Search test
        $searchResponse = $this->get('/listings?search=Dell');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Dell XPS 15');
        $searchResponse->assertDontSee('Laptop Hardware Repair Service');

        // Type filter test (services only)
        $serviceResponse = $this->get('/listings?listing_type=service');
        $serviceResponse->assertStatus(200);
        $serviceResponse->assertSee('Laptop Hardware Repair Service');
        $serviceResponse->assertDontSee('Dell XPS 15');
    }

    public function test_category_page_displays_listings_for_specific_category(): void
    {
        $otherCategory = Category::create([
            'name' => 'Vehicles',
            'slug' => 'vehicles',
        ]);
        $otherSub = Subcategory::create([
            'category_id' => $otherCategory->id,
            'name' => 'Cars',
            'slug' => 'cars',
        ]);

        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'HP Envy x360 Laptop',
            'detail' => 'Touchscreen 2-in-1 laptop with pen stylus.',
            'country' => 'India',
            'state' => 'Maharashtra',
            'city' => 'Mumbai',
            'area' => 'Andheri',
            'price' => 65000.00,
            'status' => 'active',
        ]);

        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $otherCategory->id,
            'subcategory_id' => $otherSub->id,
            'listing_type' => 'product',
            'name' => 'Honda Civic Sedan 2020',
            'detail' => 'Automatic transmission with low mileage.',
            'country' => 'India',
            'state' => 'Maharashtra',
            'city' => 'Mumbai',
            'area' => 'Bandra',
            'price' => 950000.00,
            'status' => 'active',
        ]);

        $response = $this->get("/category/{$this->category->slug}");
        $response->assertStatus(200);
        $response->assertSee('HP Envy x360 Laptop');
        $response->assertDontSee('Honda Civic Sedan 2020');
    }

    public function test_city_page_displays_listings_for_specific_city(): void
    {
        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'Bangalore Laptop Sale',
            'detail' => 'Available for instant pickup in Bangalore.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Indiranagar',
            'price' => 45000.00,
            'status' => 'active',
        ]);

        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'Delhi Desktop Sale',
            'detail' => 'Available for instant pickup in Delhi.',
            'country' => 'India',
            'state' => 'Delhi',
            'city' => 'Delhi',
            'area' => 'Connaught Place',
            'price' => 35000.00,
            'status' => 'active',
        ]);

        $response = $this->get('/city/Bangalore');
        $response->assertStatus(200);
        $response->assertSee('Bangalore Laptop Sale');
        $response->assertDontSee('Delhi Desktop Sale');
    }

    public function test_city_and_category_page_displays_combined_filtered_listings(): void
    {
        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'Bangalore Electronics Unit',
            'detail' => 'Electronics located in Bangalore city.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Koramangala',
            'price' => 50000.00,
            'status' => 'active',
        ]);

        $otherCategory = Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
        ]);
        $otherSub = Subcategory::create([
            'category_id' => $otherCategory->id,
            'name' => 'Chairs',
            'slug' => 'chairs',
        ]);

        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $otherCategory->id,
            'subcategory_id' => $otherSub->id,
            'listing_type' => 'product',
            'name' => 'Bangalore Office Chair',
            'detail' => 'Comfortable office chair in Bangalore.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'HSR Layout',
            'price' => 7000.00,
            'status' => 'active',
        ]);

        $response = $this->get("/city/Bangalore/category/{$this->category->slug}");
        $response->assertStatus(200);
        $response->assertSee('Bangalore Electronics Unit');
        $response->assertDontSee('Bangalore Office Chair');
    }

    public function test_individual_listing_page_renders_and_increments_views(): void
    {
        $listing = Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'ThinkPad Carbon X1 Gen 11',
            'detail' => 'Ultra lightweight carbon fiber business laptop with OLED display and fingerprint reader.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Domlur',
            'price' => 140000.00,
            'views' => 10,
            'status' => 'active',
        ]);

        $response = $this->get("/listing/{$listing->id}");
        $response->assertStatus(200);
        $response->assertSee('ThinkPad Carbon X1 Gen 11');
        $response->assertSee('Domlur');
        $response->assertSee('140,000');

        $this->assertEquals(11, $listing->fresh()->views);
    }

    public function test_dynamic_subcategories_api_returns_json(): void
    {
        $response = $this->getJson("/api/categories/{$this->category->id}/subcategories");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $this->subcategory->id,
            'name' => 'Laptops',
            'slug' => 'laptops',
        ]);
    }

    public function test_authenticated_user_can_create_listing_with_all_10_mandatory_fields(): void
    {
        $payload = [
            'listing_type' => 'service',
            'name' => 'Custom Laravel Web Application Development',
            'detail' => 'Full cycle Laravel engineering including REST APIs, unit tests, database migrations and deployment.',
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Indiranagar 100ft Rd',
            'price' => 30000.00,
        ];

        $response = $this->actingAs($this->user)->post('/listings', $payload);

        $this->assertDatabaseHas('listings', [
            'name' => 'Custom Laravel Web Application Development',
            'listing_type' => 'service',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Indiranagar 100ft Rd',
            'price' => 30000.00,
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
        ]);

        $listing = Listing::where('name', 'Custom Laravel Web Application Development')->first();
        $response->assertRedirect(route('listings.show', $listing));
    }

    public function test_listing_creation_fails_when_mandatory_fields_are_missing(): void
    {
        $response = $this->actingAs($this->user)->post('/listings', [
            'name' => '', // missing
            'price' => '', // missing
            'city' => '', // missing
        ]);

        $response->assertSessionHasErrors([
            'listing_type',
            'name',
            'detail',
            'category_id',
            'subcategory_id',
            'country',
            'state',
            'city',
            'area',
            'price',
        ]);
    }

    public function test_user_can_view_my_listings(): void
    {
        Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'My Exclusive Listing',
            'detail' => 'Testing my listings dashboard view.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'MG Road',
            'price' => 19999.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->get('/my-listings');
        $response->assertStatus(200);
        $response->assertSee('My Exclusive Listing');
    }

    public function test_user_can_delete_own_listing(): void
    {
        $listing = Listing::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'Listing To Be Deleted',
            'detail' => 'Will be deleted in automated test.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'BTM Layout',
            'price' => 5000.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->delete("/listings/{$listing->id}");

        $response->assertRedirect(route('listings.my'));
        $this->assertDatabaseMissing('listings', ['id' => $listing->id]);
    }

    public function test_user_cannot_delete_another_users_listing(): void
    {
        $anotherUser = User::factory()->create();

        $listing = Listing::create([
            'user_id' => $anotherUser->id,
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'listing_type' => 'product',
            'name' => 'Another User Listing',
            'detail' => 'Should not be deletable by current user.',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bangalore',
            'area' => 'Jayanagar',
            'price' => 9999.00,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->delete("/listings/{$listing->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('listings', ['id' => $listing->id]);
    }
}
