<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShippingRule
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property float|null $min_cost
 * @property float $cost
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereMinCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShippingRule extends Model
{
    use HasFactory;
}
