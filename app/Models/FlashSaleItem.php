<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FlashSaleItem
 *
 * @property int $id
 * @property int $product_id
 * @property int $show_at_home
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem whereShowAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlashSaleItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FlashSaleItem extends Model
{
    use HasFactory;

    /**
     * Relationship: This model belongs to Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
