<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProductVariantOption
 *
 * @property int $id
 * @property int $product_variant_id
 * @property string $name
 * @property float $price
 * @property int $is_default
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductVariant|null $productVariant
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption whereProductVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariantOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductVariantOption extends Model
{
    use HasFactory;

    /**
     * Relationship: Product Variant Option belongs to Product Variant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
