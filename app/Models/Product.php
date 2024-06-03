<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $thumb_image
 * @property int $vendor_id
 * @property int $category_id
 * @property int|null $subcategory_id
 * @property int|null $child_category_id
 * @property int $brand_id
 * @property int $product_type_id
 * @property int $quantity
 * @property string $short_description
 * @property string|null $long_description
 * @property string|null $video_link
 * @property string|null $sku
 * @property float $price
 * @property float|null $offer_price
 * @property string|null $offer_start_date
 * @property string|null $offer_end_date
 * @property string|null $product_type
 * @property float $points
 * @property int $status
 * @property int $is_approved
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Brand|null $brand
 * @property-read Category|null $category
 * @property-read Collection<int, ProductImageGallery> $imageGallery
 * @property-read int|null $image_gallery_count
 * @property-read Collection<int, ProductReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read Collection<int, ProductVariant> $variants
 * @property-read int|null $variants_count
 * @property-read Vendor|null $vendor
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereChildCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsApproved($value)
 * @method static Builder|Product whereLongDescription($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereOfferEndDate($value)
 * @method static Builder|Product whereOfferPrice($value)
 * @method static Builder|Product whereOfferStartDate($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product wherePoints($value)
 * @method static Builder|Product whereProductType($value)
 * @method static Builder|Product whereProductTypeId($value)
 * @method static Builder|Product whereQuantity($value)
 * @method static Builder|Product whereSeoDescription($value)
 * @method static Builder|Product whereSeoTitle($value)
 * @method static Builder|Product whereShortDescription($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereStatus($value)
 * @method static Builder|Product whereSubcategoryId($value)
 * @method static Builder|Product whereThumbImage($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereVendorId($value)
 * @method static Builder|Product whereVideoLink($value)
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'thumb_image', 'vendor_id', 'category_id',
        'subcategory_id', 'child_category_id', 'brand_id', 'product_type_id', 'quantity',
        'short_description', 'long_description', 'video_link', 'sku',
        'price', 'offer_price', 'offer_start_date', 'offer_end_date',
        'product_type', 'points', 'status', 'is_approved', 'seo_title', 'seo_description'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($product) {
            $product->sku = self::generateSKU($product);
        });
    }

    public static function generateSKU($product): string
    {
        // Fetch category and brand codes
        $categoryCode = self::getCategoryCode($product->category_id);
        $brandCode = self::getBrandCode($product->brand_id);
        $uniqueId = Str::upper(Str::random(6));

        return $categoryCode . '-' . $brandCode . '-' . $uniqueId;
    }

    public static function getCategoryCode($categoryId): string
    {
        $category = Category::find($categoryId); // Assuming Category model exists
        return $category ? Str::upper(Str::substr($category->name, 0, 3)) : 'GEN';
    }

    public static function getBrandCode($brandId): string
    {
        $brand = Brand::find($brandId); // Assuming Brand model exists
        return $brand ? Str::upper(Str::substr($brand->name, 0, 3)) : 'GEN';
    }

    /**
     * Relationship: This Model Belongs to Vendor
     *
     * @return BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Relationship: This Model Belongs to Category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: This Model Belongs to Brand
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Relationship: This Model Belongs to ProductType
     *
     * @return BelongsTo
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Relationship: This Model has Many ProductImageGallery
     *
     * @return HasMany
     */
    public function imageGallery(): HasMany
    {
        return $this->hasMany(ProductImageGallery::class);
    }

    /**
     * Relationship: This Model Has Many ProductVariant
     *
     * @return HasMany
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Relationship: This Model has many ProductReview
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }
}
