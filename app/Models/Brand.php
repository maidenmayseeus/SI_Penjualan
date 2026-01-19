<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];
    public function setNameAttribute($value):void
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
 /**
  * Get all of the produks for the Brand
  *
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  */
 public function produks(): HasMany
 {
     return $this->hasMany(Produk::class);
 }

}
