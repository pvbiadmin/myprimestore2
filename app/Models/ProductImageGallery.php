<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProductImageGallery
 *
 * @property int $id
 * @property string $image
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImageGallery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductImageGallery extends Model
{
    use HasFactory;

    /**
     * Relationship between this and Product Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
