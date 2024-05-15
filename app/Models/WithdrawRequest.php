<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WithdrawRequest
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $method
 * @property float $total_amount
 * @property float $withdraw_amount
 * @property float $withdraw_charge
 * @property string $account_info
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereAccountInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereVendorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereWithdrawAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereWithdrawCharge($value)
 * @mixin \Eloquent
 */
class WithdrawRequest extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
