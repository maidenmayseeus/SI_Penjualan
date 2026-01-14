<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTransaction extends Model
{
    use Hasfactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'booking_trx_id',
        'city',
        'post_code',
        'address',
        'quantity',
        'sub_total_amount',
        'grand_total_amount',
        'discount_amount',
        'is_paid',
        'produk_id',
        'produk_size',
        'promo_code_id',
        'proof',

    ];
    public static function generateUniqueTrxId(): string 
    {
        $prefix = 'TJM';
        do {
            $randomString = $prefix . mt_rand(10001, 99999);
        } while (self::where('booking_trx_id', $randomString)->exists());
        return $randomString;
    }
    /**
     * Get the produk that owns the ProductTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    /**
     * Get the promoCode that owns the ProductTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }
}
