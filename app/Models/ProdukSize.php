<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukSize extends Model
{
    use Hasfactory, SoftDeletes;
    protected $fillable = [
        'size',
        'produk_id',
    ];
}
