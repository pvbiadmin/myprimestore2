<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $invoice_id
 * @property int $user_id
 * @property float $subtotal
 * @property float $amount
 * @property string $currency_name
 * @property string $currency_icon
 * @property int $product_quantity
 * @property string $payment_method
 * @property int $payment_status
 * @property string $order_address
 * @property string $shipping_method
 * @property string $coupon
 * @property string $order_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $orderProducts
 * @property-read int|null $order_products_count
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User|null $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAmount($value)
 * @method static Builder|Order whereCoupon($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCurrencyIcon($value)
 * @method static Builder|Order whereCurrencyName($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereInvoiceId($value)
 * @method static Builder|Order whereOrderAddress($value)
 * @method static Builder|Order whereOrderStatus($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order wherePaymentStatus($value)
 * @method static Builder|Order whereProductQuantity($value)
 * @method static Builder|Order whereShippingMethod($value)
 * @method static Builder|Order whereSubtotal($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasFactory;

    /**
     * This Order belongs to User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * This Order Has One Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * This Order Has Many Order Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
