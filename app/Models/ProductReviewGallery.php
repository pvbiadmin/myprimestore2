<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductReviewGallery
 *
 * @property int $id
 * @property int $product_review_id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery whereProductReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewGallery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductReviewGallery extends Model
{
    use HasFactory;
}
