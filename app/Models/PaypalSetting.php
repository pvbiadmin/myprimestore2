<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\PaypalSetting
 *
 * @property int $id
 * @property int $status
 * @property int $mode
 * @property string $country
 * @property string $currency_name
 * @property string $currency_icon
 * @property float $currency_rate
 * @property string $client_id
 * @property string $secret_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PaypalSetting newModelQuery()
 * @method static Builder|PaypalSetting newQuery()
 * @method static Builder|PaypalSetting query()
 * @method static Builder|PaypalSetting whereClientId($value)
 * @method static Builder|PaypalSetting whereCountry($value)
 * @method static Builder|PaypalSetting whereCreatedAt($value)
 * @method static Builder|PaypalSetting whereCurrencyIcon($value)
 * @method static Builder|PaypalSetting whereCurrencyName($value)
 * @method static Builder|PaypalSetting whereCurrencyRate($value)
 * @method static Builder|PaypalSetting whereId($value)
 * @method static Builder|PaypalSetting whereMode($value)
 * @method static Builder|PaypalSetting whereSecretKey($value)
 * @method static Builder|PaypalSetting whereStatus($value)
 * @method static Builder|PaypalSetting whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PaypalSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'mode',
        'country',
        'currency_name',
        'currency_icon',
        'currency_rate',
        'client_id',
        'secret_key'
    ];
}
