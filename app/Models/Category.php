<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use Hasfactory, softDeletes;
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];
    /**
     * Get all of the produks for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
