<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WithdrawMethod
 *
 * @property int $id
 * @property string $name
 * @property float $minimum_amount
 * @property float $maximum_amount
 * @property float $withdraw_charge
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereMaximumAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereMinimumAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawMethod whereWithdrawCharge($value)
 * @mixin \Eloquent
 */
class WithdrawMethod extends Model
{
    use HasFactory;
}
