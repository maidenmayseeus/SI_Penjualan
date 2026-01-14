<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
    use Hasfactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'logo',
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
