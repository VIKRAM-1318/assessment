# BuzzBazaar — OLX-Inspired Classifieds & Services Marketplace

> **Platform:** BuzzBazaar Online Marketplace  
> **Technology Stack:** PHP 8.3+, Laravel 11 (MVC), SQLite / MySQL, Tailwind CSS, FontAwesome 6, PHPUnit  
> **Coverage:** Pan-India (All 36 States & Union Territories, 300+ Cities — Zero External API Keys Required)  

---

## 1. Project Overview & Identity

**BuzzBazaar** is a full-featured, commercial-grade online classifieds and services marketplace inspired by the usability and speed of OLX.

BuzzBazaar introduces a modern amber-and-slate design system that allows users to discover, buy, sell, and hire both **physical products** (vehicles, smartphones, real estate, furniture) and **on-demand professional services** (web development, UI/UX design, performance marketing, tutoring) across all 36 States and Union Territories of India.

---

## 2. Core Marketplace Features Checklist

Every single marketplace requirement has been implemented with real database persistence and end-to-end automated tests:

| Requirement | Implementation Details | Status |
| :--- | :--- | :---: |
| **User Registration** | `GET /register`, `POST /register`, bcrypt password hashing, automatic login, session regeneration | ✅ Implemented |
| **User Login & Logout** | `GET /login`, `POST /login`, `POST /logout`, remember me token, CSRF protection | ✅ Implemented |
| **Product / Service Selection** | Radio toggle selector (`product` vs `service`) with dedicated badges throughout UI | ✅ Implemented |
| **10 Mandatory Listing Fields** | 1. Listing Type, 2. Name, 3. Detail, 4. Category, 5. Subcategory, 6. Country, 7. State, 8. City, 9. Area, 10. Price | ✅ Implemented |
| **Frontend Display** | Clean, responsive homepage with fresh recommendations, category cards, city pills, and metrics | ✅ Implemented |
| **Category Listing Pages** | `GET /category/{category:slug}` with subcategory pills and city-level quick filters | ✅ Implemented |
| **City-Wise Listing Pages** | `GET /city/{city}` displaying classifieds specific to a city (Bangalore, Mumbai, Delhi, etc.) | ✅ Implemented |
| **City + Category Pages** | `GET /city/{city}/category/{category:slug}` combining geographic and taxonomic filters | ✅ Implemented |
| **Individual Listing Pages** | `GET /listing/{id}` featuring image gallery, price, 10-field specs table, seller card, view counter, safety tips | ✅ Implemented |
| **Dynamic Subcategories** | AJAX endpoint `GET /api/categories/{id}/subcategories` for dynamic frontend dropdown | ✅ Implemented |
| **Owner Ad Management** | `GET /my-listings`, delete with authorization policy (`403 Forbidden` protection) | ✅ Implemented |
| **Automated Testing** | 23 automated tests (Feature + Unit), 81 assertions, zero failures (`php artisan test`) | ✅ Implemented |

---

## 3. Architecture & Database Design

### Database Models & Relationships
- **User** (`users` table):
  - `hasMany(Listing::class)`
- **Category** (`categories` table):
  - `hasMany(Subcategory::class)`
  - `hasMany(Listing::class)`
- **Subcategory** (`subcategories` table):
  - `belongsTo(Category::class)`
  - `hasMany(Listing::class)`
- **Listing** (`listings` table):
  - `belongsTo(User::class)`
  - `belongsTo(Category::class)`
  - `belongsTo(Subcategory::class)`
  - Scope: `scopeActive()`, `scopeFilter()`

### Listing Schema (All 10 Assignment Fields)
```sql
CREATE TABLE listings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    subcategory_id INTEGER NOT NULL REFERENCES subcategories(id) ON DELETE CASCADE,
    listing_type VARCHAR NOT NULL,     -- 1. Product / Service Selection
    name VARCHAR NOT NULL,             -- 2. Name
    detail TEXT NOT NULL,              -- 3. Detail
    country VARCHAR NOT NULL,          -- 4. Country
    state VARCHAR NOT NULL,            -- 5. State
    city VARCHAR NOT NULL,             -- 6. City (indexed)
    area VARCHAR NOT NULL,             -- 7. Area
    price NUMERIC(12, 2) NOT NULL,     -- 8. Price
    image_path VARCHAR NULL,
    status VARCHAR DEFAULT 'active',
    views INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 4. Quick Start & Setup Instructions

To run this application locally on any fresh development machine:

### Prerequisites
- PHP 8.2 or 8.3+ with `pdo_sqlite` (or `pdo_mysql`), `mbstring`, `fileinfo`, `curl` extensions enabled
- Composer 2.x

### Step-by-Step Setup
1. **Navigate to the Application directory:**
   ```bash
   cd Application
   ```

2. **Install Composer Dependencies:**
   ```bash
   composer install
   ```

3. **Environment Setup:**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Storage Link:**
   ```bash
   php artisan storage:link
   ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *This seeds 6 core categories, 24 subcategories, 3 test users, and 14 realistic product and service listings across Bangalore, Mumbai, New Delhi, Hyderabad, and Pune.*

6. **Start Local Development Server:**
   ```bash
   php artisan serve
   ```
   Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your web browser.

---

## 5. Pre-Seeded Demo Accounts

For immediate evaluation, the following accounts are pre-seeded in the database:

| Email | Password | Role / Purpose |
| :--- | :--- | :--- |
| `demo@buzzbazaar.com` | `Password@123` | **Primary Demo User** (Active listings in Vehicles, Services, Properties) |
| `sarah.smith@example.com` | `Password@123` | Secondary Seller (Electronics, UI/UX Services) |
| `rahul.verma@example.com` | `Password@123` | Secondary Seller (Motorcycles, Furniture, Marketing) |

*(Note: The login page includes a one-click demo credentials helper for rapid testing.)*

---

## 6. Running Automated Tests

To execute the complete PHPUnit test suite:
```bash
php artisan test
```

### Test Coverage Summary
- **Tests:** 23 passed
- **Assertions:** 81 assertions passed
- **Failures:** 0
- **Execution Time:** ~2.8 seconds
- **Test Suites:**
  - `tests/Feature/AuthTest.php` (Registration, Login, Validation, Logout, Guest protections)
  - `tests/Feature/ListingTest.php` (All 10 fields, Homepage, Category pages, City pages, City+Category pages, Search, Filters, dynamic AJAX subcategories, My Listings, Authorization checks)
  - `tests/Unit/ExampleTest.php`

---

## 7. Security & Engineering Standards

- **Authentication:** Laravel session guard with password hashing via Bcrypt.
- **CSRF Protection:** `@csrf` tokens enforced on all POST/PUT/DELETE forms.
- **Server-Side Validation:** All 10 mandatory fields strictly validated with custom messages and constraints.
- **Authorization:** Listing ownership verified before allowing destructive operations (`abort(403)` if unauthorized).
- **SQL Injection Prevention:** Eloquent ORM parameterized queries throughout.
- **XSS Prevention:** Blade `{{ ... }}` auto-escaping used across all dynamic template variables.

---

## 8. Project Folder Structure

```
Honeybee_Laravel_Marketplace/
│
├── Application/                 # Complete Laravel 11 application
│   ├── app/
│   │   ├── Http/Controllers/   # AuthController, ListingController
│   │   └── Models/             # User, Category, Subcategory, Listing
│   ├── database/
│   │   ├── migrations/         # Categories, Subcategories, Listings
│   │   └── seeders/            # DatabaseSeeder with 14 rich listings
│   ├── resources/views/        # Blade templates (Tailwind + FontAwesome)
│   ├── routes/web.php          # 19 registered & tested routes
│   └── tests/Feature/          # Automated test suite
│
├── Documentation/
│   └── README.md               # Master technical documentation
│
├── Testing/
│   └── Verification_Report.md  # Comprehensive test audit report
│
├── Screenshots/                # 12 high-resolution UI captures
│   ├── 01_Homepage_BuzzBazaar.png
│   ├── 02_Category_Page_Vehicles.png
│   ├── 03_Category_Page_Electronics.png
│   ├── 04_City_Wise_Listings_Bangalore.png
│   ├── 05_City_Wise_Listings_Mumbai.png
│   ├── 06_City_Category_Combined_Filter.png
│   ├── 07_Individual_Listing_Product_Detail.png
│   ├── 08_Individual_Listing_Service_Detail.png
│   ├── 09_Search_And_Price_Filters.png
│   ├── 10_User_Login_Screen.png
│   ├── 11_User_Registration_Screen.png
│   └── 12_Post_Ad_Form_10_Mandatory_Fields.png
│
└── Presentation/
    ├── Video_Demonstration_Script.md  # 3-minute video presentation script
    └── Submission_Email.md            # Ready-to-send submission letter
```
