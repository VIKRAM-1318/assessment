<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Demo Users
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@buzzbazaar.com'],
            [
                'name' => 'Arjun Sharma',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
            ]
        );

        $sarah = User::firstOrCreate(
            ['email' => 'sarah.smith@example.com'],
            [
                'name' => 'Sarah Smith',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
            ]
        );

        $rahul = User::firstOrCreate(
            ['email' => 'rahul.verma@example.com'],
            [
                'name' => 'Rahul Verma',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Categories and Subcategories
        $categoriesData = [
            [
                'name' => 'Vehicles',
                'slug' => 'vehicles',
                'icon' => 'car',
                'description' => 'Cars, motorcycles, commercial vehicles, and auto accessories',
                'subcategories' => [
                    ['name' => 'Cars & Sedans', 'slug' => 'cars-sedans'],
                    ['name' => 'Motorcycles & Scooters', 'slug' => 'motorcycles-scooters'],
                    ['name' => 'Commercial Vehicles', 'slug' => 'commercial-vehicles'],
                    ['name' => 'Spare Parts & Accessories', 'slug' => 'spare-parts-accessories'],
                ],
            ],
            [
                'name' => 'Electronics & Appliances',
                'slug' => 'electronics-appliances',
                'icon' => 'cpu-chip',
                'description' => 'Phones, computers, televisions, and household electronics',
                'subcategories' => [
                    ['name' => 'Smartphones & Tablets', 'slug' => 'smartphones-tablets'],
                    ['name' => 'Laptops & Computers', 'slug' => 'laptops-computers'],
                    ['name' => 'TVs, Audio & Video', 'slug' => 'tvs-audio-video'],
                    ['name' => 'Kitchen & Home Appliances', 'slug' => 'kitchen-home-appliances'],
                ],
            ],
            [
                'name' => 'Real Estate & Properties',
                'slug' => 'real-estate-properties',
                'icon' => 'home',
                'description' => 'Residential, commercial properties, rentals, and land',
                'subcategories' => [
                    ['name' => 'Apartments for Rent', 'slug' => 'apartments-for-rent'],
                    ['name' => 'Houses & Villas for Sale', 'slug' => 'houses-villas-for-sale'],
                    ['name' => 'Commercial Shops & Offices', 'slug' => 'commercial-shops-offices'],
                    ['name' => 'PG & Guest Houses', 'slug' => 'pg-guest-houses'],
                ],
            ],
            [
                'name' => 'Jobs & Professional Services',
                'slug' => 'jobs-professional-services',
                'icon' => 'briefcase',
                'description' => 'Web development, marketing, graphic design, and consulting',
                'subcategories' => [
                    ['name' => 'Web & App Development', 'slug' => 'web-app-development'],
                    ['name' => 'Digital Marketing & SEO', 'slug' => 'digital-marketing-seo'],
                    ['name' => 'Graphic & UI/UX Design', 'slug' => 'graphic-ui-ux-design'],
                    ['name' => 'Accounting & Legal Advisory', 'slug' => 'accounting-legal-advisory'],
                ],
            ],
            [
                'name' => 'Home & Furniture',
                'slug' => 'home-furniture',
                'icon' => 'building-storefront',
                'description' => 'Sofa sets, dining tables, beds, and home interior decor',
                'subcategories' => [
                    ['name' => 'Living Room & Sofas', 'slug' => 'living-room-sofas'],
                    ['name' => 'Beds & Wardrobes', 'slug' => 'beds-wardrobes'],
                    ['name' => 'Office Desks & Chairs', 'slug' => 'office-desks-chairs'],
                    ['name' => 'Home Decor & Lighting', 'slug' => 'home-decor-lighting'],
                ],
            ],
            [
                'name' => 'Education & Classes',
                'slug' => 'education-classes',
                'icon' => 'academic-cap',
                'description' => 'Academic coaching, language classes, music, and skills training',
                'subcategories' => [
                    ['name' => 'Coding & Tech Bootcamps', 'slug' => 'coding-tech-bootcamps'],
                    ['name' => 'Language & Soft Skills', 'slug' => 'language-soft-skills'],
                    ['name' => 'School & College Tuition', 'slug' => 'school-college-tuition'],
                    ['name' => 'Music & Arts Training', 'slug' => 'music-arts-training'],
                ],
            ],
        ];

        $categoryMap = [];
        $subcategoryMap = [];

        foreach ($categoriesData as $cData) {
            $category = Category::firstOrCreate(
                ['slug' => $cData['slug']],
                [
                    'name' => $cData['name'],
                    'icon' => $cData['icon'],
                    'description' => $cData['description'],
                ]
            );
            $categoryMap[$category->slug] = $category;

            foreach ($cData['subcategories'] as $sData) {
                $sub = Subcategory::firstOrCreate(
                    ['category_id' => $category->id, 'slug' => $sData['slug']],
                    [
                        'name' => $sData['name'],
                        'description' => "Browse high quality listings in {$sData['name']}",
                    ]
                );
                $subcategoryMap[$sData['slug']] = $sub;
            }
        }

        // 3. Rich Sample Listings (Products & Services with all 10 required fields)
        $sampleListings = [
            // Vehicles - Products
            [
                'user_id' => $demoUser->id,
                'category_slug' => 'vehicles',
                'subcategory_slug' => 'cars-sedans',
                'listing_type' => 'product',
                'name' => 'Honda City ZX 2022 Automatic - Single Owner Pristine Condition',
                'detail' => 'Top model Honda City ZX CVT with sunroof, ADAS sensing package, leather upholstery, only 18,500 kms driven. Full authorized service history available, comprehensive insurance valid till December 2027. Test drive available in Indiranagar.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bangalore',
                'area' => 'Indiranagar 100ft Road',
                'price' => 1250000.00,
                'image_path' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80',
                'views' => 142,
            ],
            [
                'user_id' => $rahul->id,
                'category_slug' => 'vehicles',
                'subcategory_slug' => 'motorcycles-scooters',
                'listing_type' => 'product',
                'name' => 'Royal Enfield Meteor 350 Supernova Edition',
                'detail' => 'Royal Enfield Meteor 350 dual-tone blue color, 2023 model, Tripper navigation system installed, touring windscreen, leg guard and backrest included. Maintained immaculately with showroom services.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Bandra West',
                'price' => 185000.00,
                'image_path' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?auto=format&fit=crop&w=800&q=80',
                'views' => 98,
            ],

            // Electronics & Appliances - Products
            [
                'user_id' => $sarah->id,
                'category_slug' => 'electronics-appliances',
                'subcategory_slug' => 'laptops-computers',
                'listing_type' => 'product',
                'name' => 'Apple MacBook Pro 16-inch M3 Pro (18GB RAM, 512GB SSD)',
                'detail' => 'Space Black MacBook Pro 16-inch with Apple Silicon M3 Pro, 100% battery health with only 24 charge cycles. Box, original 140W MagSafe charger, and AppleCare+ warranty coverage included.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bangalore',
                'area' => 'Koramangala 4th Block',
                'price' => 185000.00,
                'image_path' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80',
                'views' => 310,
            ],
            [
                'user_id' => $demoUser->id,
                'category_slug' => 'electronics-appliances',
                'subcategory_slug' => 'smartphones-tablets',
                'listing_type' => 'product',
                'name' => 'Samsung Galaxy S24 Ultra 5G (Titanium Gray, 256GB)',
                'detail' => 'Flagship Samsung Galaxy S24 Ultra with S-Pen, 200MP camera, Snapdragon 8 Gen 3 for Galaxy, titanium frame, scratchless screen with tempered glass applied on day one. Comes with invoice and original box.',
                'country' => 'India',
                'state' => 'Telangana',
                'city' => 'Hyderabad',
                'area' => 'Hitec City, Madhapur',
                'price' => 92000.00,
                'image_path' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&w=800&q=80',
                'views' => 225,
            ],
            [
                'user_id' => $rahul->id,
                'category_slug' => 'electronics-appliances',
                'subcategory_slug' => 'tvs-audio-video',
                'listing_type' => 'product',
                'name' => 'Sony Bravia 55-inch 4K Ultra HD Smart OLED TV (XR-55A80L)',
                'detail' => 'Stunning Sony Cognitive Processor XR OLED TV with Dolby Vision, Dolby Atmos Acoustic Surface Audio+, Google TV interface with voice remote. Wall mount bracket included. Selling due to relocation.',
                'country' => 'India',
                'state' => 'Delhi',
                'city' => 'New Delhi',
                'area' => 'Connaught Place',
                'price' => 110000.00,
                'image_path' => 'https://images.unsplash.com/photo-1593784991095-a205069470b6?auto=format&fit=crop&w=800&q=80',
                'views' => 167,
            ],

            // Real Estate & Properties - Products
            [
                'user_id' => $sarah->id,
                'category_slug' => 'real-estate-properties',
                'subcategory_slug' => 'apartments-for-rent',
                'listing_type' => 'product',
                'name' => 'Luxury 3 BHK Fully Furnished High-Rise Apartment in Whitefield',
                'detail' => 'Spacious 1850 sq ft 3 BHK apartment in gated luxury community with club house, swimming pool, tennis court, 2 car parking slots, modular Italian kitchen, premium wooden flooring, 24/7 security & power backup.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bangalore',
                'area' => 'Whitefield ITPL Main Road',
                'price' => 58000.00,
                'image_path' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80',
                'views' => 450,
            ],
            [
                'user_id' => $demoUser->id,
                'category_slug' => 'real-estate-properties',
                'subcategory_slug' => 'commercial-shops-offices',
                'listing_type' => 'product',
                'name' => 'Prime Commercial Office Space 2400 sq.ft near Metro Station',
                'detail' => 'Plug-and-play modern office setup with 35 workstations, 2 executive cabins, conference room with 65-inch screen, cafeteria, dedicated server rack room, high-speed fiber internet and central air conditioning.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Andheri East, MIDC',
                'price' => 175000.00,
                'image_path' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                'views' => 189,
            ],

            // Jobs & Professional Services - SERVICES
            [
                'user_id' => $demoUser->id,
                'category_slug' => 'jobs-professional-services',
                'subcategory_slug' => 'web-app-development',
                'listing_type' => 'service',
                'name' => 'Enterprise Full-Stack Laravel & Vue.js Web Development Services',
                'detail' => 'Senior engineering service for customized web portals, SaaS platforms, API development, marketplace architectures, and cloud deployments. Proven track record delivering high-throughput systems on AWS/DigitalOcean with automated testing.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bangalore',
                'area' => 'HSR Layout Sector 1',
                'price' => 35000.00,
                'image_path' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80',
                'views' => 530,
            ],
            [
                'user_id' => $sarah->id,
                'category_slug' => 'jobs-professional-services',
                'subcategory_slug' => 'graphic-ui-ux-design',
                'listing_type' => 'service',
                'name' => 'Figma UI/UX Product Design & Mobile App Prototyping Service',
                'detail' => 'Complete UI/UX design workflow from wireframes to high-fidelity clickable Figma prototypes, comprehensive design system tokens, responsive web layouts, and developer handoff documentation for startups and enterprises.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Lower Parel Business Hub',
                'price' => 25000.00,
                'image_path' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=800&q=80',
                'views' => 312,
            ],
            [
                'user_id' => $rahul->id,
                'category_slug' => 'jobs-professional-services',
                'subcategory_slug' => 'digital-marketing-seo',
                'listing_type' => 'service',
                'name' => 'Results-Driven Performance Marketing & Google Ads Growth Service',
                'detail' => 'Dedicated digital marketing consultancy: Google Ads SEM, Meta PPC campaigns, conversion rate optimization (CRO), on-page & technical SEO audits with guaranteed ranking improvements and verified ROI dashboards.',
                'country' => 'India',
                'state' => 'Delhi',
                'city' => 'New Delhi',
                'area' => 'Saket District Centre',
                'price' => 20000.00,
                'image_path' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'views' => 195,
            ],

            // Home & Furniture - Products
            [
                'user_id' => $sarah->id,
                'category_slug' => 'home-furniture',
                'subcategory_slug' => 'office-desks-chairs',
                'listing_type' => 'product',
                'name' => 'Ergonomic Mesh High-Back Executive Office Chair with Lumbar Support',
                'detail' => 'Heavy-duty ergonomic office chair with breathable Korean mesh back, multi-directional 3D armrests, synchro-tilt mechanism, Class-4 gas lift, and silent PU nylon casters. Barely 6 months old in mint condition.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bangalore',
                'area' => 'Electronic City Phase 1',
                'price' => 8500.00,
                'image_path' => 'https://images.unsplash.com/photo-1580481077195-c990b798782a?auto=format&fit=crop&w=800&q=80',
                'views' => 140,
            ],
            [
                'user_id' => $rahul->id,
                'category_slug' => 'home-furniture',
                'subcategory_slug' => 'living-room-sofas',
                'listing_type' => 'product',
                'name' => 'Modern 6-Seater L-Shape Fabric Sectional Sofa Set with Lounger',
                'detail' => 'Teak wood inner frame with premium beige water-repellent fabric upholstery, high-density 40D foam cushioning, movable ottoman, and 4 matching throw pillows. Purchased from Urban Ladder.',
                'country' => 'India',
                'state' => 'Telangana',
                'city' => 'Hyderabad',
                'area' => 'Jubilee Hills Checkpost',
                'price' => 32000.00,
                'image_path' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&q=80',
                'views' => 280,
            ],

            // Education & Classes - SERVICES
            [
                'user_id' => $demoUser->id,
                'category_slug' => 'education-classes',
                'subcategory_slug' => 'coding-tech-bootcamps',
                'listing_type' => 'service',
                'name' => '1-on-1 Full Stack Web Development & PHP/Laravel Mentorship Program',
                'detail' => 'Hands-on 8-week mentoring covering real-world Laravel 11, Eloquent ORM, REST API design, TDD automated testing, Docker containers, database optimization, and portfolio project guidance for aspiring software engineers.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bangalore',
                'area' => 'BTM Layout 2nd Stage',
                'price' => 15000.00,
                'image_path' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80',
                'views' => 415,
            ],
            [
                'user_id' => $sarah->id,
                'category_slug' => 'education-classes',
                'subcategory_slug' => 'language-soft-skills',
                'listing_type' => 'service',
                'name' => 'Professional Business English & Corporate Communication Coaching',
                'detail' => 'Certified trainer offering customized sessions for working professionals: presentation mastery, executive email writing, interview preparation, and accent neutrality. Flexible weekend batches available.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Powai, Hiranandani',
                'price' => 7500.00,
                'image_path' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80',
                'views' => 180,
            ],
        ];

        foreach ($sampleListings as $listing) {
            $cat = $categoryMap[$listing['category_slug']];
            $sub = $subcategoryMap[$listing['subcategory_slug']];

            Listing::firstOrCreate(
                [
                    'name' => $listing['name'],
                    'city' => $listing['city'],
                ],
                [
                    'user_id' => $listing['user_id'],
                    'category_id' => $cat->id,
                    'subcategory_id' => $sub->id,
                    'listing_type' => $listing['listing_type'],
                    'name' => $listing['name'],
                    'detail' => $listing['detail'],
                    'country' => $listing['country'],
                    'state' => $listing['state'],
                    'city' => $listing['city'],
                    'area' => $listing['area'],
                    'price' => $listing['price'],
                    'image_path' => $listing['image_path'],
                    'status' => 'active',
                    'views' => $listing['views'],
                ]
            );
        }
    }
}
