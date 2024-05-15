<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HomePageSetting
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomePageSetting whereValue($value)
 * @mixin \Eloquent
 */
class HomePageSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];
}
