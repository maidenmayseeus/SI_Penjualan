<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use Hasfactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'stock',
        'is_popular',
        'category_id',
        'brand_id',
    ];
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Get the brand that owns the Produk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    /**
     * Get the category that owns the Produk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(category::class, 'category_id');
    }
    /**
     * Get all of the photos for the Produk
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(ProdukPhoto::class);
    }
    /**
     * Get all of the sizes for the Produk
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizes(): HasMany
    {
        return $this->hasMany(ProdukSize::class);
    }
}
