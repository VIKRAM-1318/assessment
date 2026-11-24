<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'listing_type',
        'name',
        'detail',
        'country',
        'state',
        'city',
        'area',
        'price',
        'image_path',
        'status',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'views' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('detail', 'like', "%{$search}%")
                      ->orWhere('area', 'like', "%{$search}%");
                });
            })
            ->when($filters['listing_type'] ?? null, function ($query, $type) {
                if ($type !== 'all' && !empty($type)) {
                    $query->where('listing_type', $type);
                }
            })
            ->when($filters['category_id'] ?? null, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($filters['subcategory_id'] ?? null, function ($query, $subcategoryId) {
                $query->where('subcategory_id', $subcategoryId);
            })
            ->when($filters['city'] ?? null, function ($query, $city) {
                if (!empty($city) && $city !== 'All Cities') {
                    $query->where('city', 'like', "%{$city}%");
                }
            })
            ->when($filters['min_price'] ?? null, function ($query, $minPrice) {
                $query->where('price', '>=', (float) $minPrice);
            })
            ->when($filters['max_price'] ?? null, function ($query, $maxPrice) {
                $query->where('price', '<=', (float) $maxPrice);
            })
            ->when($filters['sort'] ?? 'latest', function ($query, $sort) {
                match ($sort) {
                    'price_low' => $query->orderBy('price', 'asc'),
                    'price_high' => $query->orderBy('price', 'desc'),
                    'popular' => $query->orderBy('views', 'desc'),
                    default => $query->latest(),
                };
            });
    }
}
