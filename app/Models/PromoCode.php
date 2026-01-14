<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use Hasfactory, SoftDeletes;
    protected $fillable = [
        'code',
        'discount_amount',
    ];
}
