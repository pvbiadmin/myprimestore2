<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $vendor_id
 * @property string $product_name
 * @property string $product_variant
 * @property float|null $product_variant_price_total
 * @property float $unit_price
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Order|null $order
 * @property-read Product|null $product
 * @property-read Vendor|null $vendor
 * @method static Builder|OrderProduct newModelQuery()
 * @method static Builder|OrderProduct newQuery()
 * @method static Builder|OrderProduct query()
 * @method static Builder|OrderProduct whereCreatedAt($value)
 * @method static Builder|OrderProduct whereId($value)
 * @method static Builder|OrderProduct whereOrderId($value)
 * @method static Builder|OrderProduct whereProductId($value)
 * @method static Builder|OrderProduct whereProductName($value)
 * @method static Builder|OrderProduct whereProductVariant($value)
 * @method static Builder|OrderProduct whereProductVariantPriceTotal($value)
 * @method static Builder|OrderProduct whereQuantity($value)
 * @method static Builder|OrderProduct whereUnitPrice($value)
 * @method static Builder|OrderProduct whereUpdatedAt($value)
 * @method static Builder|OrderProduct whereVendorId($value)
 * @mixin Eloquent
 */
class OrderProduct extends Model
{
    use HasFactory;

    /**
     * This Product Order Belongs to Vendor
     *
     * @return BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * This Product Order Belongs to Product
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
