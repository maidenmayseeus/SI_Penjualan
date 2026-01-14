<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukPhoto extends Model
{
    use Hasfactory, SoftDeletes;
    protected $fillable = [
        'photo',
        'produk_id',
    ];
}
